<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('guru')) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 403,
                'message' => 'Unauthorized. Only guru can perform this action.'
            ]);
        }

        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 404,
                'message' => 'Data guru tidak ditemukan.'
            ]);
        }

        $query = Jadwal::with(['kelas', 'mapel.guru'])
            ->whereHas('mapel', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->leftJoin('kelas as kls', 'jadwal.kelas_id', '=', 'kls.id')
            ->leftJoin('mapel as mpl', 'jadwal.mapel_id', '=', 'mpl.id')
            ->select('jadwal.*')
            ->orderBy('jadwal.hari')
            ->orderBy('kls.nama_kelas');

        // 🔍 Filter pencarian bebas
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('kls.nama_kelas', 'like', "%$search%")
                ->orWhere('mpl.nama_mapel', 'like', "%$search%");
            });
        }

        // 🎯 Filter Hari
        if ($request->filled('hari')) {
            $query->where('jadwal.hari', $request->hari);
        }

        // 🎯 Filter Kelas
        if ($request->filled('kelas')) {
            $query->where('jadwal.kelas_id', $request->kelas);
        }

        // 🎯 Filter Mapel
        if ($request->filled('mapel')) {
            $query->where('jadwal.mapel_id', $request->mapel);
        }

        // ↕️ Sorting
        if ($sort = $request->input('sort')) {
            switch ($sort) {
                case 'created_asc':
                    $query->orderBy('jadwal.created_at', 'asc');
                    break;
                case 'created_desc':
                    $query->orderBy('jadwal.created_at', 'desc');
                    break;
                case 'jam_mulai_asc':
                    $query->orderBy('jadwal.jam_mulai', 'asc');
                    break;
                case 'jam_mulai_desc':
                    $query->orderBy('jadwal.jam_mulai', 'desc');
                    break;
                default:
                    $query->latest('jadwal.created_at');
                    break;
            }
        }

        // 📄 Pagination dan group
        $jadwalPaginated = $query->paginate(10)->appends($request->query());
        $jadwalCollection = $jadwalPaginated->getCollection();

        // 📊 Group by Hari > Kelas
        $groupedKelas = $jadwalCollection
            ->groupBy('hari')
            ->map(function ($itemsPerHari) {
                return $itemsPerHari->groupBy('kelas_id');
            });

        return view('Guru.jadwalMengajar', [
            'user' => $user,
            'groupedKelas' => $groupedKelas,
            'jadwal' => $jadwalPaginated,
            'no' => 1,
            'semuaKelas' => Kelas::orderBy('nama_kelas')->get(), // Optional
            'semuaMapel' => Mapel::where('guru_id', $guru->id)->orderBy('nama_mapel')->get(),
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
