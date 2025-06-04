<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = request()->user();

        if (!$user || !$user->hasRole('admin')) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 403,
                'message' => 'Unauthorized. Only admins can perform this action.'
            ]);
        }

        $query = Jadwal::with(['kelas', 'mapel.guru'])
            ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')
            ->join('mapel', 'jadwal.mapel_id', '=', 'mapel.id')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->select('jadwal.*')
            ->orderBy('hari')
            ->orderBy('kelas.nama_kelas');

        // 🔍 Filter: Pencarian bebas
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('kelas.nama_kelas', 'like', "%$search%")
                ->orWhere('mapel.nama_mapel', 'like', "%$search%")
                ->orWhere('guru.nama_guru', 'like', "%$search%");
            });
        }

        // Filter: Hari
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        // Filter: Kelas
        if ($request->filled('kelas')){
            $query->where('kelas_id', $request->kelas);
        }

        // Filter: Mape
        if ($request->filled('mapel')) {
            $query->where('mapel_id', $request->mapel);
        }

        // 🔀 Sorting berdasarkan tanggal dibuat (opsional, kalau ada field created_at)
        if ($sort = request('sort')) {
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


        // 📄 Pagination dan pelengkap filter
        $jadwalPaginated = $query->paginate(10)->appends(request()->all());
        $jadwalCollection = $jadwalPaginated->getCollection();

        // 📊 Group by Hari > Kelas
        $groupedKelas = $jadwalCollection
            ->groupBy('hari')
            ->map(function ($itemsPerHari) {
                return $itemsPerHari->groupBy('kelas_id');
            });

        return view('admin.akademik.jadwal.index', [
            'user' => $user,
            'groupedKelas' => $groupedKelas,
            'jadwal' => $jadwalPaginated,
            'no' => 1,
            'semuaKelas' => Kelas::orderBy('nama_kelas')->get(),
            'semuaMapel' => Mapel::orderBy('nama_mapel')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::all();
        $mapelList = Mapel::with('guru')->get(); // eager load guru dari mapel

        return view('admin.akademik.jadwal.create', compact('kelasList', 'mapelList'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ], [
            'kelas_id.required' => 'Kelas wajib diisi.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'mapel_id.required' => 'Mata pelajaran wajib diisi.',
            'mapel_id.exists' => 'Mata pelajaran yang dipilih tidak ditemukan.',
            'hari.required' => 'Hari wajib diisi.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
        ]);

        try {
            $jadwal = new Jadwal();
            $jadwal->kelas_id = $request->kelas_id;
            $jadwal->mapel_id = $request->mapel_id;
            $jadwal->hari = $request->hari;
            $jadwal->jam_mulai = $request->jam_mulai;
            $jadwal->jam_selesai = $request->jam_selesai;
            $jadwal->save();
            return redirect()->route('jadwal.index')->with([
                'status' => 'success',
                'message' => 'Jadwal berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambah jadwal: ' . $e->getMessage()
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        // Jika ada logika khusus untuk menampilkan detail jadwal, bisa ditambahkan di sini
        return view('admin.akademik.jadwal.show', compact('jadwal'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        $kelasList = Kelas::all();
        $mapelList = Mapel::with('guru')->get(); // eager load guru dari mapel

        return view('admin.akademik.jadwal.edit', [
            'jadwal' => $jadwal,
            'kelasList' => $kelasList,
            'mapelList' => $mapelList,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $validatedData = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'hari' => 'required|string|max:255',
            'guru_pengampu' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ], [
            'kelas_id.required' => 'Kelas wajib diisi.',
            'mapel_id.required' => 'Mata pelajaran wajib diisi.',
            'hari.required' => 'Hari wajib diisi.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
        ]);

        try {
            $jadwal->kelas_id = $request->kelas_id;
            $jadwal->mapel_id = $request->mapel_id;
            $jadwal->hari = $request->hari;
            $jadwal->jam_mulai = $request->jam_mulai;
            $jadwal->jam_selesai = $request->jam_selesai;
            $jadwal->save();

            return redirect()->route('jadwal.index')->with([
                'status' => 'success',
                'message' => 'Jadwal berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back() // <- ganti dari 'route' ke 'back'
                ->withInput()         // <- tambahkan ini agar old() tersedia
                ->with([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat memperbarui jadwal: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with([
            'status' => 'success',
            'code' => 200,
            'message' => 'Jadwal berhasil dihapus.'
        ]);
    }

}
