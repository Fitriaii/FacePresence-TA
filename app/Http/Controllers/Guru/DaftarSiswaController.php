<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class DaftarSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Jika bukan guru, tolak akses
        if (!$user || !$user->hasRole('guru')) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 403,
                'message' => 'Unauthorized.'
            ]);
        }

        $guru = Guru::where('user_id', $user->id)->first();

        $query = Siswa::with([
            'siswa_kelas' => function ($q) {
                $q->with(['kelas', 'tahunAjaran']);
            }
        ]);

        // Jika user adalah guru, filter berdasarkan kelas yang diampu
        $kelasIds = collect(); // default kosong

        if ($guru) {
            $kelasIds = Jadwal::whereHas('mapel', function ($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })
                ->pluck('kelas_id')
                ->unique();

            $query->whereHas('siswa_kelas', function ($q) use ($kelasIds) {
                $q->whereIn('kelas_id', $kelasIds);
            });
        }

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%')
                    ->orWhereHas('siswa_kelas.kelas', function ($kelasQuery) use ($request) {
                        $kelasQuery->where('nama_kelas', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('siswa_kelas.tahunAjaran', function ($tahunQuery) use ($request) {
                        $tahunQuery->where('tahun_ajaran', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 🎯 Filter: Jenis Kelas
        if ($request->filled('jenis_kelas')) {
            $query->whereHas('siswa_kelas.kelas', function ($q) use ($request) {
                $q->where('jenis_kelas', $request->jenis_kelas);
            });
        }

        // 🎯 Filter: Tahun Ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->whereHas('siswa_kelas', function ($q) use ($request) {
                $q->where('tahun_ajaran_id', $request->tahun_ajaran);
            });
        }

        // 🎯 Filter: Kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa_kelas', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }

        // ↕️ Sorting
        switch ($request->sort) {
            case 'nama_siswa_asc':
                $query->orderBy('nama_siswa', 'asc');
                break;
            case 'nama_siswa_desc':
                $query->orderBy('nama_siswa', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $siswa = $query->paginate(10)->appends($request->query());

        // Ambil dropdown tahun ajaran (semua)
        $semuaTahunAjaran = TahunAjaran::all();

        // Kelas dropdown hanya yang diampu guru
        $semuaKelas = Kelas::whereIn('id', $kelasIds)->get();

        return view('Guru.daftarSiswa', compact('siswa', 'user', 'semuaTahunAjaran', 'semuaKelas'));
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
