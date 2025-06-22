<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Siswa_Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

        // Ambil data guru dari user
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        // Ambil semua jadwal yang diajar oleh guru
        $jadwal = Jadwal::whereHas('mapel', function ($query) use ($guruId) {
            $query->where('guru_id', $guruId);
        })->with(['kelas', 'mapel'])->get();

        // Ambil hanya mapel yang diampu guru
        $mapels = Mapel::where('guru_id', $guruId)->get();

        // Ambil daftar kelas dari jadwal yang dimiliki guru
        $kelasIds = $jadwal->pluck('kelas_id')->unique();
        $kelasList = Kelas::whereIn('id', $kelasIds)->get();

        // Variabel hasil
        $selectedJadwal = null;
        $presensi = null;
        $siswaKelas = collect();

        if ($request->has('jadwal_id')) {
            $jadwalId = $request->jadwal_id;

            // Pastikan jadwal tersebut milik guru
            $selectedJadwal = Jadwal::with(['kelas', 'mapel'])
                ->whereHas('mapel', function ($query) use ($guruId) {
                    $query->where('guru_id', $guruId);
                })
                ->where('id', $jadwalId)
                ->first();

            if ($selectedJadwal) {
                // Ambil siswa yang sesuai dengan kelas pada jadwal tersebut
                $siswaKelas = Siswa_Kelas::where('kelas_id', $selectedJadwal->kelas_id)
                    ->with('siswa')
                    ->get();

                // Ambil data presensi dengan paginasi
                $presensi = Presensi::with(['siswa_kelas.siswa', 'jadwal'])
                    ->where('jadwal_id', $jadwalId)
                    ->whereIn('siswa_kelas_id', $siswaKelas->pluck('id'))
                    ->paginate(10)
                    ->appends($request->query());
            }
        } else {
            // Ambil semua siswa dari kelas-kelas yang diampu guru
            $siswaKelas = Siswa_Kelas::whereIn('kelas_id', $kelasIds)->with('siswa')->get();

            // Ambil semua presensi dari jadwal guru dan siswa yang sesuai kelas, dengan paginasi
            $presensi = Presensi::with(['siswa_kelas.siswa', 'jadwal'])
                ->whereIn('jadwal_id', $jadwal->pluck('id'))
                ->whereIn('siswa_kelas_id', $siswaKelas->pluck('id'))
                ->paginate(10)
                ->appends($request->query());
        }

        return view('guru.presensi.index', [
            'presensi' => $presensi,
            'jadwal' => $jadwal,
            'mapels' => $mapels,
            'kelasList' => $kelasList,
            'selectedJadwal' => $selectedJadwal,
            'siswaKelas' => $siswaKelas
        ]);
    }

    public function create(){}
    /**
     * Show the form for creating a new resource.
     */
    public function createPresensi($jadwalId)
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        // Pastikan jadwal milik guru tersebut
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

        $today = now()->toDateString();

        $presensi = Presensi::with(['siswa_kelas.siswa', 'jadwal'])
            ->where('jadwal_id', $jadwal->id)
            ->whereDate('waktu_presensi', $today)
            ->get();

        $presensiMap = $presensi->keyBy('siswa_kelas_id');

        $siswa = Siswa_Kelas::with('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->get()
            ->map(function ($item) use ($presensiMap) {
                $item->sudah_presensi = $presensiMap->has($item->id);
                $item->presensi_data = $presensiMap->get($item->id);
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
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ]);
        }

        $presensi = Presensi::with('jadwal.mapel')->findOrFail($presensi->id);

        // Cek kepemilikan data
        if ($presensi->jadwal->mapel->guru_id !== $guru->id) {
            return redirect()->route('presensi.index')->with([
                'status' => 'error',
                'message' => 'Anda tidak berhak mengedit presensi ini.'
            ]);
        }

        // Update presensi
        $presensi->update([
            'status' => $request->input('status'),
            'catatan' => $request->input('catatan'),
        ]);

        return redirect()->route('presensi.index')->with([
            'status' => 'success',
            'message' => 'Presensi berhasil diperbarui.'
        ]);
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

    // public function recognizeFace(Request $request)
    // {
    //     $pythonApiUrl = 'http://127.0.0.1:5000/recognize';

    //     try {
    //         if ($request->has('image_url')) {
    //             // ✅ Kasus 1: URL gambar
    //             $imageData = file_get_contents($request->input('image_url'));
    //             $base64 = base64_encode($imageData);

    //         } elseif ($request->hasFile('image_file')) {
    //             // ✅ Kasus 2: Upload file (multipart)
    //             $file = $request->file('image_file');
    //             $imageData = file_get_contents($file->getRealPath());
    //             $base64 = base64_encode($imageData);

    //         } elseif ($request->has('image')) {
    //             // ✅ Kasus 3: Base64 string
    //             $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $request->input('image'));

    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Tidak ada gambar yang dikirim. Gunakan image_url, image_file, atau image (base64).',
    //             ], 422);
    //         }

    //         // Kirim ke Flask
    //         $response = Http::timeout(10)->post($pythonApiUrl, [
    //             'image' => $base64,
    //         ]);

    //         if (!$response->successful()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gagal menghubungi API Python.',
    //                 'error' => $response->body(),
    //             ], 500);
    //         }

    //         $data = $response->json();

    //         // === Respons sukses ===
    //         if ($data['status'] === 'success' && isset($data['nis'])) {
    //             $siswa = Siswa::where('nis', $data['nis'])->first();

    //             if ($siswa) {
    //                 return response()->json([
    //                     'status' => 'success',
    //                     'message' => 'Wajah dikenali.',
    //                     'siswa_nis' => $siswa->nis,
    //                     'nama_siswa' => $siswa->nama_siswa,
    //                     'confidence' => round($data['confidence'] ?? 0, 2),
    //                 ]);
    //             } else {
    //                 return response()->json([
    //                     'status' => 'nis_not_found',
    //                     'message' => 'Wajah dikenali, tapi NIS tidak ditemukan di database.',
    //                     'siswa_nis' => $data['siswa_nis'],
    //                     'confidence' => round($data['confidence'] ?? 0, 2),
    //                 ]);
    //             }
    //         }

    //         // === Wajah tidak dikenali ===
    //         if ($data['status'] === 'fail') {
    //             return response()->json([
    //                 'status' => 'unrecognized',
    //                 'message' => 'Wajah tidak dikenali.',
    //                 'confidence' => round($data['confidence'] ?? 0, 2),
    //             ]);
    //         }

    //         // === Tidak ditemukan wajah ===
    //         if ($data['status'] === 'face_not_found') {
    //             return response()->json([
    //                 'status' => 'face_not_found',
    //                 'message' => $data['message'] ?? 'Tidak ada wajah terdeteksi.',
    //             ]);
    //         }

    //         // === Respons tidak dikenali ===
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Respons tidak dikenali dari API Python.',
    //             'raw_response' => $data,
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal memproses permintaan ke API Python.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    // public function markAttendance(Request $request)
    // {
    //     $request->validate([
    //         'siswa_nis' => 'required|exists:siswa,nis',
    //         'jadwal_id' => 'required|exists:jadwal,id',
    //         'status' => 'nullable|in:Hadir,Sakit,Izin,Alfa',
    //         'waktu_presensi' => 'nullable',
    //         'catatan' => 'nullable|string',
    //     ]);

    //     // Ambil siswa berdasarkan NIS
    //     $siswa = Siswa::where('nis', $request->siswa_nis)->first();

    //     if (!$siswa) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Siswa tidak ditemukan.'
    //         ]);
    //     }

    //     // Ambil data siswa_kelas aktif
    //     $siswaKelas = Siswa_Kelas::where('siswa_id', $siswa->id)
    //                     ->latest()
    //                     ->first();

    //     if (!$siswaKelas) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Data kelas siswa tidak ditemukan.'
    //         ]);
    //     }

    //     $jadwalId = $request->input('jadwal_id');
    //     $jadwal = Jadwal::with('mapel', 'kelas')->find($jadwalId);

    //     // ✅ Tambahkan validasi apakah siswa ada di kelas sesuai jadwal
    //     if ($siswaKelas->kelas_id !== $jadwal->kelas_id) {
    //         return response()->json([
    //             'status' => 'invalid_class',
    //             'message' => 'Siswa tidak terdaftar di kelas sesuai jadwal.',
    //             'data' => [
    //                 'siswa' => $siswa->nama_siswa,
    //                 'kelas' => $jadwal->kelas->nama_kelas ?? '-'
    //             ]
    //         ]);
    //     }

    //     $sudahPresensi = Presensi::where('siswa_kelas_id', $siswaKelas->id)
    //                             ->where('jadwal_id', $jadwalId)
    //                             ->whereDate('waktu_presensi', now()->toDateString())
    //                             ->exists();

    //     if ($sudahPresensi) {
    //         return response()->json([
    //             'status' => 'already_marked',
    //             'message' => 'Presensi sudah tercatat sebelumnya.',
    //             'data' => [
    //                 'siswa' => $siswa->nama_siswa
    //             ]
    //         ]);
    //     }

    //     // Simpan presensi baru
    //     $presensi = new Presensi();
    //     $presensi->jadwal_id = $jadwalId;
    //     $presensi->siswa_kelas_id = $siswaKelas->id;
    //     $presensi->waktu_presensi = now();
    //     $presensi->status = 'Hadir';
    //     $presensi->catatan = $request->input('catatan') ?? 'Presensi via pengenalan wajah';
    //     $presensi->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Presensi berhasil dicatat.',
    //         'data' => [
    //             'siswa' => $siswa->nama_siswa,
    //             'kelas' => $jadwal->kelas->nama_kelas ?? '-',
    //             'mapel' => $jadwal->mapel->nama_mapel ?? '-',
    //             'waktu' => now()->format('d M Y H:i:s'),
    //             'status' => 'Hadir'
    //         ]
    //     ]);
    // }


    // public function recognizeAndMark(Request $request)
    // {
    //     $pythonApiUrl = 'http://127.0.0.1:5000/recognize';
    //     $confidenceThreshold = 70;

    //     $request->validate([
    //         'jadwal_id' => 'required|exists:jadwal,id',
    //         'image' => 'nullable|string',
    //         'image_url' => 'nullable|url',
    //         'image_file' => 'nullable|file|image',
    //     ]);

    //     try {
    //         // Ambil gambar
    //         if ($request->has('image_url')) {
    //             $imageData = @file_get_contents($request->input('image_url'));
    //             if (!$imageData) {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'Gagal mengambil gambar dari URL.',
    //                 ], 422);
    //             }
    //             $base64 = base64_encode($imageData);
    //         } elseif ($request->hasFile('image_file')) {
    //             $file = $request->file('image_file');
    //             $imageData = file_get_contents($file->getRealPath());
    //             $base64 = base64_encode($imageData);
    //         } elseif ($request->filled('image')) {
    //             $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $request->input('image'));
    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gambar tidak ditemukan. Kirim image, image_file, atau image_url.',
    //             ], 422);
    //         }

    //         // Kirim ke API Python
    //         $response = Http::timeout(10)->post($pythonApiUrl, [
    //             'image' => $base64,
    //         ]);

    //         if (!$response->successful()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gagal menghubungi API Python.',
    //                 'error' => $response->body(),
    //             ], 500);
    //         }

    //         $data = $response->json();
    //         $confidence = round($data['confidence'] ?? 999, 2);
    //         $nis = $data['nis'] ?? null;

    //         // Jika pengenalan tidak sukses atau confidence rendah
    //         if (($data['status'] !== 'success') || !$nis) {
    //             return response()->json([
    //                 'status' => 'unrecognized',
    //                 'message' => 'Wajah tidak dikenali.',
    //                 'confidence' => $confidence,
    //             ], 200);
    //         }

    //         if ($confidence > $confidenceThreshold) {
    //             return response()->json([
    //                 'status' => 'low_confidence',
    //                 'message' => 'Confidence terlalu rendah untuk validasi.',
    //                 'confidence' => $confidence,
    //             ], 200);
    //         }

    //         // Validasi NIS & siswa
    //         $siswa = Siswa::where('nis', $nis)->first();
    //         if (!$siswa) {
    //             return response()->json([
    //                 'status' => 'nis_not_found',
    //                 'message' => 'NIS tidak ditemukan di database.',
    //                 'nis' => $nis,
    //                 'confidence' => $confidence,
    //             ], 404);
    //         }

    //         // Ambil data kelas siswa terbaru
    //         $siswaKelas = Siswa_Kelas::where('siswa_id', $siswa->id)->latest()->first();
    //         if (!$siswaKelas) {
    //             return response()->json([
    //                 'status' => 'no_class_data',
    //                 'message' => 'Data kelas siswa tidak ditemukan.',
    //             ], 404);
    //         }

    //         // Validasi jadwal & kelas
    //         $jadwal = Jadwal::with('mapel', 'kelas')->find($request->jadwal_id);
    //         if (!$jadwal || $siswaKelas->kelas_id !== $jadwal->kelas_id) {
    //             return response()->json([
    //                 'status' => 'invalid_class',
    //                 'message' => 'Siswa tidak terdaftar di kelas sesuai jadwal.',
    //                 'data' => [
    //                     'siswa' => $siswa->nama_siswa,
    //                     'kelas_jadwal' => $jadwal->kelas->nama_kelas ?? '-',
    //                     'kelas_siswa' => $siswaKelas->kelas->nama_kelas ?? '-',
    //                 ]
    //             ], 403);
    //         }

    //         // Cek apakah sudah presensi hari ini
    //         $sudahPresensi = Presensi::where('siswa_kelas_id', $siswaKelas->id)
    //             ->where('jadwal_id', $jadwal->id)
    //             ->whereDate('waktu_presensi', now()->toDateString())
    //             ->exists();

    //         if ($sudahPresensi) {
    //             return response()->json([
    //                 'status' => 'already_marked',
    //                 'message' => 'Presensi sudah dicatat sebelumnya.',
    //                 'data' => [
    //                     'siswa' => $siswa->nama_siswa,
    //                     'confidence' => $confidence,
    //                 ]
    //             ], 200);
    //         }

    //         // Simpan presensi
    //         $presensi = Presensi::create([
    //             'jadwal_id' => $jadwal->id,
    //             'siswa_kelas_id' => $siswaKelas->id,
    //             'waktu_presensi' => now(),
    //             'status' => 'Hadir',
    //             'catatan' => 'Presensi otomatis via Face Recognition',
    //         ]);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Presensi berhasil dicatat.',
    //             'data' => [
    //                 'siswa' => $siswa->nama_siswa,
    //                 'kelas' => $jadwal->kelas->nama_kelas ?? '-',
    //                 'mapel' => $jadwal->mapel->nama_mapel ?? '-',
    //                 'waktu' => $presensi->waktu_presensi->format('d M Y H:i:s'),
    //                 'confidence' => $confidence,
    //                 'status' => 'Hadir'
    //             ]
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal memproses presensi otomatis.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }


    public function recognizeAndMark(Request $request)
    {
        $pythonApiUrl = 'http://127.0.0.1:5000/recognize';

        // Amang batas jarak untuk pengenalan wajah. Nilai lebih rendah = lebih baik.
        // Sesuaikan nilai ini berdasarkan kalibrasi model Python Anda.
        // Misalnya:
        // - Jarak <= 70: Dianggap 'Hadir' (recognized_threshold)
        // - Jarak > 70 dan <= 90: Dianggap 'low_confidence' (low_confidence_threshold)
        // - Jarak > 90: Dianggap 'unrecognized'
        $recognizedThreshold = 70;
        $lowConfidenceThreshold = 90;

        // Validasi input dari frontend
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'image' => 'required|string', // Pastikan 'image' selalu ada dari frontend kamera
        ]);

        try {
            // Ambil base64 image dari request (frontend mengirim ini dari canvas)
            $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->input('image'));

            // Kirim ke API Python untuk pengenalan wajah
            $response = Http::timeout(15)->post($pythonApiUrl, [ // Timeout diperpanjang sedikit
                'image' => $base64Image,
            ]);

            // Cek apakah koneksi ke API Python gagal
            if (!$response->successful()) {
                Log::error('Gagal menghubungi API Python: ' . $response->body(), ['status_code' => $response->status()]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal terhubung ke layanan pengenalan wajah.',
                    'detail' => 'Koneksi ke API Python gagal atau ada masalah di sana.' // Pesan lebih user-friendly
                ], 500);
            }

            $data = $response->json();
            $statusFromPython = $data['status'] ?? 'unknown_status';
            $nis = $data['nis'] ?? null;
            $confidence = round($data['confidence'] ?? 999, 2); // Confidence dari Python adalah jarak

            // Log respons dari Python untuk debugging
            Log::info('Respons dari API Python:', $data);

            // === Tentukan Status Berdasarkan Respons Python ===
            if ($statusFromPython === 'face_not_found') {
                return response()->json([
                    'status' => 'face_not_found',
                    'message' => $data['message'] ?? 'Wajah tidak terdeteksi dalam gambar. Pastikan wajah Anda di tengah frame.',
                ], 200);
            }

            if ($statusFromPython === 'unrecognized') {
                return response()->json([
                    'status' => 'unrecognized',
                    'message' => $data['message'] ?? 'Wajah tidak dikenali atau tidak terdaftar. Pastikan Anda adalah siswa yang terdaftar.',
                    'confidence' => $confidence,
                ], 200);
            }

            // Jika statusnya bukan success dari Python, atau NIS kosong
            if ($statusFromPython !== 'success' || !$nis) {
                 return response()->json([
                    'status' => 'unrecognized', // Atau status spesifik jika Python memberikan lebih banyak detail
                    'message' => $data['message'] ?? 'Pengenalan wajah tidak berhasil.',
                    'confidence' => $confidence,
                ], 200);
            }

            // Jika sampai sini, berarti Python mengembalikan status 'success' (NIS ditemukan)
            // Sekarang evaluasi confidence (jarak) dari Python
            if ($confidence >= $lowConfidenceThreshold) {
                // Jarak terlalu tinggi, berarti confidence rendah (tidak dikenali)
                return response()->json([
                    'status' => 'unrecognized',
                    'message' => 'Wajah terdeteksi tapi tidak dikenali dengan tingkat kepercayaan yang memadai (jarak: ' . $confidence . ').',
                    'confidence' => $confidence,
                ], 200);
            } elseif ($confidence >= $recognizedThreshold && $confidence < $lowConfidenceThreshold) {
                // Jarak di antara threshold, masih bisa dikenali tapi confidence rendah
                return response()->json([
                    'status' => 'low_confidence',
                    'message' => 'Wajah terdeteksi dengan NIS ' . $nis . ' tapi tingkat kepercayaan rendah (jarak: ' . $confidence . ').',
                    'nis' => $nis, // Kembalikan NIS agar frontend bisa menampilkan info siswa
                    'confidence' => $confidence,
                ], 200);
            }

            // Jika confidence < recognizedThreshold, berarti pengenalan berhasil (status 'success' dari Python dan jarak bagus)

            // Validasi NIS & siswa di database Laravel
            $siswa = Siswa::where('nis', $nis)->first();
            if (!$siswa) {
                return response()->json([
                    'status' => 'nis_not_found',
                    'message' => 'NIS (' . $nis . ') yang dikenali tidak ditemukan di database siswa.',
                    'nis' => $nis,
                    'confidence' => $confidence,
                ], 404);
            }

            // Ambil data kelas siswa terbaru
            $siswaKelas = Siswa_Kelas::where('siswa_id', $siswa->id)->latest()->first();
            if (!$siswaKelas) {
                return response()->json([
                    'status' => 'no_class_data',
                    'message' => 'Data kelas untuk siswa ' . $siswa->nama_siswa . ' tidak ditemukan.',
                ], 404);
            }

            // Validasi jadwal & kelas: Pastikan siswa terdaftar di kelas yang sesuai dengan jadwal
            $jadwal = Jadwal::with('mapel', 'kelas')->find($request->jadwal_id);
            if (!$jadwal || $siswaKelas->kelas_id !== $jadwal->kelas_id) {
                return response()->json([
                    'status' => 'invalid_class',
                    'message' => 'Siswa ' . $siswa->nama_siswa . ' tidak terdaftar di kelas ' . ($jadwal->kelas->nama_kelas ?? '-') . ' sesuai jadwal.',
                    'data' => [
                        'siswa' => $siswa->nama_siswa,
                        'kelas_jadwal' => $jadwal->kelas->nama_kelas ?? '-',
                        'kelas_siswa' => $siswaKelas->kelas->nama_kelas ?? '-',
                        'confidence' => $confidence,
                    ]
                ], 403);
            }

            // Cek apakah siswa sudah presensi untuk jadwal ini hari ini
            $sudahPresensi = Presensi::where('siswa_kelas_id', $siswaKelas->id)
                ->where('jadwal_id', $jadwal->id)
                ->whereDate('waktu_presensi', Carbon::now()->toDateString()) // Menggunakan Carbon
                ->exists();

            if ($sudahPresensi) {
                return response()->json([
                    'status' => 'already_marked',
                    'message' => 'Presensi siswa ' . $siswa->nama_siswa . ' sudah dicatat sebelumnya untuk jadwal ini.',
                    'data' => [
                        'siswa' => $siswa->nama_siswa,
                        'confidence' => $confidence,
                    ]
                ], 200);
            }

            // Jika semua validasi lolos, simpan presensi
            $presensi = Presensi::create([
                'jadwal_id' => $jadwal->id,
                'siswa_kelas_id' => $siswaKelas->id,
                'waktu_presensi' => Carbon::now(), // Menggunakan Carbon
                'status' => 'Hadir',
                'catatan' => 'Presensi otomatis via Face Recognition',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil dicatat!',
                'data' => [
                    'siswa' => $siswa->nama_siswa,
                    'kelas' => $jadwal->kelas->nama_kelas ?? '-',
                    'mapel' => $jadwal->mapel->nama_mapel ?? '-',
                    'waktu' => $presensi->waktu_presensi->format('d M Y H:i:s'),
                    'confidence' => $confidence,
                    'status' => 'Hadir'
                ]
            ], 200);

        } catch (\Exception $e) {
            // Log error yang tidak terduga
            Log::error('Kesalahan tak terduga saat memproses presensi otomatis: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan internal server. Silakan coba lagi nanti.',
                // Jangan tampilkan $e->getMessage() di produksi untuk keamanan
                // 'debug_error' => $e->getMessage(),
            ], 500);
        }
    }
}
