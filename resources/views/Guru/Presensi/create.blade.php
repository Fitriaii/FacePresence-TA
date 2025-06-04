
@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">

    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Tambah Data Presensi</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('gurudashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('presensi.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Presensi</a>
                <span>/</span>
                <span class="text-gray-400">Tambah Presensi</span>
            </div>
        </div>
    </div>

    <div class="z-50 p-6 mb-6 bg-white rounded-sm shadow-lg font-heading">
        <div class="mb-6">
            <h2 class="mb-6 text-lg font-bold text-purple-800 font-heading">Tambah Presensi</h2>

            <div class="grid grid-cols-1 gap-6">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-between ml-6 w-60">
                        <label class="text-sm font-semibold text-black font-heading">Mata Pelajaran</label>
                        <span class="ml-1 text-sm font-semibold text-black">:</span>
                    </div>
                    <div class="w-full">
                        <p class="text-sm text-gray-700">{{ $jadwal->mapel->nama_mapel }}</p>
                    </div>
                </div>
                <hr class="border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-between ml-6 w-60">
                        <label class="text-sm font-semibold text-black font-heading">Kelas</label>
                        <span class="ml-1 text-sm font-semibold text-black">:</span>
                    </div>
                    <div class="w-full">
                        <p class="text-sm text-gray-700">{{ $jadwal->kelas->nama_kelas }}</p>
                    </div>
                </div>
                <hr class="border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-between ml-6 w-60">
                        <label class="text-sm font-semibold text-black font-heading">Hari</label>
                        <span class="ml-1 text-sm font-semibold text-black">:</span>
                    </div>
                    <div class="w-full">
                        <p class="text-sm text-gray-700">{{ $jadwal->hari }}</p>
                    </div>
                </div>
                <hr class="border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-between ml-6 w-60">
                        <label class="text-sm font-semibold text-black font-heading">Jam</label>
                        <span class="ml-1 text-sm font-semibold text-black">:</span>
                    </div>
                    <div class="w-full">
                        <p class="text-sm text-gray-700">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="mb-6 text-lg font-bold text-purple-800 font-heading">Form Presensi</h2>

            <!-- Form Presensi -->
            <div class="mb-6 space-x-8" x-data="{ tab: 'kamera' }">
                {{-- <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}"> --}}

                <!-- Pilihan Tab -->
                <div class="flex flex-wrap mb-4 border-b border-gray-200">
                    <button
                        type="button"
                        @click="tab = 'kamera'"
                        :class="tab === 'kamera' ? 'text-purple-600 border-purple-600' : 'text-gray-600 border-transparent '"
                        class="flex items-center gap-2 px-6 py-2 text-sm font-medium border-b-2 focus:outline-none">
                        <!-- Ikon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                        Presensi Kamera
                    </button>
                    <button
                        type="button"
                        @click="tab = 'manual'"
                        :class="tab === 'manual' ? 'text-purple-600 border-purple-600' : 'text-gray-600 border-transparent '"
                        class="flex items-center gap-2 px-6 py-2 text-sm font-medium border-b-2 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>
                        </svg>
                        Presensi Manual
                    </button>
                </div>

                <!-- Input Waktu Presensi -->
                <div class="flex items-center gap-4 mb-4">
                    <label class="w-48 text-sm font-medium text-black">Waktu Presensi <span class="ml-1 font-semibold">:</span></label>
                    <input
                        type="datetime-local"
                        name="waktu_presensi"
                        id="waktu_presensi"
                        class="px-4 py-2 text-sm text-black border border-gray-400 rounded outline-none w-60 bg-inherit hover:border-purple-600 focus:border-purple-600"
                        value="{{ old('waktu_presensi', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                        required>
                    @error('waktu_presensi')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tab Konten: Kamera -->
                <div x-show="tab === 'kamera'" class="mb-6">
                    <div class="mb-6">
                        <div id="videoWrapper" class="relative flex flex-col items-center justify-center max-w-2xl mx-auto bg-gray-900 rounded-lg shadow-lg video-container aspect-video" data-jadwal-id="{{ $jadwal->id }}">

                            <!-- Status indicator -->
                            <div id="statusIndicator" class="status-indicator"></div>

                            <!-- Recognition stats -->
                            <div id="recognitionStats" class="hidden recognition-stats">
                                <div>FPS: <span id="fpsCounter">0</span></div>
                                <div>Deteksi: <span id="detectionCount">0</span></div>
                            </div>

                            <!-- Video element -->
                            <video id="video" autoplay muted class="object-cover w-full h-full rounded-sm"></video>

                            <!-- Scanning line overlay -->
                            <div id="scanningLine" class="hidden scanning-line"></div>

                            <!-- Face detection frames will be added here dynamically -->

                            <!-- Overlay jika kamera belum aktif -->
                            <div id="cameraOverlay" class="absolute inset-0 flex flex-col items-center justify-center text-white transition-all duration-500 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-gray-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v9a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                        <circle cx="12" cy="13" r="4"/>
                                    </svg>
                                    <p class="mb-2 text-lg font-medium text-gray-300">Kamera Belum Aktif</p>
                                    <p class="text-sm text-gray-400">Klik tombol hijau untuk memulai</p>
                                </div>
                            </div>

                            <!-- Canvas untuk proses face recognition -->
                            <canvas id="canvas" class="hidden"></canvas>
                        </div>

                        <!-- Tombol kontrol -->
                        <div class="flex justify-center gap-3 mt-6">
                            <button type="button" class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg btn-primary disabled:opacity-50 disabled:cursor-not-allowed" id="start-recognition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a2.5 2.5 0 002.5-2.5V6a2.5 2.5 0 00-2.5-2.5H9m12 0H9m12 0a2 2 0 012 2v9a2 2 0 01-2 2h-1M9 3.5a2 2 0 00-2 2v9a2 2 0 002 2h1m10.5-11.5H21m-10.5 0H9"/>
                                </svg>
                                Nyalakan Kamera
                            </button>
                            <button type="button" class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg btn-secondary disabled:opacity-50 disabled:cursor-not-allowed" id="detectFace" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Deteksi Wajah
                            </button>
                            <button type="button" class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg btn-danger disabled:opacity-50 disabled:cursor-not-allowed" id="stop-recognition" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Matikan Kamera
                            </button>
                        </div>

                        <!-- Mode toggle -->
                        <div class="flex justify-center mt-4">
                            <div class="p-1 bg-gray-100 rounded-lg">
                                <button id="autoMode" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md shadow-sm hover:bg-gray-50">
                                    Mode Otomatis
                                </button>
                                <button id="manualMode" class="px-4 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                                    Mode Manual
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <small class="text-gray-500">
                                <span class="inline-block w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Sistem akan menandai kehadiran siswa berdasarkan wajah yang dikenali dengan tingkat akurasi tinggi
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tab Konten: Manual -->
                <form x-show="tab === 'manual'" action="{{ route('presensi.manual.simpan') }}" method="POST" class="space-y-4">
                    @csrf

                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                    <input type="hidden" name="waktu_presensi" value="{{ now() }}">

                    <div class="mt-2 overflow-auto rounded-sm shadow-sm">
                        <table class="min-w-full bg-white rounded shadow-md">
                            <thead>
                                <tr class="text-sm font-semibold text-gray-700 bg-gray-100 font-heading">
                                    <th class="px-6 py-3 text-xs text-left text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-xs text-left text-gray-500 uppercase">NIS</th>
                                    <th class="px-6 py-3 text-xs text-left text-gray-500 uppercase">Nama Siswa</th>
                                    <th class="px-6 py-3 text-xs text-center text-gray-500 uppercase">Hadir</th>
                                    <th class="px-6 py-3 text-xs text-center text-gray-500 uppercase">Sakit</th>
                                    <th class="px-6 py-3 text-xs text-center text-gray-500 uppercase">Izin</th>
                                    <th class="px-6 py-3 text-xs text-center text-gray-500 uppercase">Alpha</th>
                                    <th class="px-6 py-3 text-xs text-left text-gray-500 uppercase">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $siswa as $index => $item )
                                @php
                                    $status = old("presensi.$index.status", $item->presensi_data->status ?? null);
                                    $catatan = old("presensi.$index.catatan", $item->presensi_data->catatan ?? '');
                                @endphp
                                <tr class="text-xs text-gray-700 border-t hover:bg-gray-50">
                                    <td class="px-6 py-2 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                        <input type="hidden" name="presensi[{{ $index }}][siswa_kelas_id]" value="{{ $item->id }}">
                                    </td>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->siswa->nis }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $item->siswa->nama_siswa }}</td>

                                    {{-- Hadir --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="presensi[{{ $index }}][status]" value="Hadir"
                                            {{ $status === 'Hadir' ? 'checked' : '' }} required>
                                    </td>

                                    {{-- Sakit --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="presensi[{{ $index }}][status]" value="Sakit"
                                            {{ $status === 'Sakit' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Izin --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="presensi[{{ $index }}][status]" value="Izin"
                                            {{ $status === 'Izin' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Alpha --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="presensi[{{ $index }}][status]" value="Alpha"
                                            {{ $status === 'Alpha' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="px-6 py-2 text-xs text-gray-600">
                                        <input type="text" name="presensi[{{ $index }}][catatan]" class="w-full px-2 py-1 border rounded"
                                            placeholder="Opsional" value="{{ $catatan }}">
                                    </td>
                                </tr>
                                @empty
                                <tr class="text-sm text-gray-500">
                                    <td colspan="5" class="px-4 py-3 text-center">Tidak ada data presensi yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col justify-end gap-4 pt-8 border-t border-gray-200 sm:flex-row">
                        <a href="{{ route('presensi.index') }}" type="button"
                            class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                            <span class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Presensi
                            </span>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>

<style>
    .face-frame {
        position: absolute;
        border: 3px solid #10b981;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
    }

    .confidence-badge {
        position: absolute;
        background: rgba(16, 185, 129, 0.9);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        backdrop-filter: blur(4px);
    }

    .video-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .scanning-line {
        position: absolute;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #10b981, transparent);
        animation: scan 2s linear infinite;
    }

    @keyframes scan {
        0% { top: 0; opacity: 1; }
        50% { opacity: 0.5; }
        100% { top: 100%; opacity: 1; }
    }

    .status-indicator {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ef4444;
        animation: pulse 2s infinite;
    }

    .status-indicator.active {
        background: #10b981;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    .recognition-stats {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        backdrop-filter: blur(4px);
    }
</style>

<script>
    const video = document.getElementById('video');
    const startBtn = document.getElementById('start-recognition');
    const detectBtn = document.getElementById('detectFace');
    const stopBtn = document.getElementById('stop-recognition');
    const videoWrapper = document.getElementById('videoWrapper');
    const jadwalId = videoWrapper.dataset.jadwalId;
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const statusIndicator = document.getElementById('statusIndicator');
    const scanningLine = document.getElementById('scanningLine');
    const recognitionStats = document.getElementById('recognitionStats');
    const fpsCounter = document.getElementById('fpsCounter');
    const detectionCount = document.getElementById('detectionCount');
    const autoModeBtn = document.getElementById('autoMode');
    const manualModeBtn = document.getElementById('manualMode');

    let mediaStream = null;
    let isAutoMode = true;
    let detectionInterval = null;
    let frameCount = 0;
    let lastFrameTime = Date.now();
    let totalDetections = 0;
    let lastDetectionTime = 0;

    // Atur ukuran canvas berdasarkan ukuran video
    video.addEventListener('loadedmetadata', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
    });

    // Mode switching
    autoModeBtn.addEventListener('click', () => {
        isAutoMode = true;
        autoModeBtn.classList.add('bg-white', 'shadow-sm');
        autoModeBtn.classList.remove('text-gray-500');
        manualModeBtn.classList.remove('bg-white', 'shadow-sm');
        manualModeBtn.classList.add('text-gray-500');

        if (mediaStream && isAutoMode) {
            startAutoDetection();
        }
    });

    manualModeBtn.addEventListener('click', () => {
        isAutoMode = false;
        manualModeBtn.classList.add('bg-white', 'shadow-sm');
        manualModeBtn.classList.remove('text-gray-500');
        autoModeBtn.classList.remove('bg-white', 'shadow-sm');
        autoModeBtn.classList.add('text-gray-500');

        if (detectionInterval) {
            clearInterval(detectionInterval);
            detectionInterval = null;
        }
        scanningLine.classList.add('hidden');
    });

    // Aktifkan kamera
    function startCamera() {
        const constraints = {
            video: {
                width: { ideal: 640 },
                height: { ideal: 480 },
                frameRate: { ideal: 30 }
            }
        };

        navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                mediaStream = stream;
                video.srcObject = stream;
                startBtn.disabled = true;
                detectBtn.disabled = false;
                stopBtn.disabled = false;

                // Update UI
                videoWrapper.querySelector('#cameraOverlay').style.display = 'none';
                statusIndicator.classList.add('active');
                recognitionStats.classList.remove('hidden');

                // Start FPS counter
                updateFPS();

                // Start auto detection if enabled
                if (isAutoMode) {
                    setTimeout(startAutoDetection, 1000);
                }
            })
            .catch((error) => {
                console.error("Webcam error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error Kamera',
                    text: 'Gagal mengakses kamera. Pastikan kamera tidak digunakan aplikasi lain.',
                    confirmButtonColor: '#8b5cf6'
                });
            });
    }

    // Matikan kamera
    function stopCamera() {
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
            mediaStream = null;
            startBtn.disabled = false;
            detectBtn.disabled = true;
            stopBtn.disabled = true;

            // Update UI
            videoWrapper.querySelector('#cameraOverlay').style.display = 'flex';
            statusIndicator.classList.remove('active');
            recognitionStats.classList.add('hidden');
            scanningLine.classList.add('hidden');

            // Clear intervals
            if (detectionInterval) {
                clearInterval(detectionInterval);
                detectionInterval = null;
            }

            // Clear face frames
            clearFaceFrames();
        }
    }

    // Auto detection
    function startAutoDetection() {
        if (!isAutoMode || detectionInterval) return;

        scanningLine.classList.remove('hidden');

        detectionInterval = setInterval(() => {
            if (Date.now() - lastDetectionTime > 3000) { // Throttle detections to 1 per second
                detectFace();
            }
        }, 500); // Check every 100ms but actually detect max 1 per second
    }

    // Update FPS counter
    function updateFPS() {
        if (!mediaStream) return;

        frameCount++;
        const now = Date.now();
        const elapsed = now - lastFrameTime;

        if (elapsed >= 1000) {
            const fps = Math.round((frameCount * 1000) / elapsed);
            fpsCounter.textContent = fps;
            frameCount = 0;
            lastFrameTime = now;
        }

        requestAnimationFrame(updateFPS);
    }

    // Clear face detection frames
    function clearFaceFrames() {
        const frames = videoWrapper.querySelectorAll('.face-frame');
        frames.forEach(frame => frame.remove());
    }

    // Draw face detection frame
    function drawFaceFrame(x, y, width, height, confidence, name = '') {
        clearFaceFrames();

        const frame = document.createElement('div');
        frame.className = 'face-frame';
        frame.style.left = `${x}px`;
        frame.style.top = `${y}px`;
        frame.style.width = `${width}px`;
        frame.style.height = `${height}px`;

        // Confidence badge
        const badge = document.createElement('div');
        badge.className = 'confidence-badge';
        badge.style.top = '-25px';
        badge.style.left = '0';
        badge.textContent = `${Math.round(confidence * 100)}%${name ? ` - ${name}` : ''}`;

        frame.appendChild(badge);
        videoWrapper.appendChild(frame);

        // Remove frame after 2 seconds
        setTimeout(() => {
            if (frame.parentNode) {
                frame.parentNode.removeChild(frame);
            }
        }, 2000);
    }

    // Tombol: Mulai kamera
    startBtn.addEventListener('click', startCamera);

    // Tombol: Stop kamera
    stopBtn.addEventListener('click', stopCamera);

    // Tombol: Deteksi wajah
    detectBtn.addEventListener('click', () => {
        detectFace();
    });

    // Detect face function
    function detectFace() {
        if (!mediaStream) return;

        lastDetectionTime = Date.now();
        totalDetections++;
        detectionCount.textContent = totalDetections;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/jpeg', 0.8); // JPEG dengan kompresi

        // Show processing indicator (toast)
        const processingToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        processingToast.fire({
            icon: 'info',
            title: 'Mengenali wajah...'
        });

        fetch('/siswa-recognize', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                image: imageData,
                jadwal_id: jadwalId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            processingToast.close();

            switch(data.status) {
                case 'success':
                    // Jika ada lokasi wajah, gambar kotak
                    if (data.face_location) {
                        const { x, y, width, height } = data.face_location;
                        const videoRect = video.getBoundingClientRect();
                        const scaleX = videoRect.width / canvas.width;
                        const scaleY = videoRect.height / canvas.height;

                        drawFaceFrame(
                            x * scaleX,
                            y * scaleY,
                            width * scaleX,
                            height * scaleY,
                            data.confidence || 0.95,
                            data.nama_siswa || ''
                        );
                    }

                    if (data.siswa_nis) {
                        const namaSiswa = data.nama_siswa || 'Nama Tidak Tersedia';
                        markAttendance(data.siswa_nis, namaSiswa);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Lengkap',
                            text: 'Data siswa tidak lengkap untuk mencatat presensi',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                    break;

                case 'face_not_found':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Wajah Tidak Terdeteksi',
                        text: 'Pastikan wajah terlihat jelas di kamera',
                        confirmButtonColor: '#f59e0b',
                        timer: 2000
                    });
                    break;

                case 'not_recognized':
                    Swal.fire({
                        icon: 'info',
                        title: 'Wajah Tidak Dikenali',
                        text: 'Wajah terdeteksi tetapi tidak terdaftar dalam sistem',
                        confirmButtonColor: '#6b7280',
                        timer: 3000
                    });
                    break;

                case 'already_present':
                    Swal.fire({
                        icon: 'info',
                        title: 'Sudah Hadir',
                        text: `${data.nama_siswa || 'Siswa'} sudah tercatat hadir sebelumnya`,
                        confirmButtonColor: '#06b6d4',
                        timer: 2000
                    });
                    break;

                case 'not_present':
                    Swal.fire({
                        icon: 'info',
                        title: 'Belum Hadir',
                        text: `${data.nama_siswa || 'Siswa'} belum tercatat hadir`,
                        confirmButtonColor: '#06b6d4',
                        timer: 2000
                    });
                    break;

                default:
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Tidak Dikenal',
                        text: data.message || 'Terjadi kesalahan pada server.',
                        confirmButtonColor: '#ef4444'
                    });
            }
        })
        .catch(error => {
            processingToast.close();
            console.error('Recognition error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error Koneksi',
                text: 'Gagal terhubung ke server. Periksa koneksi internet Anda.',
                confirmButtonColor: '#ef4444'
            });
        });
    }

    // Pasang sekali event listener sebelum unload
    window.addEventListener('beforeunload', () => {
        stopCamera();
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial mode UI
        if (isAutoMode) {
            autoModeBtn.classList.add('bg-white', 'shadow-sm');
            manualModeBtn.classList.add('text-gray-500');
        } else {
            manualModeBtn.classList.add('bg-white', 'shadow-sm');
            autoModeBtn.classList.add('text-gray-500');
        }

        // Cek izin kamera
        navigator.permissions.query({ name: 'camera' }).then(function(result) {
            if (result.state === 'denied') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Izin Kamera Dibutuhkan',
                    text: 'Aplikasi memerlukan akses kamera untuk pengenalan wajah. Silakan aktifkan izin kamera di pengaturan browser.',
                    confirmButtonColor: '#f59e0b'
                });
            }
        }).catch(function(error) {
            console.log('Permission query not supported:', error);
        });
    });


    // Mark attendance function
    function markAttendance(siswaNis, namaSiswa = null) {
    fetch('/mark-attendance', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            siswa_nis: siswaNis,
            nama_siswa: namaSiswa,
            jadwal_id: jadwalId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Presensi Berhasil',
                text: `${data.data.siswa} - Presensi telah dicatat`,
                confirmButtonColor: '#10b981',
                timer: 2000,
                timerProgressBar: true
            });

            // Update daftar presensi jika fungsi tersedia
            if (typeof updateAttendanceList === 'function') {
                updateAttendanceList(siswaNis, data.data.siswa);
            }

        } else if (data.status === 'already_marked') {
            Swal.fire({
                icon: 'info',
                title: 'Sudah Presensi',
                text: `${data.data.siswa} - Presensi sudah tercatat sebelumnya`,
                confirmButtonColor: '#06b6d4',
                timer: 2000
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Presensi Gagal',
                text: data.message || 'Terjadi kesalahan saat menyimpan presensi',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        console.error("Presensi gagal:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error Koneksi',
            text: 'Terjadi kesalahan saat menyimpan presensi',
            confirmButtonColor: '#ef4444'
        });
    });
}

</script>


@endsection

