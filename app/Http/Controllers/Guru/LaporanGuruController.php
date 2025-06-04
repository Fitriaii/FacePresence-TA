<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Presensi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class LaporanGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = $request->user();

    // 🔒 Cek apakah user adalah guru
    if (!$user || !$user->hasRole('guru')) {
        return redirect()->back()->with([
            'status' => 'error',
            'code' => 403,
            'message' => 'Unauthorized. Only guru can perform this action.'
        ]);
    }

    // Ambil data guru berdasarkan user_id
    $guru = Guru::where('user_id', $user->id)->firstOrFail();

    // Ambil semua presensi yang berkaitan dengan jadwal yang diajar guru ini
    $query = Presensi::with([
            'siswa_kelas.siswa',
            'siswa_kelas.kelas',
            'siswa_kelas.tahunAjaran',
            'jadwal.kelas',
            'jadwal.mapel.guru'
        ])
        ->whereHas('jadwal.mapel', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->join('jadwal', 'presensi.jadwal_id', '=', 'jadwal.id')
        ->join('siswa_kelas', 'presensi.siswa_kelas_id', '=', 'siswa_kelas.id')
        ->select('presensi.*')
        ->orderBy('presensi.waktu_presensi', 'desc');

    // Filter: Tahun Ajaran
    if ($tahunAjaranId = $request->input('tahun_ajaran_id')) {
        $query->whereHas('siswa_kelas.tahunAjaran', function ($q) use ($tahunAjaranId) {
            $q->where('id', $tahunAjaranId);
        });
    }

    // Filter: Kelas yang diampu
    if ($kelasId = $request->input('kelas_id')) {
        $query->where('jadwal.kelas_id', $kelasId);
    }

    // Filter: Mapel
    if ($mapelId = $request->input('mapel_id')) {
        $query->where('jadwal.mapel_id', $mapelId);
    }

    // Filter: Jenis Kelas
    if ($jenisKelas = $request->input('jenis_kelas')) {
        $query->whereHas('jadwal.kelas', function ($q) use ($jenisKelas) {
            $q->where('jenis_kelas', $jenisKelas);
        });
    }

    // Filter: Periode
    switch ($request->input('periode')) {
        case 'harian':
            if ($tanggal = $request->input('tanggal')) {
                $query->whereDate('presensi.waktu_presensi', $tanggal);
            }
            break;
        case 'mingguan':
        case 'custom':
            if ($start = $request->input('start_date') && $end = $request->input('end_date')) {
                $query->whereBetween('presensi.waktu_presensi', [$start, $end]);
            }
            break;
        case 'bulanan':
            if ($bulan = $request->input('bulan')) {
                $query->whereMonth('presensi.waktu_presensi', $bulan);
            }
            if ($tahun = $request->input('tahun')) {
                $query->whereYear('presensi.waktu_presensi', $tahun);
            }
            break;
        case 'tahunan':
            if ($tahun = $request->input('tahun')) {
                $query->whereYear('presensi.waktu_presensi', $tahun);
            }
            break;
    }

    // Search
    if ($keyword = $request->input('search')) {
        $query->where(function ($q) use ($keyword) {
            $q->whereHas('siswa_kelas.siswa', function ($q) use ($keyword) {
                $q->where('nama_siswa', 'like', "%{$keyword}%")
                    ->orWhere('nis', 'like', "%{$keyword}%");
            })->orWhereHas('jadwal.mapel', function ($q) use ($keyword) {
                $q->where('nama_mapel', 'like', "%{$keyword}%");
            })->orWhereHas('jadwal.kelas', function ($q) use ($keyword) {
                $q->where('nama_kelas', 'like', "%{$keyword}%");
            });
        });
    }

    $data = $query->paginate(10);

    // Rekap per siswa
    $rekapPerSiswa = collect($data->items())->groupBy('siswa_kelas_id')->map(function ($presensis) {
        $siswaKelas = $presensis->first()->siswa_kelas;
        $siswa = $siswaKelas->siswa ?? null;
        $kelas = $presensis->first()->jadwal->kelas ?? null;

        $hadir = $presensis->where('status', 'Hadir')->count();
        $izin = $presensis->where('status', 'Izin')->count();
        $sakit = $presensis->where('status', 'Sakit')->count();
        $alpha = $presensis->where('status', 'Alpha')->count();
        $total = $presensis->count();

        $presentase = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

        return [
            'nama' => $siswa?->nama_siswa ?? '-',
            'nis' => $siswa?->nis ?? '-',
            'kelas' => $kelas?->nama_kelas ?? '-',
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha,
            'total' => $total,
            'presentase' => $presentase,
        ];
    })->values();

    return view('Guru.laporanGuru', [
        'user' => $user,
        'data' => $data,
        'rekapPerSiswa' => $rekapPerSiswa,
        'semuaKelas' => Kelas::whereHas('jadwal.mapel', fn($q) => $q->where('guru_id', $guru->id))->orderBy('nama_kelas')->get(),
        'semuaMapel' => Mapel::where('guru_id', $guru->id)->orderBy('nama_mapel')->get(),
        'semuaTahunAjaran' => TahunAjaran::orderBy('tahun_ajaran', 'desc')->get(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
