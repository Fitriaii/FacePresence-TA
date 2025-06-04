<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Siswa_Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Dapatkan ID guru dari relasi user-guru
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        // Ambil jadwal berdasarkan mapel yang diampu guru
        $jadwal = Jadwal::whereHas('mapel', function ($query) use ($guruId) {
            $query->where('guru_id', $guruId);
        })->with(['kelas', 'mapel'])->get();

        // Ambil HANYA mapel yang diampu oleh guru yang login
        $mapels = Mapel::where('guru_id', $guruId)->get();

        // Ambil kelas berdasarkan jadwal yang dimiliki guru saat ini
        $kelasIds = $jadwal->pluck('kelas_id')->unique();
        $kelasList = Kelas::whereIn('id', $kelasIds)->get();

        // Ambil siswa_kelas dari kelas-kelas yang diajar oleh guru
        $siswaKelas = Siswa_Kelas::whereIn('kelas_id', $kelasIds)->with('siswa')->get();

        // Siapkan variabel untuk hasil
        $selectedJadwal = null;
        $presensi = collect();

        if ($request->has('jadwal_id')) {
            $jadwalId = $request->jadwal_id;

            // Ambil informasi jadwal yang dipilih dan pastikan milik guru
            $selectedJadwal = Jadwal::with(['kelas', 'mapel'])
                ->whereHas('mapel', function ($query) use ($guruId) {
                    $query->where('guru_id', $guruId);
                })
                ->where('id', $jadwalId)
                ->first();

            if ($selectedJadwal) {
                // Ambil presensi untuk jadwal tersebut
                $presensi = Presensi::with(['siswa_kelas.siswa', 'jadwal'])
                    ->where('jadwal_id', $jadwalId)
                    ->get();
            }
        } else {
            // Ambil semua presensi untuk semua jadwal guru dan siswa terkait
            $presensi = Presensi::with(['siswa_kelas.siswa', 'jadwal'])
                ->whereIn('jadwal_id', $jadwal->pluck('id'))
                ->whereIn('siswa_kelas_id', $siswaKelas->pluck('id'))
                ->get();
        }

        return view('guru.presensi.index', [
            'presensi' => $presensi,
            'jadwal' => $jadwal,
            'mapels' => $mapels,
            'kelasList' => $kelasList,
            'selectedJadwal' => $selectedJadwal
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        $jadwalId = $request->jadwal_id;

        if (!$jadwalId) {
            return redirect()->route('presensi.index')
                ->with('error', 'Pilih jadwal terlebih dahulu untuk menambah presensi.');
        }

        $jadwal = Jadwal::with(['kelas', 'mapel'])
            ->whereHas('mapel', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->where('id', $jadwalId)
            ->first();

        if (!$jadwal) {
            return redirect()->route('presensi.index')
                ->with('error', 'Jadwal tidak ditemukan atau tidak sesuai dengan guru yang login.');
        }

        // Ambil tanggal hari ini
        $today = now()->toDateString();

        // Ambil data presensi hanya untuk jadwal ini dan tanggal hari ini
        $presensi = Presensi::with(['siswa_kelas', 'jadwal'])
            ->where('jadwal_id', $jadwal->id)
            ->whereDate('waktu_presensi', $today)
            ->get();

        // dd($presensi);

        // Buat mapping siswa_kelas_id => presensi
        $presensiMap = $presensi->keyBy('siswa_kelas_id');

        // Ambil semua siswa dari kelas
        $siswa = Siswa_Kelas::with('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->get()
            ->map(function ($item) use ($presensiMap) {
                $item->sudah_presensi = $presensiMap->has($item->id);
                $item->presensi_data = $presensiMap->get($item->id); // bisa null
                return $item;
            });

        return view('guru.presensi.create', [
            'jadwal' => $jadwal,
            'siswa' => $siswa,
            'presensi' => $presensi,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */

     public function simpanAbsensiManual(Request $request)
     {
         $jadwal_id = $request->input('jadwal_id');
         $tanggal_presensi = now()->toDateString();
         $dataPresensi = $request->input('presensi');

         foreach ($dataPresensi as $data) {
             // Abaikan jika tidak ada siswa_kelas_id (antisipasi input rusak)
             if (empty($data['siswa_kelas_id'])) {
                 continue;
             }

             $siswaKelasId = $data['siswa_kelas_id'];

             // Cek presensi berdasarkan siswa_kelas_id, jadwal_id dan tanggal
             $presensi = Presensi::where('siswa_kelas_id', $siswaKelasId)
                 ->where('jadwal_id', $jadwal_id)
                 ->whereDate('waktu_presensi', $tanggal_presensi)
                 ->first();

             if ($presensi) {
                 // Update jika sudah ada
                 $presensi->update([
                     'status' => $data['status'],
                     'catatan' => $data['catatan'] ?? null,
                 ]);
             } else {
                 // Buat baru jika belum ada
                 Presensi::create([
                     'siswa_kelas_id' => $siswaKelasId,
                     'jadwal_id' => $jadwal_id,
                     'waktu_presensi' => now(),
                     'status' => $data['status'],
                     'catatan' => $data['catatan'] ?? null,
                 ]);
             }
         }

         return redirect()->back()->with('success', 'Presensi manual berhasil disimpan.');
     }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Presensi $presensi)
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $jadwal = $presensi->jadwal()->with(['kelas', 'mapel'])->first();

        if (!$jadwal || $jadwal->mapel->guru_id !== $guru->id) {
            return redirect()->route('presensi.index')->with('error', 'Anda tidak berhak mengedit presensi ini.');
        }

        // Ambil siswa_kelas yang berkaitan dengan presensi ini
        $siswa = $presensi->siswa_kelas()->with('siswa')->first();

        if (!$siswa) {
            return redirect()->route('presensi.index')->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('guru.presensi.edit', [
            'presensi' => $presensi,
            'siswa' => $siswa->siswa,
            'jadwal' => $jadwal,
        ]);
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin,Alpha',
            'catatan' => 'nullable|string',
        ]);

        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $presensi = Presensi::with('jadwal.mapel')->findOrFail($presensi->id);

        // Pastikan guru hanya bisa update presensi miliknya
        if ($presensi->jadwal->mapel->guru_id !== $guru->id) {
            return redirect()->route('presensi.index')->with('error', 'Anda tidak berhak mengedit presensi ini.');
        }

        // Update data presensi
        $presensi->update([
            'status' => $request->input('status'),
            'catatan' => $request->input('catatan'),
        ]);

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        try {
            $presensi->delete();
            return redirect()->route('presensi.index')->with([
                'status' => 'success',
                'message' => 'Siswa berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('presensi.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data presensi: ' . $e->getMessage()
            ]);
        }
    }

    public function showCaptureForm($id)
    {
        $presensi = Presensi::findOrFail($id);
        $siswa = Siswa::all();
        return view('Guru.Presensi.create',  compact('presensi', 'siswa'));
    }

    public function recognizeFace(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        // Decode gambar base64
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('image')));

        // Simpan sementara
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempPath = $tempDir . '/recognize.png';
        file_put_contents($tempPath, $imageData);

        // Jalankan Python
        $pythonScript = base_path('python/face_recognize.py');
        $process = new Process(['python', $pythonScript, $tempPath]);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menjalankan skrip pengenalan wajah.',
                'error' => $process->getErrorOutput()
            ], 500);
        }

        // Ambil output dari Python
        $output = trim($process->getOutput());
        $lines = array_filter(array_map('trim', explode("\n", $output)));

        // Ambil baris terakhir yang valid sebagai NIS
        $recognizedNis = null;
        foreach (array_reverse($lines) as $line) {
            if (preg_match('/^\d{5,}$/', $line)) {
                $recognizedNis = $line;
                break;
            }
        }

        if ($recognizedNis) {
            // Cari siswa dari database
            $siswa = Siswa::where('nis', $recognizedNis)->first();

            if ($siswa) {
                return response()->json([
                    'status' => 'success',
                    'siswa_nis' => $siswa->nis,
                    'nama_siswa' => $siswa->nama_siswa,
                    'raw_output' => $output, // bisa dihapus jika tidak perlu
                ]);
            } else {
                return response()->json([
                    'status' => 'not_recognized',
                    'message' => 'NIS dikenali, tapi tidak ada siswa di database.',
                    'recognized_nis' => $recognizedNis
                ]);
            }
        } else {
            return response()->json([
                'status' => 'face_not_found',
                'message' => 'Wajah tidak dikenali, coba lagi.',
                'recognized_nis' => null,
                'raw_output' => $output
            ]);
        }
    }


    public function markAttendance(Request $request)
    {
        $request->validate([
            'siswa_nis' => 'required|exists:siswa,nis',
            'jadwal_id' => 'required|exists:jadwal,id',
            'status' => 'nullable|in:Hadir,Sakit,Izin,Alfa',
            'waktu_presensi' => 'nullable',
            'catatan' => 'nullable|string',
        ]);

        // Ambil siswa berdasarkan NIS
        $siswa = Siswa::where('nis', $request->siswa_nis)->first();

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan.'
            ]);
        }

        // Ambil data siswa_kelas aktif
        $siswaKelas = Siswa_Kelas::where('siswa_id', $siswa->id)
                        ->latest()
                        ->first();

        if (!$siswaKelas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kelas siswa tidak ditemukan.'
            ]);
        }

        $jadwalId = $request->input('jadwal_id');
        $siswaKelasId = $siswaKelas->id;

        // Cek apakah sudah presensi hari ini
        $sudahPresensi = Presensi::where('siswa_kelas_id', $siswaKelasId)
                                ->where('jadwal_id', $jadwalId)
                                ->whereDate('waktu_presensi', now()->toDateString())
                                ->exists();

        $jadwal = Jadwal::with('mapel', 'kelas')->find($jadwalId);

        if ($sudahPresensi) {
            return response()->json([
                'status' => 'already_marked',
                'message' => 'Presensi sudah tercatat sebelumnya.',
                'data' => [
                    'siswa' => $siswa->nama_siswa
                ]
            ]);
        }

        // Simpan presensi baru
        $presensi = new Presensi();
        $presensi->jadwal_id = $jadwalId;
        $presensi->siswa_kelas_id = $siswaKelasId;
        $presensi->waktu_presensi = now();
        $presensi->status = 'Hadir';
        $presensi->catatan = $request->input('catatan') ?? 'Presensi via pengenalan wajah';
        $presensi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil dicatat.',
            'data' => [
                'siswa' => $siswa->nama_siswa,
                'kelas' => $jadwal->kelas->nama_kelas ?? '-',
                'mapel' => $jadwal->mapel->nama_mapel ?? '-',
                'waktu' => now()->format('d M Y H:i:s'),
                'status' => 'Hadir'
            ]
        ]);
    }




}
