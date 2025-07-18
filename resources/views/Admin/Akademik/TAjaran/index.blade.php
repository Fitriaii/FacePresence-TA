@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <!-- Header dan Breadcrumb -->
    <div class="mb-4 bg-white rounded-sm shadow-sm">
        <div class="flex items-center justify-between p-6">
            <div>
                <h1 class="text-xl font-bold text-purple-800 font-heading">Tahun Ajaran</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola informasi dan data tahun ajaran</p>
            </div>
            <nav class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}"
                   class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">
                    Beranda
                </a>
                <span>/</span>
                <span class="text-gray-400">Tahun Ajaran</span>
            </nav>
        </div>
    </div>

    <div class="z-50 p-6 mb-6 bg-white rounded-sm shadow-lg font-heading">
        <div class="mx-auto max-w-7xl">
            <!-- Top Row: Action Buttons -->
            <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
                <!-- Kiri: Tombol Tambah dan Export -->
                <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
                    <!-- Tombol Tambah -->
                    <form action="{{ route('tahunajaran.create') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full gap-2 px-4 py-2 font-sans text-sm font-semibold text-purple-700 transition bg-purple-100 border border-purple-200 rounded-lg hover:border-purple-300 hover:bg-purple-200 sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Tambah
                        </button>
                    </form>

                    {{-- <!-- Tombol Export -->
                    <button class="flex items-center w-full gap-2 px-4 py-2 font-sans text-sm font-semibold text-green-700 transition-all duration-200 border border-green-200 rounded-lg bg-green-50 hover:bg-green-100 hover:border-green-300 sm:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </button> --}}
                </div>

                <!-- Kanan: Search -->
                <form id="searchForm" method="GET" action="{{ route('siswa.index') }}" class="w-full sm:w-auto">
                    <div class="relative w-full sm:w-60">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="searchInput"
                            name="search"
                            placeholder="Cari data..."
                            value="{{ request('search') }}"
                            class="w-full py-2.5 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:outline-none dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500  bg-white placeholder-gray-400 "
                        >
                    </div>
                </form>
            </div>

            <!-- Filter & Controls -->
            <form method="GET" action="{{ route('tahunajaran.index') }}" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                    <!-- Jenis Kelas Filter -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Tahun Mulai Ajaran Filter -->
                    <div class="space-y-2">
                        <label for="tahun_ajaran" class="block text-sm font-semibold text-gray-700">Tahun Mulai</label>
                        <select name="tahun_mulai" id="tahun_mulai"
                            class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunList as $ta)
                                <option value="{{ $ta }}" {{ request('tahun_mulai') == $ta ? 'selected' : '' }}>
                                    {{ $ta }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div class="space-y-2">
                        <label for="sort" class="block text-sm font-semibold text-gray-700">Urutkan Berdasarkan</label>
                        <select id="sort" name="sort" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500">
                            <option value="created_desc" {{ request('sort') === 'created_desc' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                            <option value="created_asc" {{ request('sort') === 'created_asc' ? 'selected' : '' }}>Terlama Ditambahkan</option>
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-transparent">Reset</label>
                        <a href="{{ route('tahunajaran.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300 rounded-lg hover:bg-gray-100 hover:border-gray-400 focus:ring-2 focus:ring-gray-500 focus:outline-none transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset Filter
                        </a>
                    </div>
                </div>
            </form>

            <!-- Results Info -->
            <div class="pt-4 mt-4 border-t border-gray-200">
                <div class="flex flex-col gap-3 text-sm text-gray-600 md:flex-row md:items-center md:justify-between">
                    <!-- Kiri: Info jumlah data -->
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <span>
                            Menampilkan
                            <span class="font-medium text-gray-900">{{ $tahunAjaran->firstItem() ?? 0 }}–{{ $tahunAjaran->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium text-gray-900">{{ $tahunAjaran->total() }}</span> data
                        </span>
                    </div>

                    <!-- Kanan: Info waktu update -->
                    @if ($tahunAjaran->count())
                        <div class="text-gray-500">
                            Terakhir diperbarui:
                            <span class="font-medium">{{ $tahunAjaran->first()->updated_at->diffForHumans() }}</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="mt-4 overflow-auto rounded-sm shadow-sm">
            <table class="min-w-full bg-white rounded shadow-md">
                <thead>
                    <tr class="text-sm font-semibold text-gray-700 bg-gray-100 font-heading">
                        <th class="px-4 py-3 text-left uppercase whitespace-nowrap">No</th>
                        <th class="px-4 py-3 text-left uppercase whitespace-nowrap">Tahun Ajaran</th>
                        <th class="px-4 py-3 text-left uppercase whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-left uppercase whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tahunAjaran as $ta)
                    <tr class="text-sm text-gray-700 border-t hover:bg-gray-50">
                        <!-- No -->
                        <td class="px-4 py-3 text-left whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>

                        <!-- Tahun Ajaran -->
                        <td class="px-4 py-3 text-left whitespace-nowrap">
                            {{ $ta->tahun_ajaran }}
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-3 text-left whitespace-nowrap">
                            @if ($ta->status === 'Aktif')
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 border border-green-200 rounded-full">
                                <div class="w-2 h-2 mr-2 bg-green-400 rounded-full animate-pulse"></div>
                                {{ $ta->status }}
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-800 bg-red-100 border border-red-200 rounded-full">
                                <div class="w-2 h-2 mr-2 bg-red-400 rounded-full"></div>
                                {{ $ta->status }}
                            </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-left whitespace-nowrap">
                            <div class="flex space-x-2 justify-left">

                                <!-- Toggle Button with AJAX -->
                                <button
                                    type="button"
                                    class="btn-toggle-status inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg
                                        transition-all duration-200 transform hover:scale-105 active:scale-95
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-opacity-50
                                        {{ $ta->status === 'Aktif'
                                            ? 'bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 focus:ring-red-500 shadow-md'
                                            : 'bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 focus:ring-green-500 shadow-md'
                                        }}"
                                    title="{{ $ta->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }} Tahun Ajaran"
                                    data-id="{{ $ta->id }}"
                                    data-status="{{ $ta->status }}"
                                    data-ta="{{ $ta->tahun_ajaran }}"
                                    data-active-count="{{ $activeCount }}"
                                >
                                    <span class="toggle-icon">
                                        @if($ta->status === 'Aktif')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path><path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                                                <path d="M12 2v4"></path><path d="m2 2 20 20"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9"></path>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="toggle-text">{{ $ta->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                </button>

                                {{-- Tombol Edit --}}
                                <form action="{{ route('tahunajaran.edit', $ta) }}" method="GET" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-800" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('tahunajaran.destroy', $ta) }}" method="POST" class="inline-block" id="deleteForm-{{$ta->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-800" title="Hapus" onclick="confirmDelete({{ $ta->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-sm text-gray-500">
                        <td colspan="4" class="px-4 py-3 text-center">Tidak ada data tahun ajaran yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            @include('components.pagination', ['data' => $tahunAjaran])
        </div>
    </div>
</div>

<script>
    // Live search debounce
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let typingTimer;
    const delay = 400;

    if (searchInput && searchForm) {
        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                searchForm.submit();
            }, delay);
        });

        searchInput.addEventListener('keydown', () => clearTimeout(typingTimer));
    }

    // Auto-submit filter form saat filter berubah
    const filterForm = document.getElementById('filterForm');
    ['status', 'tahun_mulai', 'sort'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', () => {
            filterForm?.submit();
        });
    });

    // Handler tombol toggle status
    document.querySelectorAll('.btn-toggle-status').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const status = this.dataset.status;
            const tahunAjaran = this.dataset.ta;
            const activeCount = parseInt(this.dataset.activeCount || "0");

            const newStatus = status === 'Aktif' ? 'Nonaktif' : 'Aktif';
            const actionText = status === 'Aktif' ? 'menonaktifkan' : 'mengaktifkan';
            const actionPast = status === 'Aktif' ? 'dinonaktifkan' : 'diaktifkan';

            // Jika sedang ingin mengaktifkan dan sudah ada tahun ajaran aktif lainnya
            if (status === 'Tidak Aktif' && activeCount >= 1) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Hanya satu tahun ajaran yang bisa aktif. Mengaktifkan tahun ajaran ini akan menonaktifkan yang lainnya.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                }).then((confirmResult) => {
                    if (confirmResult.isConfirmed) {
                        showConfirmationAndProceed(id, status, tahunAjaran, actionText, actionPast);
                    }
                });
            } else {
                showConfirmationAndProceed(id, status, tahunAjaran, actionText, actionPast);
            }
        });
    });

    function showConfirmationAndProceed(id, status, tahunAjaran, actionText, actionPast) {
        Swal.fire({
            title: 'Konfirmasi',
            text: `Yakin ingin ${actionText} tahun ajaran ${tahunAjaran}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: status === 'Aktif' ? '#dc2626' : '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Ya, ${actionText}`,
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch(`/tahunajaran/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ _method: 'PATCH' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Tahun ajaran ${tahunAjaran} berhasil ${actionPast}.`,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Gagal mengubah status');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Gagal!',
                        text: error.message,
                        icon: 'error'
                    });
                });
            }
        });
    }

    // Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Tahun Ajaran ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${id}`)?.submit();
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
