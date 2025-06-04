<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Cek apakah pengguna adalah admin
        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 403,
                'message' => 'Unauthorized. Only admins can perform this action.'
            ]);
        }

        // Mulai query
        $tahunAjaranQuery = TahunAjaran::query();

        // Sorting berdasarkan request
        switch ($request->sort) {
            case 'created_asc':
                $tahunAjaranQuery->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $tahunAjaranQuery->orderBy('created_at', 'desc');
                break;
            default:
                $tahunAjaranQuery->latest(); // default: by created_at desc
                break;
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $tahunAjaranQuery->where('status', $request->status);
        }

        // Filter berdasarkan tahun mulai
        if ($request->filled('tahun_mulai')) {
            $tahunAjaranQuery->whereYear('tanggal_mulai', $request->tahun_mulai);
        }

        // Search by tahun_ajaran atau status
        if ($request->filled('search')) {
            $tahunAjaranQuery->where(function ($query) use ($request) {
                $query->where('tahun_ajaran', 'like', '%' . $request->search . '%')
                    ->orWhere('status', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil data terfilter dan paginasi
        $tahunAjaran = $tahunAjaranQuery->paginate(10);

        // Tambahkan parameter filter ke pagination
        $tahunAjaran->appends($request->only(['status', 'tahun_mulai', 'search', 'sort']));

        // Ambil daftar tahun untuk dropdown filter tahun mulai
        $tahunList = TahunAjaran::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.akademik.tajaran.index', compact('tahunAjaran', 'user', 'tahunList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.akademik.tajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255|unique:tahun_ajaran,tahun_ajaran',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'nullable|in:Aktif,Tidak Aktif'
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
        ]);

        try {
            $tahunajaran = new TahunAjaran();
            $tahunajaran->tahun_ajaran = $request->tahun_ajaran;
            $tahunajaran->tanggal_mulai = $request->tanggal_mulai;
            $tahunajaran->tanggal_selesai = $request->tanggal_selesai;
            $tahunajaran->status = $request->has('status') ? 'Aktif' : 'Tidak Aktif'; // Checkbox toggle

            $tahunajaran->save();

            // Menggunakan SweetAlert untuk sukses
            return redirect()->route('tahunajaran.index')->with([
                'status' => 'success',
                'message' => 'Tahun ajaran berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            // Menggunakan SweetAlert untuk error
            return redirect()->route('tahunajaran.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan tahun ajaran.'
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(TahunAjaran $tahunajaran)
    {
        // Cek apakah pengguna adalah admin
        return view('admin.akademik.tajaran.show', compact('tahunajaran'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, TahunAjaran $tahunajaran)
    {
        $ta = TahunAjaran::findOrFail($tahunajaran->id);

        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 403,
                'message' => 'Unauthorized. Only admins can perform this action.'
            ]);
        }

        return view('admin.akademik.tajaran.edit', compact('ta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAjaran $tahunajaran)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'nullable|in:Aktif,Tidak Aktif'
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
        ]);

        try {
            $tahunajaran->tahun_ajaran = $request->tahun_ajaran;
            $tahunajaran->tanggal_mulai = $request->tanggal_mulai;
            $tahunajaran->tanggal_selesai = $request->tanggal_selesai;
            // Jika ada status aktif
            $tahunajaran->status = $request->has('status') ? 'Aktif' : 'Tidak Aktif';

            $tahunajaran->save();

            // Menggunakan SweetAlert untuk sukses
            return redirect()->route('tahunajaran.index')->with([
                'status' => 'success',
                'message' => 'Tahun ajaran berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            // Menggunakan SweetAlert untuk error
            return redirect()->route('tahunajaran.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui tahun ajaran.'
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjaran $tahunajaran)
    {
        try {
            // Hapus tahun ajaran
            $tahunajaran->delete();

            // Menggunakan SweetAlert untuk sukses
            return redirect()->route('tahunajaran.index')->with([
                'status' => 'success',
                'message' => 'Tahun ajaran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Menggunakan SweetAlert untuk error
            return redirect()->route('tahunajaran.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus tahun ajaran.'
            ]);
        }
    }


    public function toggleStatus($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $ta->status = $ta->status === 'Aktif' ? 'Tidak Aktif' : 'Aktif';
        $ta->save();

        return response()->json([
            'success' => true,
            'message' => 'Status tahun ajaran berhasil diperbarui.',
            'status' => $ta->status
        ]);
    }

}
