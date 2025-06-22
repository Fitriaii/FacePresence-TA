@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">

    <!-- Header dan Breadcrumb -->
    <div class="mb-4 bg-white rounded-sm shadow-sm">
        <div class="flex items-center justify-between p-6">
            <div>
                <h1 class="text-xl font-bold text-purple-800 font-heading">Presensi Siswa</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola informasi dan data presensi siswa</p>
            </div>
            <nav class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('gurudashboard') }}"
                   class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">
                    Beranda
                </a>
                <span>/</span>
                <span class="text-gray-400">Presensi</span>
            </nav>
        </div>
    </div>
    <!-- Main Content Card -->
    <div class="overflow-hidden bg-white border border-gray-100 rounded-sm shadow-sm">
        <!-- Form Pilih Jadwal -->
        <div class="p-6 border-b border-gray-100">
            <h2 class="mb-6 text-lg font-semibold text-purple-800 font-heading">Pilih Jadwal</h2>

            <form action="{{ route('presensi.index') }}" method="GET">
                <div class="grid items-end grid-cols-1 gap-4 lg:grid-cols-12">
                    <!-- Jadwal Selection -->
                    <div class="space-y-2 lg:col-span-10">
                        <label for="jadwal_id" class="block text-sm font-medium text-gray-700">
                            Jadwal Pembelajaran
                        </label>
                        <select
                            name="jadwal_id"
                            id="jadwal_id"
                            class="w-full px-4 py-3 text-sm transition-colors bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 dark:bg-white dark:text-gray-900 dark:border-gray-300">
                            <option value="">Pilih jadwal pembelajaran...</option>
                            @foreach ($jadwal as $j)
                                <option value="{{ $j->id }}" {{ request('jadwal_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->mapel->nama_mapel }} - {{ $j->kelas->nama_kelas }} - {{ $j->hari }} ({{ $j->jam_mulai }} - {{ $j->jam_selesai }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="lg:col-span-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center flex-1 w-full px-6 py-3 text-sm font-medium text-white transition-colors bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-2 focus:ring-purple-500/20 focus:outline-none">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Informasi Jadwal Terpilih -->
        @if ($selectedJadwal)
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-indigo-50/50">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-purple-800 font-heading">Informasi Jadwal</h2>
                <a href="{{ route('presensiJadwal.create', ['jadwalId' => $selectedJadwal->id]) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-700 transition bg-purple-100 border border-purple-200 rounded-lg hover:border-purple-300 hover:bg-purple-200 focus:ring-purple-500/20 focus:outline-none">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                     </svg>
                     Tambah Presensi
                 </a>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-4 bg-white border border-gray-100 rounded-lg">
                    <div class="mb-1 text-xs font-medium tracking-wide text-gray-500 uppercase">Mata Pelajaran</div>
                    <div class="text-sm font-semibold text-gray-900">{{ $selectedJadwal->mapel->nama_mapel }}</div>
                </div>

                <div class="p-4 bg-white border border-gray-100 rounded-lg">
                    <div class="mb-1 text-xs font-medium tracking-wide text-gray-500 uppercase">Kelas</div>
                    <div class="text-sm font-semibold text-gray-900">{{ $selectedJadwal->kelas->nama_kelas }}</div>
                </div>

                <div class="p-4 bg-white border border-gray-100 rounded-lg">
                    <div class="mb-1 text-xs font-medium tracking-wide text-gray-500 uppercase">Hari</div>
                    <div class="text-sm font-semibold text-gray-900">{{ $selectedJadwal->hari }}</div>
                </div>

                <div class="p-4 bg-white border border-gray-100 rounded-lg">
                    <div class="mb-1 text-xs font-medium tracking-wide text-gray-500 uppercase">Waktu</div>
                    <div class="text-sm font-semibold text-gray-900">{{ $selectedJadwal->jam_mulai }} - {{ $selectedJadwal->jam_selesai }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabel Data Presensi -->
        <div class="p-6">
            <h2 class="mb-4 text-lg font-semibold text-purple-800 font-heading">Data Presensi</h2>

            @if (!isset($presensi) || $presensi->isEmpty())
                <div class="py-12 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="mb-1 text-sm font-medium text-gray-900">Belum ada data presensi</h3>
                    <p class="text-sm text-gray-500">
                        {{ $selectedJadwal ? 'Belum ada data presensi untuk jadwal ini' : 'Silahkan pilih jadwal terlebih dahulu' }}
                    </p>
                </div>
            @else
            <div class="overflow-hidden">
                <div class="mt-2 overflow-auto rounded-sm shadow-sm">
                    <table class="min-w-full bg-white rounded shadow-md">
                        <thead>
                            <tr class="text-sm font-semibold text-gray-700 bg-gray-100 font-heading">
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">No</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Mata Pelajaran</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Kelas</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Siswa</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presensi as $index => $p)
                                <tr class="text-sm text-gray-700 border-t hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $presensi->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($p->waktu_presensi)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $p->jadwal->mapel->nama_mapel }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $p->jadwal->kelas->nama_kelas }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $p->siswa_kelas->siswa->nama_siswa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($p->status == 'Hadir')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                                Hadir
                                            </span>
                                        @elseif ($p->status == 'Izin')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></div>
                                                Izin
                                            </span>
                                        @elseif ($p->status == 'Sakit')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></div>
                                                Sakit
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></div>
                                                Alpa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $p->catatan ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('presensi.edit',$p) }}" class="text-purple-600 hover:text-purple-800" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('presensi.destroy', $p) }}" method="POST" id="deleteForm-{{ $p->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-600 hover:text-red-800" title="Hapus" onclick="confirmDelete({{ $p->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    @include('components.pagination', ['data' => $presensi])
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kelasSelect = document.getElementById('kelas');
        const mapelSelect = document.getElementById('mapel');

        // Data jadwal dari controller
        const jadwalData = @json($jadwal);

        if (kelasSelect && mapelSelect) {
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
        }
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Presensi ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        });
    }
</script>
@if (session('status') === 'success' && session('message'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('message')),
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('status') === 'error' && session('message'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: @json(session('message')),
            showConfirmButton: true
        });
    </script>
@endif
@endsection
