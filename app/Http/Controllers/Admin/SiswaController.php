<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Siswa_Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            // 1. Buat dulu data siswa_kelas tanpa siswa_id
            $siswaKelas = new Siswa_Kelas();
            $siswaKelas->kelas_id = $request->kelas_id;
            $siswaKelas->tahun_ajaran_id = $request->tahun_ajaran_id;
            $siswaKelas->save();

            // 2. Baru simpan data siswa, isi siswa_kelas_id dengan id yang baru dibuat
            $siswa = new Siswa();
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->nis = $request->nis;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->siswa_kelas_id = $siswaKelas->id;
            $siswa->save();

            // 3. Setelah siswa berhasil disimpan, update siswa_id pada siswa_kelas
            $siswaKelas->siswa_id = $siswa->id;
            $siswaKelas->save();

            DB::commit();

            Alert::success('Berhasil', 'Siswa berhasil ditambahkan.');
            return redirect()->route('siswa.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Terjadi kesalahan saat menambahkan siswa: ' . $e->getMessage());
            return redirect()->route('siswa.index');
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
        $kelasList = Kelas::all();
        $activeTahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        if (!$activeTahunAjaran) {
            Alert::error('Gagal', 'Tidak ada tahun ajaran aktif. Silakan atur tahun ajaran terlebih dahulu.');
            return redirect()->route('siswa.index');
        }
        return view('Admin.Siswa.edit', compact('siswa', 'kelasList', 'activeTahunAjaran'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswa,nis,' . $siswa->id, // pastikan NIS tidak bentrok
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ], [
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            // Update data siswa
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->nis = $request->nis;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->save();

            // Update data siswa_kelas jika ada perubahan
            $siswaKelas = $siswa->siswa_kelas;
            $siswaKelas->kelas_id = $request->kelas_id;
            $siswaKelas->tahun_ajaran_id = $request->tahun_ajaran_id;
            $siswaKelas->save();

            DB::commit();

            return redirect()->route('siswa.index')->with([
                'status' => 'success',
                'message' => 'Siswa berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('siswa.index')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data siswa: ' . $e->getMessage()
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

        // Hapus gambar lama jika ada
        try {
            if (Storage::disk('public')->exists($folder)) {
                $existingFiles = Storage::disk('public')->files($folder);
                Storage::disk('public')->delete($existingFiles);
                Log::info("Gambar lama dihapus untuk NIS {$nis}");
            } else {
                Storage::disk('public')->makeDirectory($folder);
                Log::info("Folder dibuat untuk NIS {$nis}");
            }
        } catch (\Exception $e) {
            Log::error("Gagal menghapus/membuat folder untuk NIS {$nis}: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyiapkan folder penyimpanan.',
            ], 500);
        }

        // Simpan gambar baru
        $paths = [];
        foreach ($images as $i => $imgData) {
            try {
                $image = base64_decode(str_replace('data:image/png;base64,', '', $imgData));
                $filename = "$folder/pose_{$i}.png";
                Storage::disk('public')->put($filename, $image);
                $paths[] = $filename;

                if (!Storage::disk('public')->exists($filename)) {
                    Log::error("Gambar pose_{$i}.png gagal disimpan untuk NIS {$nis}");
                    return response()->json([
                        'status' => 'error',
                        'message' => "Gagal menyimpan gambar pose_{$i}.png",
                        'filename' => $filename
                    ]);
                }

                Log::info("Gambar pose_{$i}.png berhasil disimpan untuk NIS {$nis}");
            } catch (\Exception $e) {
                Log::error("Error saat menyimpan gambar pose_{$i}.png untuk NIS {$nis}: " . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => "Terjadi kesalahan saat menyimpan gambar pose_{$i}.png",
                ]);
            }
        }

        // Simpan path ke DB
        try {
            $siswa->foto_siswa = json_encode($paths);
            $siswa->save();
            $nisFile = storage_path("app/public/faces/nis.txt");
            file_put_contents($nisFile, $nis);
            if (!file_exists($nisFile)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File NIS gagal dibuat!',
                    'path' => $nisFile
                ]);
            }
            $storedFiles = Storage::disk('public')->files("faces/{$nis}");
            if (empty($storedFiles)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal: tidak ada gambar tersimpan di storage.',
                    'folder' => "faces/{$nis}"
                ]);
            }
            Log::info("Path gambar disimpan ke DB untuk NIS {$nis}");
        } catch (\Exception $e) {
            Log::error("Gagal menyimpan path gambar ke DB untuk NIS {$nis}: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database.',
            ], 500);
        }

        // Jalankan script training global
        $pythonScript = base_path('python/face_train.py');
        $process = new Process(['python', $pythonScript, $nisFile]);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("Training gagal untuk NIS {$nis}: " . $process->getErrorOutput());
            return response()->json([
                'status' => 'error',
                'message' => 'Training gagal',
                'output' => $process->getOutput(),
                'error' => $process->getErrorOutput(),
                'file_path' => $nisFile
            ], 500);
        }

        Log::info("Training berhasil dijalankan untuk NIS {$nis}");

        // Cek hasil model global
        $modelPath = storage_path("app/public/faces/face_models/traineer.yml");
        $labelPath = storage_path("app/public/faces/face_models/labels_map.pkl");

        if (!file_exists($modelPath) || !file_exists($labelPath)) {
            Log::error("Model atau label tidak ditemukan setelah training untuk NIS {$nis}");
            return response()->json([
                'status' => 'error',
                'message' => 'Model atau label tidak ditemukan setelah training.',
            ], 500);
        }

        Log::info("Capture & training selesai untuk NIS {$nis}");

        return response()->json([
            'status' => 'success',
            'message' => 'Capture & training selesai!',
            'redirect' => route('siswa.index')
        ]);
    }




}
