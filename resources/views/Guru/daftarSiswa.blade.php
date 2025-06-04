@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <!-- Header dan Breadcrumb -->
    <div class="mb-4 bg-white rounded-sm shadow-sm">
        <div class="flex items-center justify-between p-6">
            <div>
                <h1 class="text-xl font-bold text-purple-800 font-heading">Daftar Siswa</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola informasi dan data siswa dari kelas yang diampu berdasarkan jadwal</p>
            </div>
            <nav class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('gurudashboard') }}"
                   class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">
                    Beranda
                </a>
                <span>/</span>
                <span class="text-gray-400">Daftar Siswa</span>
            </nav>
        </div>
    </div>

    <div class="z-50 p-6 mb-6 bg-white rounded-sm shadow-lg font-heading">
        <div class="mx-auto max-w-7xl">

            <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
                <!-- Kanan: Search -->
                <form id="searchForm" method="GET" action="{{ route('daftarSiswa.index') }}" class="w-full">
                    <label for="searchInput" class="block mb-1 text-sm font-medium text-gray-700">Pencarian</label>
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="searchInput"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari siswa..."
                            class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        >
                    </div>
                </form>
            </div>

            <!-- Filter & Controls -->
            <form method="GET" action="{{ route('daftarSiswa.index') }}" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

                    <!-- Tahun Ajaran Filter -->
                    <div class="space-y-2">
                        <label for="tahun_ajaran" class="block text-sm font-semibold text-gray-700">Tahun Ajaran</label>
                        <select id="tahun_ajaran" name="tahun_ajaran"
                            class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition-colors duration-200">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach ($semuaTahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Kelas Filter -->
                    <div class="space-y-2">
                        <label for="jenis_kelas" class="block text-sm font-semibold text-gray-700">Jenis Kelas</label>
                        <select id="jenis_kelas" name="jenis_kelas"
                            class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition-colors duration-200">
                            <option value="">Semua Jenis Kelas</option>
                            <option value="Reguler" {{ request('jenis_kelas') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="Tahfidz" {{ request('jenis_kelas') == 'Tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                        </select>
                    </div>

                    <!-- Kelas Filter -->
                    <div class="space-y-2">
                        <label for="kelas" class="block text-sm font-semibold text-gray-700">Kelas</label>
                        <select id="kelas" name="kelas"
                            class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition-colors duration-200">
                            <option value="">Semua Kelas</option>
                            @foreach ($semuaKelas as $kls)
                                <option value="{{ $kls->id }}" {{ request('kelas') == $kls->id ? 'selected' : '' }}>
                                    {{ $kls->nama_kelas }} ({{ $kls->tingkatan_kelas }})
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Sort By -->
                    <div class="space-y-2">
                        <label for="sort" class="block text-sm font-semibold text-gray-700">Urutkan Berdasarkan</label>
                        <select id="sort" name="sort" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition-colors duration-200">
                            <option value="nama_siswa_asc" {{ request('sort') === 'nama_siswa_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="nama_siswa_desc" {{ request('sort') === 'nama_siswa_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            <option value="created_desc" {{ request('sort') === 'created_desc' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                            <option value="created_asc" {{ request('sort') === 'created_asc' ? 'selected' : '' }}>Terlama Ditambahkan</option>
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-transparent">Reset</label>
                        <a href="{{ route('daftarSiswa.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300 rounded-lg hover:bg-gray-100 hover:border-gray-400 focus:ring-2 focus:ring-gray-500 focus:outline-none transition-all duration-200">
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
                            <span class="font-medium text-gray-900">{{ $siswa->firstItem() ?? 0 }}–{{ $siswa->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium text-gray-900">{{ $siswa->total() }}</span> data
                        </span>
                    </div>

                    <!-- Kanan: Info waktu update -->
                    @if ($siswa->count())
                        <div class="text-gray-500">
                            Terakhir diperbarui:
                            <span class="font-medium">{{ $siswa->first()->updated_at->diffForHumans() }}</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="mt-4 overflow-auto rounded-sm shadow-sm">
                <table class="min-w-full bg-white rounded shadow-md">
                    <thead>
                        <tr class="text-sm font-semibold text-gray-700 bg-gray-100 font-heading">
                            <th class="px-4 py-3 text-left whitespace-nowrap">No</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">NIS</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Nama</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Kelas</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Tahun Ajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $s )
                            @php
                                $kelasTerbaru = $s->siswa_kelas->sortByDesc('created_at')->first();
                            @endphp
                        <tr class="text-sm text-gray-700 border-t hover:bg-gray-50">
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $s->nis }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $s->nama_siswa }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $s->jenis_kelamin }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $kelasTerbaru?->kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $kelasTerbaru?->tahunAjaran?->tahun_ajaran ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr class="text-sm text-gray-500">
                            <td colspan="7" class="px-4 py-3 text-center">Tidak ada data siswa yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
        <div class="mt-4">
            @include('components.pagination', ['data' => $siswa])
        </div>
    </div>

</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let typingTimer;
    const delay = 400;

    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                searchForm.submit();
            }, delay);
        });

        searchInput.addEventListener('keydown', () => {
            clearTimeout(typingTimer);
        });
    }

    // Filter change submit
    const filterForm = document.getElementById('filterForm');
    ['tahun_ajaran', 'jenis_kelas', 'kelas', 'sort'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', () => {
                filterForm.submit();
            });
        }
    });
    // Auto-submit filter form saat sort berubah
    document.getElementById('sort')?.addEventListener('change', () => {
        document.getElementById('filterForm').submit();
    });
</script>
@endsection
