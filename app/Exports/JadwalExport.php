<?php

namespace App\Exports;

use App\Models\Jadwal;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class JadwalExport implements FromArray, WithEvents
{
    protected $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    protected $jam = [
        '07:00-07:50', '07:50-08:30', '08:30-09:10', '09:10-09:50',
        '09:50-10:30', '10:30-11:15', '11:15-12:00', '13:00-13:40',
        '13:40-14:20', '14:20-15:00'
    ];

    public function array(): array
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $rows = [];

        // Header sekolah
        $rows[] = ['JADWAL MENGAJAR GURU SMP ISLAMIYAH WIDODAREN'];
        $rows[] = ['SEMESTER GENAP TAHUN PELAJARAN 2024/2025'];
        $rows[] = []; // Baris kosong

        // Header tabel
        $header = ['Hari', 'Jam Ke', 'Pukul'];
        foreach ($kelasList as $kelas) {
            $header[] = $kelas->nama_kelas;
        }
        $rows[] = $header;

        // Data rows
        foreach ($this->days as $day) {
            foreach ($this->jam as $index => $jamRange) {
                $row = [];

                // Kolom hari - hanya diisi di jam pertama
                $row[] = ($index === 0) ? $day : '';

                // Kolom jam ke
                $row[] = $index + 1;

                // Kolom pukul
                $row[] = $jamRange;

                // Kolom untuk setiap kelas
                foreach ($kelasList as $kelas) {
                    $jadwal = Jadwal::where('hari', $day)
                        ->where('kelas_id', $kelas->id)
                        ->where('jam_mulai', explode('-', $jamRange)[0])
                        ->first();

                    $isi = '';
                    if ($jadwal && $jadwal->mapel) {
                        $mapelNama = $jadwal->mapel->nama_mapel;
                        $guruNama = $jadwal->mapel->guru->nama_guru ?? '';
                        $isi = $mapelNama . ($guruNama ? "\n(" . $guruNama . ")" : '');
                    }
                    $row[] = $isi;
                }

                $rows[] = $row;
            }
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $kelasList = Kelas::orderBy('nama_kelas')->get();
                $kelasCount = $kelasList->count();
                $totalCols = $kelasCount + 3; // +3 untuk kolom Hari, Jam Ke, dan Pukul
                $totalJams = count($this->jam);
                $headerRowStart = 4; // Header tabel dimulai dari baris ke-4
                $dataRowStart = 5; // Data dimulai dari baris ke-5
                $totalRows = (count($this->days) * $totalJams) + $headerRowStart; // Total baris

                // Style untuk header sekolah
                $sheet->mergeCells('A1:' . chr(65 + $totalCols - 1) . '1');
                $sheet->mergeCells('A2:' . chr(65 + $totalCols - 1) . '2');

                $sheet->getStyle('A1:A2')
                    ->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Set alignment untuk semua sel data
                $sheet->getStyle("A{$headerRowStart}:" . $sheet->getHighestColumn() . $sheet->getHighestRow())
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);

                // Style untuk header tabel
                $headerRange = "A{$headerRowStart}:" . chr(65 + $totalCols - 1) . $headerRowStart;
                $sheet->getStyle($headerRange)
                    ->getFont()->setBold(true)
                    ->setSize(12);
                $sheet->getStyle($headerRange)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('4472C4');
                $sheet->getStyle($headerRange)
                    ->getFont()->getColor()->setRGB('FFFFFF');

                // Merge cells untuk hari (kolom A)
                $currentRow = $dataRowStart;
                foreach ($this->days as $day) {
                    $startRow = $currentRow;
                    $endRow = $currentRow + $totalJams - 1;

                    // Merge sel hari
                    $sheet->mergeCells("A{$startRow}:A{$endRow}");

                    // Style untuk hari
                    $sheet->getStyle("A{$startRow}:A{$endRow}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('D9E2F3');
                    $sheet->getStyle("A{$startRow}")
                        ->getFont()->setBold(true)
                        ->setSize(11);

                    $currentRow = $endRow + 1;
                }

                // Style untuk kolom jam ke (kolom B)
                $sheet->getStyle("B{$dataRowStart}:B{$totalRows}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F2F2F2');
                $sheet->getStyle("B{$dataRowStart}:B{$totalRows}")
                    ->getFont()->setBold(true);

                // Style untuk kolom pukul (kolom C)
                $sheet->getStyle("C{$dataRowStart}:C{$totalRows}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F2F2F2');
                $sheet->getStyle("C{$dataRowStart}:C{$totalRows}")
                    ->getFont()->setBold(true);

                // Style untuk area data kelas
                $dataRange = "D{$dataRowStart}:" . chr(65 + $totalCols - 1) . $totalRows;
                $sheet->getStyle($dataRange)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFFFFF');

                // Alternating row colors untuk setiap hari
                $currentRow = $dataRowStart;
                foreach ($this->days as $dayIndex => $day) {
                    $startRow = $currentRow;
                    $endRow = $currentRow + $totalJams - 1;

                    // Warna bergantian untuk setiap hari
                    if ($dayIndex % 2 == 0) {
                        $bgColor = 'F8F9FA';
                    } else {
                        $bgColor = 'FFFFFF';
                    }

                    $dayRange = "D{$startRow}:" . chr(65 + $totalCols - 1) . $endRow;
                    $sheet->getStyle($dayRange)
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($bgColor);

                    $currentRow = $endRow + 1;
                }

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(12); // Hari
                $sheet->getColumnDimension('B')->setWidth(10); // Jam Ke
                $sheet->getColumnDimension('C')->setWidth(15); // Pukul

                // Auto width untuk kolom kelas
                foreach (range('D', chr(65 + $totalCols - 1)) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Set minimum width untuk kolom kelas
                foreach (range('D', chr(65 + $totalCols - 1)) as $col) {
                    if ($sheet->getColumnDimension($col)->getWidth() < 20) {
                        $sheet->getColumnDimension($col)->setWidth(20);
                    }
                }

                // Set row heights
                $sheet->getRowDimension(1)->setRowHeight(25); // Header 1
                $sheet->getRowDimension(2)->setRowHeight(25); // Header 2
                $sheet->getRowDimension(4)->setRowHeight(25); // Header tabel
                for ($row = $dataRowStart; $row <= $totalRows; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(30);
                }

                // Border untuk tabel (mulai dari header tabel)
                $tableRange = "A{$headerRowStart}:" . chr(65 + $totalCols - 1) . $totalRows;
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Border tebal untuk pemisah hari
                $currentRow = $dataRowStart;
                foreach ($this->days as $dayIndex => $day) {
                    if ($dayIndex > 0) { // Mulai dari hari kedua
                        $separatorRange = "A{$currentRow}:" . chr(65 + $totalCols - 1) . $currentRow;
                        $sheet->getStyle($separatorRange)->applyFromArray([
                            'borders' => [
                                'top' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => ['rgb' => '4472C4'],
                                ],
                            ],
                        ]);
                    }
                    $currentRow += $totalJams;
                }

                // Freeze panes untuk header dan kolom hari/jam/pukul
                $sheet->freezePane('D5');
            },
        ];
    }
}
