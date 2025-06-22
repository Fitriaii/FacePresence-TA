<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
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
use Illuminate\Support\Facades\Log;

class GuruDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $hariIni = Carbon::now()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i:s');
        $hariNama = ucfirst(Carbon::now()->locale('id')->isoFormat('dddd'));

        $guru = Guru::where('user_id', $user->id)->first();
        // 1. Ambil ID mapel yang diampu guru
        $mapelIds = Mapel::where('guru_id', $guru->id)->pluck('id');

        // 2. Ambil semua kelas_id dari jadwal yang berkaitan
        $kelasIds = Jadwal::whereIn('mapel_id', $mapelIds)->pluck('kelas_id')->unique();

        // 3. Hitung jumlah kelas diampu
        $jumlahKelasDiampu = $kelasIds->count();

        // 4. Hitung kelas aktif hari ini
        $kelasAktifHariIni = Jadwal::where('hari', $hariNama)
            ->whereIn('mapel_id', $mapelIds)
            ->pluck('kelas_id')
            ->unique()
            ->count();

        // 5. Total siswa yang diajar guru ini
        $totalSiswaDiampu = Siswa_Kelas::whereIn('kelas_id', $kelasIds)->count();

        // 6. Jadwal hari ini
        $jadwalHariIni = Jadwal::where('hari', $hariNama)
        ->whereIn('mapel_id', $mapelIds)
        ->orderBy('jam_mulai')
        ->get();

        // Ambil ID-nya sebagai koleksi
        $jadwalIdsHariIni = $jadwalHariIni->pluck('id');
        $jumlahJadwalHariIni = $jadwalHariIni->count();

        // 7. Presensi hari ini
        $presensiHariIni = Presensi::whereIn('jadwal_id', $jadwalIdsHariIni)
            ->whereDate('waktu_presensi', $hariIni)
            ->get();

        $totalPresensi = $presensiHariIni->count();
        $hadir = $presensiHariIni->where('status', 'Hadir')->count();
        $rataRataKehadiran = $totalPresensi > 0 ? round(($hadir / $totalPresensi) * 100, 1) : 0;

        // 8. Jumlah presensi per jadwal (hari ini)
        $jumlahPresensiHariIni = $presensiHariIni->pluck('jadwal_id')->unique()->count();

        // 9. Siswa alpha hari ini
        $siswaAlpha = $presensiHariIni->where('status', 'Alpha')->count();

        // 10. Jadwal selanjutnya
        $jadwalSelanjutnya = $jadwalHariIni
            ->where('jam_mulai', '>', $jamSekarang)
            ->first();

        // 11. Statistik kehadiran per kelas
        $kelasYangDiampu = Kelas::whereIn('id', $kelasIds)->get();

        $jadwalHariIniDetail = Jadwal::where('hari', $hariNama)
            ->whereIn('mapel_id', $mapelIds)
            ->with(['mapel', 'kelas'])
            ->orderBy('jam_mulai')
            ->get();

        $statistikKelas = $kelasYangDiampu->map(function ($kelas) use ($mapelIds, $hariIni) {
            $totalSiswa = Siswa_Kelas::where('kelas_id', $kelas->id)->count();

            $jumlahHadir = Presensi::whereIn('jadwal_id', function ($q) use ($kelas, $mapelIds) {
                    $q->select('id')->from('jadwal')
                        ->where('kelas_id', $kelas->id)
                        ->whereIn('mapel_id', $mapelIds);
                })
                ->where('status', 'Hadir')
                ->whereDate('waktu_presensi', $hariIni)
                ->count();

            $persentase = $totalSiswa > 0 ? round(($jumlahHadir / $totalSiswa) * 100, 1) : 0;

            return (object) [
                'nama_kelas' => $kelas->nama_kelas,
                'jumlah_hadir' => $jumlahHadir,
                'total_siswa' => $totalSiswa,
                'persentase_kehadiran' => $persentase
            ];
        });

        // 12. Riwayat presensi (5 terakhir)
        $riwayatPresensi = collect();

        // Ambil semua siswa dari presensi yang berkaitan dengan mapel guru
        $siswaIds = Presensi::whereIn('jadwal_id', function ($query) use ($mapelIds) {
                $query->select('id')
                    ->from('jadwal')
                    ->whereIn('mapel_id', $mapelIds);
            })
            ->pluck('siswa_kelas_id')
            ->unique();

        foreach ($siswaIds as $siswaKelasId) {
            $presensiSiswa = Presensi::with(['siswa_kelas.siswa', 'jadwal.kelas'])
                ->where('siswa_kelas_id', $siswaKelasId)
                ->whereIn('jadwal_id', function ($query) use ($mapelIds) {
                    $query->select('id')->from('jadwal')->whereIn('mapel_id', $mapelIds);
                })
                ->orderByDesc('waktu_presensi')
                ->limit(5)
                ->get();

            if ($presensiSiswa->isEmpty()) continue;

            $siswa = $presensiSiswa->first()->siswa_kelas->siswa;
            $kelas = $presensiSiswa->first()->jadwal->kelas;
            $latestPresensi = $presensiSiswa->first();
            $tanggal = Carbon::parse($latestPresensi->waktu_presensi);

            $riwayatPresensi->push((object)[
                'nama' => $siswa->nama_siswa,
                'nis' => $siswa->nis,
                'kelas' => $kelas->nama_kelas ?? '-',
                'Hadir' => $presensiSiswa->where('status', 'Hadir')->count(),
                'Izin' => $presensiSiswa->where('status', 'Izin')->count(),
                'Sakit' => $presensiSiswa->where('status', 'Sakit')->count(),
                'Alpha' => $presensiSiswa->where('status', 'Alpha')->count(),
                'tanggal' => $tanggal->format('Y-m-d'),
                'jam' => $tanggal->format('H:i'),
                'status' => $latestPresensi->status,
            ]);
        }

            // dd($riwayatPresensi);

        // 13. Kirim ke view
        return view('Guru.dashboard-guru', [
            'hariIni' => $hariIni,
            'jamSekarang' => $jamSekarang,
            'hariNama' => $hariNama,
            'jumlahKelasDiampu' => $jumlahKelasDiampu,
            'kelasAktifHariIni' => $kelasAktifHariIni,
            'totalSiswaDiampu' => $totalSiswaDiampu,
            'rataRataKehadiran' => $rataRataKehadiran,
            'jumlahPresensiHariIni' => $jumlahPresensiHariIni,
            'siswaAlpha' => $siswaAlpha,
            'jumlahJadwalHariIni' => $jumlahJadwalHariIni,
            'jadwalSelanjutnya' => $jadwalSelanjutnya ? $jadwalSelanjutnya->jam_mulai : 'Tidak ada',
            'statistikKelas' => $statistikKelas,
            'riwayatPresensi' => $riwayatPresensi,
            'jadwalHariIniDetail' => $jadwalHariIniDetail,
            'jadwalIdsHariIni' => $jadwalIdsHariIni
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
