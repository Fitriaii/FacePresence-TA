<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi Siswa</title>
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 15px;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
        }

        /* Header Section */
        .header {
            display: table;
            width: 100%;
            border-bottom: 3px double #000;
            margin-bottom: 18px;
            padding-bottom: 10px;
        }

        .school-info {
            display: table-cell;
            text-align: center;
            padding: 10px 0;
        }

        .school-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 1px;
            text-transform: uppercase;
            color: #000;
        }

        .school-info p {
            font-size: 12pt;
            margin-bottom: 4px;
            font-weight: bold;
            color: #000;
        }

        .school-address {
            font-size: 10pt;
            margin-top: 4px;
            font-style: italic;
            color: #333;
        }

        /* Title Section */
        .title-section {
            text-align: center;
            margin: 6px 0;
            padding: 8px;
        }

        .title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
            color: #000;
        }

        .subtitle {
            font-size: 13pt;
            color: #000;
            font-weight: bold;
        }

        /* Filter Info */
        .filter-info {
            margin: 10px 0;
            padding: 6px;
        }

        .filter-title {
            font-weight: bold;
            margin-bottom: 12px;
            color: #000;
            font-size: 14pt;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
        }


        .filter-item {
            font-size: 10pt;
            background: #f8f9fa;
            padding: 10px 15px;
        }

        .filter-label {
            font-weight: bold;
            color: #000;
            margin-right: 8px;
            min-width: 100px;
            display: inline-block;
        }

        /* Table Section */
        .table-section {
            margin: 16px 0;
            background: #fff;
            overflow-x: auto;
            max-width: 100%;
            box-sizing: border-box;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            table-layout: auto;
            word-wrap: break-word;
        }

        thead {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }

        th {
            color: #000;
            font-weight: bold;
            text-align: center;
            padding: 12px 8px;
            font-size: 11pt;
            border: 1px solid #000;
            text-transform: uppercase;
            position: relative;
            background: #f0f0f0;
            overflow-wrap: break-word;
        }

        td {
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #000;
            font-size: 11pt;
            vertical-align: middle;
            overflow-wrap: break-word;
        }

        /* Penyesuaian per kolom */
        /* Lebar kolom proporsional */
        th:first-child, td:first-child {
            width: 5%;     /* kolom nomor */
            text-align: center;
        }

        th:nth-child(2), td:nth-child(2) {
            width: 20%;    /* nama siswa */
        }

        th:nth-child(3), td:nth-child(3) {
            width: 10%;    /* nis */
        }

        th:nth-child(4), td:nth-child(4) {
            width: 20%;    /* kelas */
        }

        th:nth-child(5), td:nth-child(5),
        th:nth-child(6), td:nth-child(6) {
            width: 22.5%;  /* hadir & keterangan */
            text-align: center;
        }


        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        tbody tr:hover {
            background: #e3f2fd;
        }

        .text-center {
            text-align: center;
        }

        .status-hadir, .status-izin, .status-sakit, .status-alpha {
            padding: 6px 12px;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
            display: inline-block;
            min-width: 40px;
            text-align: center;
            border-radius: 15px;
        }

        .status-hadir {
            background: #d4edda;
            color: #155724;
        }

        .status-izin {
            background: #fff3cd;
            color: #856404;
        }

        .status-sakit {
            background: #f8d7da;
            color: #721c24;
        }

        .status-alpha {
            background: #e2e3e5;
            color: #383d41;
        }

        /* Footer Section - Grid 2 Columns */
        .footer {
            display: table;
            width: 100%;
            margin-top: 40px;
            padding-top: 20px;
            font-size: 14px;
        }

        .footer-section {
            display: table-cell;
            width: 5%;
        }

        .summary {
            display: table-cell;
            text-align: start;
            background: #ffffff;
            padding: 25px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #000;
        }

        .summary-title {
            font-weight: bold;
            margin-bottom: 18px;
            font-size: 14pt;
            text-decoration: underline;
            text-underline-offset: 3px;
            color: #000;
        }

        .summary div {
            margin-bottom: 10px;
            font-size: 12pt;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px dotted #666;
        }

        .summary div strong {
            color: #000;
        }

        .signature {
            display: table-cell;
            vertical-align: middle;         /* ⬅️ untuk rata tengah vertikal */
            text-align: center;
            background: #ffffff;
            padding: 25px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #000;
        }

        .signature-location {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
        }

        .signature-ket {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
        }

        .signature-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 80px;
            color: #000;
        }

        .signature-name {
            font-weight: bold;
            color: #000;
            font-size: 13pt;
            /* border-bottom: 2px solid #000; */
            display: inline-block;
            padding-bottom: 3px;
            margin-bottom: 8px;
            min-width: 200px;
        }

        .signature-nip {
            font-size: 11pt;
            color: #000;
            font-weight: normal;
        }

        /* Print Styles */
        @media print {
            @page {
                margin: 1.5cm;
                size: A4 landscape;
            }

            body {
                background: white;
                padding: 0;
                font-size: 11pt;
            }

            .container {
                padding: 20px;
                max-width: none;
                margin: 0;
            }

            .header {
                border-bottom: 3px double #000;
            }

            .filter-info {
                background: #f8f9fa;
                break-inside: avoid;
            }

            .table-section {
                break-inside: avoid;
            }

            thead {
                background: #e9ecef;
            }

            th {
                background: #e9ecef;
                color: #000;
                border: 1px solid #000;
            }

            td {
                border: 1px solid #000;
            }

            tbody tr:nth-child(even) {
                background: #f8f9fa;
            }

            .status-hadir {
                background: #d4edda;
                color: #155724;
            }

            .status-izin {
                background: #fff3cd;
                color: #856404;
            }

            .status-sakit {
                background: #f8d7da;
                color: #721c24;
            }

            .status-alpha {
                background: #e2e3e5;
                color: #383d41;
            }

            .summary, .signature, .footer {
                break-inside: avoid;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            .header {
                display: block;
                text-align: center;
            }

            .school-info {
                display: block;
                width: 100%;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .footer {
                grid-template-columns: 1fr;
            }

            .table-section {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }

            th, td {
                padding: 8px 6px;
                font-size: 10pt;
            }

            .status-hadir, .status-izin, .status-sakit, .status-alpha {
                padding: 4px 8px;
                font-size: 9pt;
            }
        }

        /* Color Adjustment for Printing */
        .container, .header, .title-section, .filter-info, .table-section, .summary, .signature,
        th, td, .status-hadir, .status-izin, .status-sakit, .status-alpha {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    </style>

</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            {{-- <div class="logo-section">
                <div class="logo-container">
                    <div class="logo-placeholder">LOGO<br>SEKOLAH</div>
                </div>
            </div> --}}
            <div class="school-info">
                <div class="school-name">YAYASAN PENDIDIKAN ISLAMIYAH NGAWI</div>
                <div class="school-name">SEKOLAH MENENGAH PERTAMA</div>
                <div class="school-name">SMP ISLAMIYAH WIDODAREN</div>
                <div class="school-name">NSS. 204050907027 NPSN. 20508466</div>
                <div class="school-address">Alamat: Kedungprahu, Widodaren, Ngawi. Kode Pos 63256</div>
            </div>
        </div>

        <!-- Judul Laporan -->
        <div class="title-section">
            <div class="title">Laporan Presensi Siswa</div>
            <div class="title">Tahun Pelajaran {{ date('Y') }}/{{ date('Y')+1 }}</div>
        </div>

        <!-- Info Filter -->
        <div class="filter-info">
            <div class="filter-title">Parameter Laporan</div>
            <div class="filter-grid">
                {{-- Periode --}}
                <div class="filter-item">
                    <span class="filter-label">Periode:</span> {{ ucfirst($filter['periode'] ?? 'Semua') }}
                </div>

                {{-- Tanggal (Harian) --}}
                @if(isset($filter['tanggal']))
                    <div class="filter-item">
                        <span class="filter-label">Tanggal:</span>
                        {{ \Carbon\Carbon::parse($filter['tanggal'])->format('d/m/Y') }}
                    </div>
                @endif

                {{-- Bulanan --}}
                @if(isset($filter['bulan']) && isset($filter['tahun']))
                    <div class="filter-item">
                        <span class="filter-label">Bulan:</span> {{ $filter['bulan'] }}/{{ $filter['tahun'] }}
                    </div>
                @endif

                {{-- Tahunan --}}
                @if(isset($filter['tahun']) && $filter['periode'] === 'tahunan')
                    <div class="filter-item">
                        <span class="filter-label">Tahun:</span> {{ $filter['tahun'] }}
                    </div>
                @endif

                {{-- Rentang Tanggal (Custom) --}}
                @if(isset($filter['start_date']) && isset($filter['end_date']))
                    <div class="filter-item">
                        <span class="filter-label">Rentang Tanggal:</span>
                        {{ \Carbon\Carbon::parse($filter['start_date'])->format('d/m/Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($filter['end_date'])->format('d/m/Y') }}
                    </div>
                @endif

                {{-- Tahun Ajaran --}}
                @if(isset($filter['tahun_ajaran']))
                    <div class="filter-item">
                        <span class="filter-label">Tahun Ajaran:</span> {{ $filter['tahun_ajaran'] }}
                    </div>
                @endif

                {{-- Kelas --}}
                @if(isset($filter['kelas']))
                    <div class="filter-item">
                        <span class="filter-label">Kelas:</span> {{ $filter['kelas'] }}
                    </div>
                @endif

                {{-- Mata Pelajaran --}}
                @if(isset($filter['mapel']))
                    <div class="filter-item">
                        <span class="filter-label">Mata Pelajaran:</span> {{ $filter['mapel'] }}
                    </div>
                @endif

                {{-- Pencarian --}}
                @if(isset($filter['search']))
                    <div class="filter-item">
                        <span class="filter-label">Kata Kunci:</span> "{{ $filter['search'] }}"
                    </div>
                @endif

                {{-- Tanggal Cetak --}}
                <div class="filter-item">
                    <span class="filter-label">Tanggal Cetak:</span>
                    {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        <!-- Tabel Presensi -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpha</th>
                        <th>Total</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $item['nama'] }}</strong></td>
                        <td class="text-center">{{ $item['nis'] }}</td>
                        <td class="text-center">{{ $item['kelas'] }}</td>
                        <td class="text-center"><span class="status-hadir">{{ $item['hadir'] }}</span></td>
                        <td class="text-center"><span class="status-izin">{{ $item['izin'] }}</span></td>
                        <td class="text-center"><span class="status-sakit">{{ $item['sakit'] }}</span></td>
                        <td class="text-center"><span class="status-alpha">{{ $item['alpha'] }}</span></td>
                        <td class="text-center"><strong>{{ $item['total'] }}</strong></td>
                        <td class="text-center"><strong>{{ $item['presentase'] }}%</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Ringkasan dan Tanda Tangan - Grid 2 Kolom -->
        <div class="footer">
            <div class="summary">
                <div class="summary-title">Ringkasan Data Presensi</div>
                <div><strong>Total Siswa:</strong> {{ count($rekap) }} siswa</div>
                <div><strong>Total Record:</strong> {{ count($presensi) }} data</div>
                @php
                    $statusCount = [
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alpha' => 0
                    ];
                    foreach($presensi as $p) {
                        $status = strtolower($p->status);
                        if($status === 'hadir') $statusCount['hadir']++;
                        elseif($status === 'izin') $statusCount['izin']++;
                        elseif($status === 'sakit') $statusCount['sakit']++;
                        elseif(in_array($status, ['alpha', 'tidak hadir'])) $statusCount['alpha']++;
                    }
                @endphp
                <div><strong>Jumlah Hadir:</strong> {{ $statusCount['hadir'] }}</div>
                <div><strong>Jumlah Izin:</strong> {{ $statusCount['izin'] }}</div>
                <div><strong>Jumlah Sakit:</strong> {{ $statusCount['sakit'] }}</div>
                <div><strong>Jumlah Alpha:</strong> {{ $statusCount['alpha'] }}</div>
            </div>
            <div class="footer-section"></div>
            <div class="signature">
                <div class="signature-location">Widodaren, {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
                <div class="signature-ket">Mengetahui,</div>
                <div class="signature-title">Kepala SMP Islamiyah Widodaren</div>
                {{-- <div class="signature-name">{{ auth()->user()->name }}</div> --}}
                <div class="signature-name">(Masyfu'ati Masyrofah, S.Pd)</div>
                {{-- <div class="signature-nip">NIP. {{ auth()->user()->nip ?? '-' }}</div> --}}
            </div>

        </div>
    </div>
</body>
</html>
