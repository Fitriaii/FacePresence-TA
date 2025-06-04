<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Services\FaceRecognitionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FaceRecognitionController extends Controller
{
    // protected $faceRecognitionService;

    // public function __construct(FaceRecognitionService $faceRecognitionService)
    // {
    //     $this->faceRecognitionService = $faceRecognitionService;
    // }

    /**
     * Melatih model face recognition dari folder training
     * Kirimkan path folder lokal (misal: storage/app/public/faces/)
     */

    public function CaptureForm($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.facetrain', [
            'id' => $id,
            'siswa' => $siswa,
        ]);
    }


public function runCapture(Request $request)
{
    $siswa = Siswa::find($request->id);

    if (!$siswa) {
        return back()->with('error', 'Siswa tidak ditemukan.');
    }

    $nis = $siswa->nis;

    // Simpan NIS ke file untuk dibaca oleh Python
    $nisFile = storage_path('app/public/nis.txt');
    file_put_contents($nisFile, $nis);

    // Jalankan script Python
    $process = new Process([
        'python', // Ganti 'python3' kalau kamu pakai Linux/Mac
        base_path('python/face_train.py'),
    ]);

    $process->setWorkingDirectory(base_path());
    $process->run();

    // Cek jika proses Python gagal
    if (!$process->isSuccessful()) {
        return back()->with('error', 'Gagal menjalankan script: ' . $process->getErrorOutput());
    }

    // Pastikan bahwa file model sudah dihasilkan
    $modelPath = "faces/face_models/trainer_{$nis}.yml";
    if (!file_exists(storage_path("app/public/{$modelPath}"))) {
        return back()->with('error', 'Model wajah tidak ditemukan setelah proses training.');
    }

    // Kumpulkan path gambar hasil capture (5 posisi wajah)
    $imagePaths = [];
    for ($i = 1; $i <= 5; $i++) {
        $relativePath = "faces/{$nis}/{$nis}_image{$i}.png";
        $fullPath = storage_path("app/public/{$relativePath}");
        if (file_exists($fullPath)) {
            $imagePaths[] = $relativePath;
        }
    }

    // Simpan array gambar sebagai JSON
    $siswa->foto_siswa = json_encode($imagePaths);
    $siswa->save();

    // Tampilkan pesan sukses dan gambar pertama (jika ada)
    return back()->with([
        'message' => 'Berhasil melakukan capture dan training wajah.',
        'preview_gambar' => count($imagePaths) > 0 ? asset('storage/' . $imagePaths[0]) : null,
    ]);
}


    /**
     * Kirim gambar dan dapatkan hasil prediksi wajah
     */
    // public function recognize(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image'
    //     ]);

    //     // Simpan gambar ke storage sementara
    //     $path = $request->file('image')->store('public/temp');
    //     $imagePath = storage_path("app/" . $path);

    //     // Panggil Python
    //     $result = $this->faceRecognitionService->recognize($imagePath);

    //     return response()->json($result);
    // }
}
