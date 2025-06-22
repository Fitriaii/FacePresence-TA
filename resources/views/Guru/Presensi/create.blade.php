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
            <h2 class="mb-6 text-lg font-bold text-purple-800 font-heading">Detail Jadwal</h2>

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

            <div class="mb-6 space-x-8" x-data="{ tab: 'kamera' }">

                <div class="flex flex-wrap mb-4 border-b border-gray-200">
                    <button
                        type="button"
                        @click="tab = 'kamera'"
                        :class="tab === 'kamera' ? 'text-purple-600 border-purple-600' : 'text-gray-600 border-transparent '"
                        class="flex items-center gap-2 px-6 py-2 text-sm font-medium border-b-2 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134-.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
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

                <div class="flex items-center gap-4 mb-4">
                    <label class="w-48 text-sm font-medium text-black">Waktu Presensi <span class="ml-1 font-semibold">:</span></label>
                    <input
                        type="datetime-local"
                        name="waktu_presensi"
                        id="waktu_presensi"
                        class="px-4 py-2 text-sm text-black border border-gray-400 rounded outline-none w-60 bg-inherit hover:border-purple-600 focus:border-purple-600"
                        value="{{ old('waktu_presensi', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                        required
                        :readonly="tab === 'kamera'"
                    >
                    @error('waktu_presensi')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div x-show="tab === 'kamera'">
                    <div class="mb-6">
                        <div id="videoWrapper" class="relative flex flex-col items-center justify-center max-w-2xl mx-auto bg-gray-900 rounded-lg shadow-lg video-container aspect-video" data-jadwal-id="{{ $jadwal->id }}">

                            <div id="statusIndicator" class="status-indicator"></div>

                            <div id="recognitionStats" class="hidden recognition-stats">
                                <div>FPS: <span id="fpsCounter">0</span></div>
                                <div>Deteksi: <span id="detectionCount">0</span></div>
                            </div>

                            <video id="video" autoplay muted class="object-cover w-full h-full rounded-sm"></video>

                            <div id="scanningLine" class="hidden scanning-line"></div>

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

                            <canvas id="canvas" class="hidden"></canvas>
                        </div>

                        <div class="flex justify-center gap-3 mt-6">
                            <button type="button" class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg btn-primary disabled:opacity-50 disabled:cursor-not-allowed" id="start-recognition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                                Nyalakan Kamera
                            </button>
                            <button type="button" class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg btn-secondary disabled:opacity-50 disabled:cursor-not-allowed" id="detectFace" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Deteksi Wajah Sekarang
                            </button>
                            <button type="button" class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg btn-danger disabled:opacity-50 disabled:cursor-not-allowed" id="stop-recognition" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M12 18.75H4.5a2.25 2.25 0 0 1-2.25-2.25V9m12.841 9.091L16.5 19.5m-1.409-1.409c.407-.407.659-.97.659-1.591v-9a2.25 2.25 0 0 0-2.25-2.25h-9c-.621 0-1.184.252-1.591.659m12.182 12.182L2.909 5.909M1.5 4.5l1.409 1.409" />
                                </svg>
                                Matikan Kamera
                            </button>
                        </div>

                        <div class="flex justify-center mt-4">
                            <div id="modeStatus" class="px-4 py-2 text-sm font-medium text-blue-800 bg-blue-100 border border-blue-200 rounded-full">
                                Mode Otomatis Aktif
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full p-4 border border-blue-200 rounded-lg bg-blue-50">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-sm font-semibold text-blue-800">Deteksi Wajah Otomatis (dan Manual)</h4>
                                        <p class="mb-2 text-sm text-blue-700">
                                            Sistem akan secara otomatis mendeteksi wajah setiap beberapa detik dan mencatat presensi jika dikenali. Anda juga bisa menekan "Deteksi Wajah Sekarang" untuk pemicuan manual.
                                        </p>
                                        <div class="flex flex-wrap gap-3 text-xs text-blue-600">
                                            <span class="flex items-center gap-1">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Deteksi otomatis berkala
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Pemicu deteksi manual
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Fleksibel
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form x-show="tab === 'manual'" action="{{ route('presensi.manual.simpan') }}" method="POST" class="space-y-4">
                    @csrf

                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                    {{-- Waktu presensi untuk manual diisi dari JS atau biarkan user pilih --}}
                    {{-- <input type="hidden" name="waktu_presensi" value="{{ now() }}"> --}}

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
                                    <td colspan="8" class="px-4 py-3 text-center">Tidak ada data siswa ditemukan untuk kelas ini.</td>
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
        background: #ef4444; /* Merah untuk tidak aktif */
        animation: pulse 2s infinite;
    }

    .status-indicator.active {
        background: #10b981; /* Hijau untuk aktif */
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
    const waktuPresensiInput = document.getElementById('waktu_presensi');

    const BLUR_THRESHOLD = 100;
    const BRIGHTNESS_THRESHOLD = 60;
    const AUTO_DETECTION_INTERVAL_MS = 3000;
    const COOLDOWN_DURATION_MS = 5000;

    let mediaStream = null;
    let detectionInterval = null;
    let frameCount = 0;
    let lastFrameTime = Date.now();
    let totalDetections = 0;
    let isProcessing = false;
    let isCooldown = false;

    video.addEventListener('loadedmetadata', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
    });

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

                videoWrapper.querySelector('#cameraOverlay').style.display = 'none';
                statusIndicator.classList.add('active');
                recognitionStats.classList.remove('hidden');
                scanningLine.classList.remove('hidden');

                updateFPS();
            })
            .catch((error) => {
                console.error("Webcam error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error Kamera',
                    text: 'Gagal mengakses kamera. Pastikan kamera tidak digunakan aplikasi lain dan izin kamera diberikan.',
                    confirmButtonColor: '#8b5cf6'
                });
            });
    }

    function stopCamera() {
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
            mediaStream = null;
            startBtn.disabled = false;
            detectBtn.disabled = true;
            stopBtn.disabled = true;

            videoWrapper.querySelector('#cameraOverlay').style.display = 'flex';
            statusIndicator.classList.remove('active');
            recognitionStats.classList.add('hidden');
            scanningLine.classList.add('hidden');

            if (detectionInterval) {
                clearInterval(detectionInterval);
                detectionInterval = null;
            }

            clearFaceFrames();
        }
    }

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

    function clearFaceFrames() {
        const frames = videoWrapper.querySelectorAll('.face-frame');
        frames.forEach(frame => frame.remove());
    }

    function drawFaceFrame(x, y, width, height, confidence, name = '') {
        clearFaceFrames();

        const frame = document.createElement('div');
        frame.className = 'face-frame';
        frame.style.left = `${x}px`;
        frame.style.top = `${y}px`;
        frame.style.width = `${width}px`;
        frame.style.height = `${height}px`;

        const badge = document.createElement('div');
        badge.className = 'confidence-badge';
        badge.style.top = '-25px';
        badge.style.left = '0';
        badge.textContent = `${name || 'Terdeteksi'} (Jarak: ${Math.round(confidence)})`;

        frame.appendChild(badge);
        videoWrapper.appendChild(frame);

        setTimeout(() => {
            if (frame.parentNode) {
                frame.parentNode.removeChild(frame);
            }
        }, 2000);
    }

    function detectFace() {
        if (!mediaStream || isProcessing || isCooldown) return;

        isProcessing = true;
        totalDetections++;
        detectionCount.textContent = totalDetections;

        context.filter = 'brightness(1.2) contrast(1.1)';
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        context.filter = 'none';

        const imageData = canvas.toDataURL('image/jpeg', 0.8);
        const rawImageData = context.getImageData(0, 0, canvas.width, canvas.height);

        const grayData = new Uint8ClampedArray(canvas.width * canvas.height);
        let totalBrightness = 0;
        for (let i = 0, j = 0; i < rawImageData.data.length; i += 4, j++) {
            const r = rawImageData.data[i];
            const g = rawImageData.data[i + 1];
            const b = rawImageData.data[i + 2];
            const gray = (r + g + b) / 3;
            grayData[j] = gray;
            totalBrightness += gray;
        }

        const avgBrightness = totalBrightness / grayData.length;
        if (avgBrightness < BRIGHTNESS_THRESHOLD) {
            Swal.fire({
                icon: 'warning',
                title: 'Pencahayaan Kurang',
                text: 'Silakan pastikan ruangan cukup terang untuk deteksi wajah.',
                timer: 2000,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            }).then(() => { isProcessing = false; });
            return;
        }

        const laplacian = (pixels) => {
            if (pixels.length < 3) return 0;
            let sum = 0;
            for (let i = 1; i < pixels.length - 1; i++) {
                sum += Math.pow(pixels[i - 1] - 2 * pixels[i] + pixels[i + 1], 2);
            }
            return sum / pixels.length;
        };
        const blurScore = laplacian(grayData);

        if (blurScore < BLUR_THRESHOLD) {
            Swal.fire({
                icon: 'warning',
                title: 'Gambar Terlalu Buram',
                text: 'Pastikan kamera fokus dan wajah tidak bergerak cepat.',
                timer: 2000,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            }).then(() => { isProcessing = false; });
            return;
        }

        const loading = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        loading.fire({
            icon: 'info',
            title: 'Memproses wajah...'
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
        .then(res => res.json())
        .then(data => {
            loading.close();
            isProcessing = false;

            if (data.data && data.data.face_coords) {
                const { x, y, w, h } = data.data.face_coords;
                drawFaceFrame(x, y, w, h, data.confidence, data.data.siswa);
            } else if (data.confidence !== undefined) {
                const videoRect = video.getBoundingClientRect();
                const centerX = videoRect.width / 2 - 50;
                const centerY = videoRect.height / 2 - 20;
                drawFaceFrame(centerX, centerY, 100, 40, data.confidence, 'Wajah');
            }

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Presensi Tercatat!',
                    html: `<b>${data.data?.siswa || 'Siswa'}</b> berhasil dicatat.<br>Waktu: ${data.data?.waktu || ''}`,
                    confirmButtonText: 'Oke', // Tambahkan tombol OK
                    confirmButtonColor: '#8b5cf6'
                }).then((result) => {
                    // Panggil cooldown setelah SweetAlert sukses ditutup
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        applyCooldown(COOLDOWN_DURATION_MS);
                    }
                });
            } else if (data.status === 'already_marked') {
                Swal.fire({
                    icon: 'info',
                    title: 'Sudah Presensi',
                    html: `<b>${data.data?.siswa || 'Siswa'}</b> sudah melakukan presensi untuk jadwal ini.`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#8b5cf6'
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        applyCooldown(COOLDOWN_DURATION_MS);
                    }
                });
            } else if (data.status === 'low_confidence') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Confidence Rendah',
                    html: `Wajah ${data.nis ? 'NIS <b>'+data.nis+'</b> ' : ''}terdeteksi tapi tingkat kepercayaan rendah.<br>Jarak: <b>${data.confidence}</b>`,
                    text: 'Silakan posisikan wajah lebih jelas dan dekat.',
                    timer: 3500,
                    showConfirmButton: false,
                    confirmButtonColor: '#f59e0b'
                });
            } else if (data.status === 'face_not_found') {
                Swal.fire({
                    icon: 'info',
                    title: 'Wajah Tidak Terdeteksi',
                    text: data.message || 'Pastikan wajah Anda berada di dalam frame kamera.',
                    timer: 2000,
                    showConfirmButton: false,
                    confirmButtonColor: '#3b82f6'
                });
            } else if (data.status === 'unrecognized') {
                Swal.fire({
                    icon: 'error',
                    title: 'Wajah Tidak Dikenali',
                    text: data.message || 'Wajah tidak cocok dengan data siswa yang terdaftar.',
                    timer: 3000,
                    showConfirmButton: false,
                    confirmButtonColor: '#ef4444'
                });
            } else if (data.status === 'nis_not_found' || data.status === 'no_class_data' || data.status === 'invalid_class') {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Siswa Bermasalah',
                    text: data.message || 'Ada masalah dengan data siswa atau jadwal. Silakan hubungi administrator.',
                    confirmButtonColor: '#ef4444'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: data.message || 'Terjadi kesalahan tidak terduga saat memproses presensi.',
                    confirmButtonColor: '#ef4444'
                });
            }
        })
        .catch(err => {
            loading.close();
            console.error('Recognition fetch error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Gagal',
                text: 'Tidak bisa terhubung ke server atau terjadi kesalahan jaringan. Coba periksa koneksi internet Anda.',
                confirmButtonColor: '#ef4444'
            });
            isProcessing = false;
        });
    }

    function applyCooldown(duration) {
        isCooldown = true;
        Swal.fire({
            icon: 'info',
            title: 'Cooldown',
            text: `Deteksi otomatis akan dilanjutkan dalam ${duration / 1000} detik...`,
            timer: duration,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        }).then(() => {
            isCooldown = false;
            if (mediaStream && detectionInterval === null) {
                detectionInterval = setInterval(() => {
                    if (!isProcessing && !isCooldown) {
                        detectFace();
                    }
                }, AUTO_DETECTION_INTERVAL_MS);
            }
        });
    }

    startBtn.addEventListener('click', startCamera);
    detectBtn.addEventListener('click', () => {
        if (mediaStream && !isProcessing && !isCooldown) {
            detectFace();
            // Start auto detection interval if not already running, only after first manual trigger
            if (detectionInterval === null) {
                detectionInterval = setInterval(() => {
                    if (!isProcessing && !isCooldown) {
                        detectFace();
                    }
                }, AUTO_DETECTION_INTERVAL_MS);
            }
        }
    });
    stopBtn.addEventListener('click', stopCamera);

    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        waktuPresensiInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;

        navigator.permissions.query({ name: 'camera' }).then(function(result) {
            if (result.state === 'denied') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Izin Kamera Dibutuhkan',
                    text: 'Aplikasi memerlukan akses kamera untuk pengenalan wajah. Silakan aktifkan izin kamera di pengaturan browser Anda.',
                    confirmButtonColor: '#f59e0b'
                });
            }
        }).catch(function(error) {
            console.log('Permission query not supported:', error);
        });
    });

    document.querySelector('[x-data="{ tab: \'kamera\' }"]').addEventListener('click', (event) => {
        const clickedButton = event.target.closest('button');
        if (clickedButton) {
            const tabText = clickedButton.textContent.trim();
            const tabName = tabText.includes('Kamera') ? 'kamera' : 'manual';

            if (tabName === 'kamera') {
                waktuPresensiInput.setAttribute('readonly', 'true');
                // startCamera(); // Uncomment if you want camera to auto-start on tab switch
            } else {
                waktuPresensiInput.removeAttribute('readonly');
                stopCamera(); // Stop camera when switching to manual tab
            }
        }
    });

    // Handle Alpine.js tab initialization
    document.addEventListener('alpine:init', () => {
        Alpine.data('tabData', () => ({
            tab: 'kamera',
            init() {
                // Set initial readonly state for waktuPresensiInput based on default tab
                this.$nextTick(() => {
                    if (this.tab === 'kamera') {
                        waktuPresensiInput.setAttribute('readonly', 'true');
                    } else {
                        waktuPresensiInput.removeAttribute('readonly');
                    }
                });
            }
        }));
    });
</script>
@endsection
