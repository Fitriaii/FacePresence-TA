<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Siswa_Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Process\Process;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            return redirect()->back()->with([
                'status' => 'error',
                'code' => 403,
                'message' => 'Unauthorized. Only admins can perform this action.'
            ]);
        }

        $query = Siswa::with([
            'siswa_kelas' => function ($q) {
                $q->with(['kelas', 'tahunAjaran']);
            }
        ]);

        // 🔍 Search: nama, NIS, atau nama kelas
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
                ;
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
                $q->where('tahun_ajaran_id', $request->tahun_ajaran); // perbaikan: tahun_ajaran, bukan tahun_ajaran_id
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
                $query->latest(); // default: created_at desc
                break;
        }

        $siswa = $query->paginate(10)->appends($request->query());

        // Ambil data referensi dropdown
        $semuaTahunAjaran = TahunAjaran::all();
        $semuaKelas = Kelas::all();

        return view('Admin.Siswa.index', compact('siswa', 'user', 'semuaTahunAjaran', 'semuaKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::all();
        $activeTahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        if (!$activeTahunAjaran) {
            Alert::error('Gagal', 'Tidak ada tahun ajaran aktif. Silakan atur tahun ajaran terlebih dahulu.');
            return redirect()->route('siswa.index');
        }

        return view('Admin.Siswa.create', compact('kelasList', 'activeTahunAjaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswa,nis',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan data siswa
            $siswa = new Siswa();
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->nis = $request->nis;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->save();

            // 2. Simpan ke relasi siswa_kelas
            $siswaKelas = new Siswa_Kelas();
            $siswaKelas->siswa_id = $siswa->id;
            $siswaKelas->kelas_id = $request->kelas_id;
            $siswaKelas->tahun_ajaran_id = $request->tahun_ajaran_id;
            $siswaKelas->save();

            DB::commit();

            return redirect()->route('siswa.index')->with([
                'status' => 'success',
                'message' => 'Siswa berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('siswa.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan siswa: ' . $e->getMessage()
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa = Siswa::with([
            'siswa_kelas.kelas',  // Memuat relasi kelas
            'siswa_kelas.tahunAjaran'  // Memuat relasi tahun ajaran
        ])->findOrFail($siswa->id);

        // Jika siswa_kelas adalah koleksi, pilih entitas pertama (asumsi hanya ada satu entitas yang relevan)
        $siswaKelas = $siswa->siswa_kelas->first();

        return view('Admin.Siswa.show', compact('siswa', 'siswaKelas'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $siswaKelas = $siswa->siswa_kelas()->first();
        $activeTahunAjaran = TahunAjaran::where('status', 'aktif')->first();
        $kelasList = Kelas::all();
        if (!$activeTahunAjaran) {
            Alert::error('Gagal', 'Tidak ada tahun ajaran aktif. Silakan atur tahun ajaran terlebih dahulu.');
            return redirect()->route('siswa.index');
        }
        return view('Admin.Siswa.edit', compact('siswa', 'siswaKelas', 'activeTahunAjaran', 'kelasList'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswa,nis,' . $siswa->id,
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ], [
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-Laki atau Perempuan.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas tidak ditemukan.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists' => 'Tahun ajaran tidak valid.',
        ]);

        try {
            DB::beginTransaction();

            // Update data siswa
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->nis = $request->nis;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->save();

            // Update relasi siswa_kelas
            $siswaKelas = $siswa->siswa_kelas()->first();
            if ($siswaKelas) {
                $siswaKelas->kelas_id = $request->kelas_id;
                $siswaKelas->tahun_ajaran_id = $request->tahun_ajaran_id;
                $siswaKelas->save();
            }

            DB::commit();

            return redirect()->route('siswa.index')->with([
                'status' => 'success',
                'message' => 'Data siswa berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('siswa.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui siswa: ' . $e->getMessage()
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->delete();
            return redirect()->route('siswa.index')->with([
                'status' => 'success',
                'message' => 'Siswa berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data siswa: ' . $e->getMessage()
            ]);
        }
    }
    public function showCaptureForm(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.facetrain', compact('siswa'));
    }

    public function captureAndTrain(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $images = $request->get('images');

        if (!$images || !is_array($images)) {
            Log::error("Data gambar tidak valid untuk siswa ID: {$id}");
            return response()->json(['message' => 'Data gambar tidak valid'], 422);
        }

        $nis = $siswa->nis;
        $folder = "faces/{$nis}";

        try {
            // Bersihkan folder lama
            if (Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->deleteDirectory($folder);
                Log::info("Folder lama dihapus: {$folder}");
            }
            Storage::disk('public')->makeDirectory($folder);
            Log::info("Folder baru dibuat: {$folder}");
        } catch (\Exception $e) {
            Log::error("Gagal buat folder: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyiapkan folder penyimpanan.',
            ], 500);
        }

        // Simpan gambar dan buat path
        $paths = [];
        foreach ($images as $index => $imgData) {
            try {
                // Hitung posisi dan index gambar
                $position = floor($index / 5); // 5 gambar per posisi
                $i = $index % 5;

                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgData));
                $filename = "$folder/pose_{$position}_{$i}.png";
                Storage::disk('public')->put($filename, $image);

                if (!Storage::disk('public')->exists($filename)) {
                    Log::error("Gagal menyimpan: $filename");
                    return response()->json([
                        'status' => 'error',
                        'message' => "Gagal menyimpan gambar ke storage.",
                    ]);
                }

                $paths[] = $filename;
                Log::info("Gambar disimpan: $filename");

            } catch (\Exception $e) {
                Log::error("Gagal simpan gambar ke storage: " . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => "Gagal menyimpan gambar ke storage.",
                ]);
            }
        }

        // Simpan ke DB
        try {
            $siswa->foto_siswa = json_encode($paths);
            $siswa->save();
            Log::info("Path disimpan ke DB untuk NIS {$nis}");
        } catch (\Exception $e) {
            Log::error("Gagal simpan DB: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database.',
            ], 500);
        }

        // Buat URL publik agar bisa diakses Flask
        $imageUrls = array_map(function ($path) {
            return asset('storage/' . $path);
        }, $paths);

        // Kirim ke Flask untuk training
        try {
            $response = Http::timeout(30)->post('http://127.0.0.1:5000/face-train', [
                'nis' => $nis,
                'image_urls' => $imageUrls,
            ]);

            if (!$response->ok()) {
                Log::error("Flask error: " . $response->body());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Flask tidak merespon OK.',
                    'flask_response' => $response->body(),
                ], 500);
            }

            $data = $response->json();
            if ($data['status'] !== 'success') {
                Log::error("Training gagal: " . json_encode($data));
                return response()->json([
                    'status' => 'error',
                    'message' => 'Training gagal di Flask.',
                    'detail' => $data,
                ], 500);
            }

            Log::info("Training sukses di Flask untuk NIS {$nis}");
            return response()->json([
                'status' => 'success',
                'message' => 'Capture & training berhasil!',
                'label_map' => $data['label_map'] ?? null,
                'redirect' => route('siswa.index'),
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal koneksi ke Flask: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat menghubungi API Flask.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }






}
