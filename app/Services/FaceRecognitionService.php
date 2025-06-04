<?php

namespace App\Services;

class FaceRecognitionService
{
    protected string $pythonPath;
    protected string $trainScript;
    protected string $recognizeScript;

    public function __construct()
    {
        $this->pythonPath = 'python'; // Ganti kalau pakai python3 atau path lain
        $this->trainScript = base_path('python/face_train.py');
        $this->recognizeScript = base_path('python/face_recognize.py');
    }

    public function train(string $trainingDir): array
    {
        $command = escapeshellcmd("{$this->pythonPath} {$this->trainScript} {$trainingDir}");
        $output = shell_exec($command);

        return ['status' => 'trained', 'output' => $output];
    }

    public function recognize(string $imagePath): array
    {
        $command = escapeshellcmd("{$this->pythonPath} {$this->recognizeScript} {$imagePath}");
        $output = shell_exec($command);

        return json_decode($output, true) ?? ['error' => 'Recognition failed'];
    }
}
