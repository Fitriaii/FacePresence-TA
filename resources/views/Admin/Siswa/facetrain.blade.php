@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">

    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Capture & Train Wajah Siswa</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('siswa.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Siswa</a>
                <span>/</span>
                <span class="text-gray-400">Capture & Train</span>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Camera Section --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden bg-white border border-gray-100 rounded-sm shadow-lg">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Live Camera
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Pastikan wajah terlihat jelas dan pencahayaan cukup</p>
                </div>

                <div class="p-4 text-center">
                    {{-- Modern Instruction Alert Area --}}
                    <div id="instruction-alert" class="hidden w-full max-w-md mx-auto mt-4 mb-4 transition-all duration-500 transform scale-95 opacity-0 sm:max-w-lg">
                        <div class="relative p-4 border border-gray-200 shadow-sm bg-gradient-to-r from-slate-50 to-gray-50 rounded-2xl backdrop-blur-sm">
                            {{-- Animated Border --}}
                            <div class="absolute inset-0 transition-opacity duration-300 opacity-0 rounded-2xl bg-gradient-to-r from-purple-500/20 to-blue-500/20" id="alert-glow"></div>

                            {{-- Content Container --}}
                            <div class="relative flex items-center justify-between space-x-4">
                                {{-- Icon & Text Section --}}
                                <div class="flex items-center flex-1 space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-purple-100 to-blue-100">
                                            <span id="position-icon" class="text-xl">👤</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0 text-left">
                                        <div class="flex items-center space-x-2">
                                            <h4 id="position-title" class="text-sm font-semibold leading-snug text-gray-900 break-words">
                                                Posisi: Depan
                                            </h4>
                                            <div class="flex-shrink-0 px-2 py-0.5 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">
                                                <span id="position-counter">1/5</span>
                                            </div>
                                        </div>
                                        <p id="position-instruction" class="text-xs text-gray-600 mt-0.5 break-words leading-snug">
                                            Lihat lurus ke kamera dengan wajah tegak
                                        </p>
                                    </div>
                                </div>

                                {{-- Countdown Circle --}}
                                <div class="flex-shrink-0">
                                    <div class="relative">
                                        <svg class="w-12 h-12 transform -rotate-90" id="countdown-svg">
                                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2" fill="none" class="text-gray-200"></circle>
                                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2" fill="none"
                                                    class="text-purple-500 transition-all duration-1000 ease-linear"
                                                    id="countdown-progress"
                                                    stroke-dasharray="125.6"
                                                    stroke-dashoffset="125.6"
                                                    stroke-linecap="round"></circle>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span id="countdown-number" class="text-lg font-bold text-gray-700">3</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Video Preview --}}
                    <div class="relative inline-block">
                        <video id="video" width="640" height="480" autoplay muted playsinline
                               class="bg-gray-900 border-4 border-gray-100 rounded-lg shadow-lg"></video>
                        <canvas id="canvas" width="640" height="480" class="hidden"></canvas>

                        {{-- Camera Overlay --}}
                        <div class="absolute inset-0 border-2 border-purple-300 border-dashed rounded-lg opacity-50 pointer-events-none"></div>
                    </div>

                    {{-- Control Buttons --}}
                    <div class="mt-6 space-y-4">
                        <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                            <button id="captureBtn"
                                    class="inline-flex items-center px-8 py-3 font-semibold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-purple-500 to-purple-400 hover:from-purple-600 hover:to-purple-500 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                    disabled>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Mulai Capture & Training
                            </button>

                            <a href="{{ route('siswa.index') }}" type="button"
                                class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                Batal
                            </a>
                        </div>
                        <p class="text-sm text-gray-500">Capture 5 posisi wajah untuk pelatihan sistem presensi</p>
                    </div>

                    {{-- Loading State --}}
                    <div id="loading" class="hidden mt-6">
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-8 h-8 border-b-2 border-purple-600 rounded-full animate-spin"></div>
                            <span class="text-lg font-semibold text-purple-600">Memproses capture & training...</span>
                        </div>
                        <div class="h-2 mt-4 overflow-hidden bg-gray-200 rounded-full">
                            <div id="progressBar" class="h-full transition-all duration-300 rounded-full bg-gradient-to-r from-purple-600 to-blue-600" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
        @keyframes glow-pulse {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        .alert-active {
            visibility: visible !important;
            opacity: 1 !important;
            transform: scale(1) !important;
        }

        .alert-active #alert-glow {
            animation: glow-pulse 2s ease-in-out infinite;
        }

        .countdown-animate {
            animation: countdown-tick 1s ease-in-out;
        }

        @keyframes countdown-tick {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        </style>

        {{-- Preview & Instructions Section --}}
        <div class="space-y-4">
            {{-- Instructions Card --}}
            <div class="bg-white border border-gray-100 rounded-sm shadow-lg">
                <div class="px-6 py-4 border-b border-gray-100 bg-blue-50">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Petunjuk
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-sm font-bold text-purple-600 bg-purple-100 rounded-full">1</div>
                            <p class="text-sm text-gray-700">Pastikan wajah terlihat jelas di dalam frame</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-sm font-bold text-purple-600 bg-purple-100 rounded-full">2</div>
                            <p class="text-sm text-gray-700">Sistem akan meminta 5 posisi: Depan, Kiri, Kanan, Atas, Bawah</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-sm font-bold text-purple-600 bg-purple-100 rounded-full">3</div>
                            <p class="text-sm text-gray-700">Setiap posisi akan dihitung mundur selama 3 detik</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-sm font-bold text-purple-600 bg-purple-100 rounded-full">4</div>
                            <p class="text-sm text-gray-700">Tetap dalam posisi hingga foto diambil</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="bg-white border border-gray-100 rounded-sm shadow-lg">
                <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Preview Gambar
                    </h3>
                </div>
                <div class="p-6">
                    <div id="preview" class="grid grid-cols-2 gap-3">
                        {{-- Preview images will appear here --}}
                    </div>
                    <div id="emptyPreview" class="py-8 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm">Gambar akan muncul di sini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // DOM Elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const captureBtn = document.getElementById('captureBtn');
    const loading = document.getElementById('loading');
    const preview = document.getElementById('preview');
    const emptyPreview = document.getElementById('emptyPreview');
    const progressBar = document.getElementById('progressBar');

    const instructionAlert = document.getElementById('instruction-alert');
    const positionIcon = document.getElementById('position-icon');
    const positionTitle = document.getElementById('position-title');
    const positionInstruction = document.getElementById('position-instruction');
    const positionCounter = document.getElementById('position-counter');
    const countdownNumber = document.getElementById('countdown-number');
    const countdownProgress = document.getElementById('countdown-progress');
    const alertGlow = document.getElementById('alert-glow');

    let isCapturing = false;
    let currentStream = null;

    const positions = [
        { name: "Depan", icon: "👤", instruction: "Lihat lurus ke kamera dengan wajah tegak" },
        { name: "Kiri", icon: "👈", instruction: "Putar kepala ke kiri 30 derajat" },
        { name: "Kanan", icon: "👉", instruction: "Putar kepala ke kanan 30 derajat" },
        { name: "Atas", icon: "👆", instruction: "Angkat kepala sedikit ke atas" },
        { name: "Bawah", icon: "👇", instruction: "Turunkan kepala sedikit ke bawah" }
    ];

    async function initializeCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user'
                }
            });
            currentStream = stream;
            video.srcObject = stream;
            video.onloadedmetadata = () => {
                video.play();
                enableCaptureButton();
            };
        } catch (err) {
            console.error('Camera error:', err);
            showErrorAlert('Gagal Akses Kamera', err.message);
        }
    }

    function enableCaptureButton() {
        captureBtn.disabled = false;
        captureBtn.innerHTML = `
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Mulai Capture & Training
        `;
    }

    function disableCaptureButton() {
        captureBtn.disabled = true;
        captureBtn.innerHTML = `
            <div class="w-5 h-5 mr-2 border-b-2 border-white rounded-full animate-spin"></div>
            Memproses...
        `;
    }

    function resetCaptureButton() {
        captureBtn.disabled = false;
        captureBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m17 2 4 4-4 4"></path><path d="M3 11v-1a4 4 0 0 1 4-4h14"></path>
                <path d="m7 22-4-4 4-4"></path><path d="M21 13v1a4 4 0 0 1-4 4H3"></path>
            </svg>
            Ulangi Capture
        `;
    }

    function showInstructionAlert(position, index, total) {
        if (!instructionAlert) return;
        positionIcon.textContent = position.icon;
        positionTitle.textContent = `Posisi: ${position.name}`;
        positionInstruction.textContent = position.instruction;
        positionCounter.textContent = `${index + 1}/${total}`;
        instructionAlert.classList.remove('hidden', 'alert-hidden');
        instructionAlert.classList.add('alert-active');
        alertGlow.style.opacity = '1';
        countdownNumber.textContent = '3';
        countdownProgress.style.strokeDashoffset = '125.6';
    }

    function hideInstructionAlert() {
        instructionAlert.classList.remove('alert-active');
        instructionAlert.classList.add('alert-hidden');
        alertGlow.style.opacity = '0';
    }

    function updateCountdown(number) {
        countdownNumber.textContent = number;
        countdownNumber.classList.add('countdown-animate');
        const progress = (4 - number) / 3;
        const offset = 125.6 - (progress * 125.6);
        countdownProgress.style.strokeDashoffset = offset;
        setTimeout(() => {
            countdownNumber.classList.remove('countdown-animate');
        }, 300);
    }

    function updateProgressBar(progress) {
        progressBar.style.width = progress + '%';
    }

    function showLoading() {
        loading.classList.remove("hidden");
        emptyPreview.style.display = 'none';
        preview.innerHTML = "";
    }

    function hideLoading() {
        loading.classList.add("hidden");
    }

    function addImageToPreview(imageData, position, index) {
        const imgContainer = document.createElement('div');
        imgContainer.className = 'relative group transform transition-all duration-300 hover:scale-105 opacity-0';
        imgContainer.innerHTML = `
            <img src="${imageData}" class="object-cover w-full h-24 border-2 border-gray-200 rounded-lg shadow-md" alt="${position.name}" />
            <div class="absolute inset-0 flex items-center justify-center p-1 text-center transition-opacity duration-200 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100">
                <span class="text-xs font-medium text-white">${position.name}</span>
            </div>
            <div class="absolute flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-green-500 rounded-full -top-2 -right-2">
                ${index + 1}
            </div>
        `;
        preview.appendChild(imgContainer);
        setTimeout(() => {
            imgContainer.style.opacity = '1';
            imgContainer.classList.add('animate-pulse');
            setTimeout(() => imgContainer.classList.remove('animate-pulse'), 500);
        }, 100);
    }

    function captureImage() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.save();
        ctx.scale(-1, 1);
        ctx.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
        ctx.restore();
        return canvas.toDataURL('image/png');
    }

    async function performCountdown() {
        let countdown = 3;
        updateCountdown(countdown);
        return new Promise((resolve) => {
            const interval = setInterval(() => {
                countdown--;
                if (countdown > 0) {
                    updateCountdown(countdown);
                } else {
                    clearInterval(interval);
                    resolve();
                }
            }, 1000);
        });
    }

    async function sendImagesToServer(images) {
        const response = await fetch("{{ route('siswa.capture-train', $siswa->id) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ images })
        });

        const data = await response.json();
        if (response.ok && data.status === 'success') {
            showSuccessAlert('Berhasil! 🎉', data.message, () => {
                if (data.redirect) window.location.href = data.redirect;
            });
        } else {
            throw new Error(data.message || 'Gagal proses training.');
        }
    }

    async function startMultiCapture() {
        if (isCapturing) return;
        isCapturing = true;

        const images = [];
        const totalPositions = positions.length;
        const capturesPerPosition = 5; // Ambil 5 data per posisi
        const totalImages = totalPositions * capturesPerPosition;

        try {
            showLoading();
            disableCaptureButton();
            if (video) video.style.transform = 'scaleX(-1)';

            for (let i = 0; i < totalPositions; i++) {
                const pos = positions[i];

                showInstructionAlert(pos, i, totalPositions);
                await performCountdown();

                for (let j = 0; j < capturesPerPosition; j++) {
                    await new Promise(resolve => setTimeout(resolve, 300));

                    const image = captureImage();
                    const globalIndex = i * capturesPerPosition + j;

                    if (image) {
                        images.push(image);
                        addImageToPreview(image, pos, globalIndex);
                        updateProgressBar(((globalIndex + 1) / totalImages) * 100);
                    } else {
                        throw new Error(`Gagal capture ${j + 1} dari posisi ${pos.name}`);
                    }

                    // Delay antar capture agar wajah tidak kaku
                    await new Promise(resolve => setTimeout(resolve, 400));
                }

                hideInstructionAlert();
                await new Promise(resolve => setTimeout(resolve, 500));
            }

            await sendImagesToServer(images);

        } catch (err) {
            console.error(err);
            showErrorAlert('Gagal', err.message);
        } finally {
            hideLoading();
            hideInstructionAlert();
            resetCaptureButton();
            updateProgressBar(0);
            isCapturing = false;
            video.style.transform = '';
            if (images.length === 0) emptyPreview.style.display = 'block';
        }
    }


    function showSuccessAlert(title, message, callback) {
        Swal.fire({
            icon: 'success',
            title, text: message,
            confirmButtonColor: '#6B46C1',
            customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg' }
        }).then(callback);
    }

    function showErrorAlert(title, message) {
        Swal.fire({
            icon: 'error',
            title, text: message,
            confirmButtonColor: '#e53e3e',
            customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg' }
        });
    }

    function cleanup() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
    }

    if (captureBtn) captureBtn.addEventListener('click', startMultiCapture);
    window.addEventListener('beforeunload', cleanup);

    document.readyState === 'loading'
        ? document.addEventListener('DOMContentLoaded', initializeCamera)
        : initializeCamera();

    window.cameraTraining = { startMultiCapture, initializeCamera, cleanup };
</script>


@endsection
