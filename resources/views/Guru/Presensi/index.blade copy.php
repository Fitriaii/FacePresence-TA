@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    <!-- Header dan Breadcrumb -->
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Presensi Siswa</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('gurudashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <span class="text-gray-400">Presensi</span>
            </div>
        </div>
    </div>

    <div class="z-50 p-6 mb-6 bg-white rounded-sm shadow-lg font-heading">
        <div class="mb-6">
            <h2 class="mb-4 text-lg font-bold text-purple-800 font-heading">Info Pertemuan</h2>
            <div class="flex flex-col gap-4 mt-2">
                <!-- Kelas -->
                <div class="flex items-center gap-2">
                    <label class="w-32 text-sm font-medium text-black font-heading">Kelas</label>
                    <span class="text-sm font-semibold text-black">:</span>
                    @if($kelasList->isEmpty())
                        <p class="text-sm text-red-600">Tidak ada data kelas yang tersedia untuk Anda.</p>
                    @else
                        <select id="kelas" name="kelas_id" class="p-1 text-sm text-gray-700 border border-gray-300 rounded">
                            <option value="" disabled selected>Pilih Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" data-kelas="{{ $kelas->nama_kelas }}">
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <!-- Mata Pelajaran -->
                <div class="flex items-center gap-2">
                    <label class="w-32 text-sm font-medium text-black font-heading">Mata Pelajaran</label>
                    <span class="text-sm font-semibold text-black">:</span>
                    @if($mapels->isEmpty())
                        <p class="text-sm text-red-600">Tidak ada mata pelajaran yang Anda ampu.</p>
                    @else
                        <select id="mapel" name="mapel_id" class="p-1 text-sm text-gray-700 border border-gray-300 rounded" disabled>
                            <option value="" disabled selected>Pilih Kelas Terlebih Dahulu</option>
                        </select>
                    @endif
                </div>
            </div>


        </div>


        <div class="mb-6" x-data="{ tab: 'kamera' }">
            <div class="flex flex-wrap border-b border-gray-200">
                <!-- Presensi Kamera -->
                <button
                    @click="tab = 'kamera'"
                    :class="tab === 'kamera' ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-600'"
                    class="flex items-center gap-2 px-6 py-2 text-sm font-medium border-b-2 focus:outline-none">
                    <!-- Ikon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                    Presensi Kamera
                </button>

                <!-- Presensi Manual -->
                <button
                    @click="tab = 'manual'"
                    :class="tab === 'manual' ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-600'"
                    class="flex items-center gap-2 px-6 py-2 text-sm font-medium border-b-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Presensi Manual
                </button>


            </div>

            <!-- Konten Tab -->
            <div class="mt-4">
                <!-- Tab Kamera -->
                <div x-show="tab === 'kamera'" class="mt-4">
                    <div class="mb-4">
                        <div id="videoWrapper"
                             class="relative flex flex-col items-center justify-center overflow-hidden bg-gray-900 rounded-lg aspect-video"
                             data-presensi-id="{{ $presensi }}">
                            <video id="video" autoplay class="object-cover w-full h-full rounded-lg"></video>

                            <div id="cameraOverlay"
                                 class="absolute inset-0 flex flex-col items-center justify-center text-white transition-opacity duration-300 bg-black bg-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2 text-gray-300" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v9a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                    <circle cx="12" cy="13" r="4"/>
                                </svg>
                                <p class="text-sm text-gray-300">Kamera belum diaktifkan</p>
                            </div>

                            <canvas id="canvas" class="hidden"></canvas>
                        </div>

                        <div class="flex justify-center mt-4">
                            <button id="recognizeBtn"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Mulai Pengenalan Wajah
                            </button>
                        </div>
                    </div>
                </div>




                <!-- Tab Manual -->
                <form x-show="tab === 'manual'" action="" method="POST">
                    @csrf
                    <div class="relative mb-6">
                        <!-- Search Input -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" ... class="w-5 h-5"> ... </svg>
                        </div>
                        <input type="text" placeholder="Cari siswa..." class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Tabel Manual -->
                    <div class="w-full overflow-x-auto bg-white rounded-lg shadow-md">
                        <table class="min-w-full">
                            {{-- <!-- Thead & Loop Data -->
                            @foreach ($siswa as $index => $item)
                            <tr>
                                <!-- ... nama, status ... -->
                                <td>
                                    <div class="flex flex-col gap-1 text-sm">
                                        @foreach (['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                                        <label class="inline-flex items-center gap-1">
                                            <input type="radio" name="kehadiran[{{ $item->id }}]" value="{{ $status }}">
                                            {{ $status }}
                                        </label>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="keterangan[{{ $item->id }}]" class="w-full px-2 py-1 text-sm border-gray-300 rounded-md focus:ring focus:ring-blue-200">
                                </td>
                            </tr>
                            @endforeach --}}
                        </table>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none">
                            Simpan Presensi Manual
                        </button>
                    </div>
                </form>

            </div>
        </div>





    </div>
</div>

<script>
    const video = document.getElementById('video');
    const recognizeBtn = document.getElementById('recognizeBtn');
    const videoWrapper = document.getElementById('videoWrapper');
    const jadwalId = videoWrapper.dataset.jadwalId; // GANTI dari presensiId
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Set ukuran canvas sesuai video
    video.addEventListener('loadedmetadata', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
    });

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
            document.getElementById('cameraOverlay').style.display = 'none';
        })
        .catch((error) => {
            console.error("Webcam error:", error);
            Swal.fire('Error', 'Gagal mengakses kamera.', 'error');
        });

    recognizeBtn.addEventListener('click', () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');

        Swal.fire({
            title: 'Mengenali wajah...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch('/siswa-recognize', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                image: imageData,
                presensi_id: jadwalId  // anggap presensi_id = jadwal_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log("Wajah dikenali:", data.siswa);
                Swal.close(); // Tutup loading
                markAttendance(data.siswa.id);
            } else {
                Swal.fire('Gagal', data.message || 'Wajah tidak dikenali', 'warning');
            }
        })
        .catch(error => {
            console.error("Gagal mengenali wajah:", error);
            Swal.fire('Error', 'Terjadi kesalahan saat mengenali wajah.', 'error');
        });
    });

    function markAttendance(siswaId) {
        Swal.fire({
            title: 'Mencatat presensi...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch('/mark-attendance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                siswa_id: siswaId,
                presensi_id: jadwalId
            })
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.status === 'success') {
                Swal.fire('Presensi Berhasil', 'Presensi telah dicatat.', 'success');
            } else if (data.status === 'already_marked') {
                Swal.fire('Sudah Presensi', 'Presensi sudah tercatat sebelumnya.', 'info');
            } else {
                Swal.fire('Presensi Gagal', data.message || 'Terjadi kesalahan saat menyimpan presensi.', 'error');
            }
        })
        .catch(error => {
            console.error("Presensi gagal:", error);
            Swal.fire('Error', 'Terjadi kesalahan saat menyimpan presensi.', 'error');
        });
    }
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const kelasSelect = document.getElementById('kelas');
        const mapelSelect = document.getElementById('mapel');

        // Data jadwal dari controller
        const jadwalData = @json($jadwal);

        kelasSelect.addEventListener('change', function() {
            const kelasId = this.value;

            // Reset dan enable mapel dropdown
            mapelSelect.innerHTML = '';
            mapelSelect.disabled = false;

            // Default option
            const defaultOption = document.createElement('option');
            defaultOption.text = 'Pilih Mata Pelajaran';
            defaultOption.value = '';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            mapelSelect.appendChild(defaultOption);

            // Filter mapel berdasarkan kelas yang dipilih
            const filteredJadwal = jadwalData.filter(j => j.kelas_id == kelasId);
            const mapelOptions = [];

            filteredJadwal.forEach(jadwal => {
                // Cek apakah mapel sudah ada di array options untuk mencegah duplikat
                const exists = mapelOptions.some(m => m.id === jadwal.mapel.id);
                if (!exists) {
                    mapelOptions.push({
                        id: jadwal.mapel.id,
                        nama: jadwal.mapel.nama_mapel
                    });
                }
            });

            // Tambahkan opsi mapel ke dropdown
            mapelOptions.forEach(mapel => {
                const option = document.createElement('option');
                option.value = mapel.id;
                option.setAttribute('data-mapel', mapel.nama);
                option.text = mapel.nama;
                mapelSelect.appendChild(option);
            });

            // Jika tidak ada mapel untuk kelas ini
            if (mapelOptions.length === 0) {
                const noOption = document.createElement('option');
                noOption.text = 'Tidak ada mapel untuk kelas ini';
                noOption.disabled = true;
                noOption.selected = true;
                mapelSelect.appendChild(noOption);
            }
        });
    });
</script> -->



@endsection
