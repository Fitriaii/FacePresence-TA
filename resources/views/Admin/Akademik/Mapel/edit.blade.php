@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Mata Pelajaran</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('mapel.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Mata Pelajaran</a>
                <span>/</span>
                <span class="text-gray-400">Edit Mata Pelajaran</span>
            </div>
        </div>
    </div>

    {{-- Input Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm drop-shadow">

        <form id="userForm" action="{{ route('mapel.update', $mapel) }}" method="POST" class="space-y-3">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Mata Pelajaran</h3>

                <!-- Kode Mapel -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="kode_mapel" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Kode Mapel <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="kode_mapel"
                            name="kode_mapel"
                            value="{{ old('kode_mapel', isset($mapel) ? $mapel->kode_mapel : '') }}"
                            required
                            placeholder="Masukkan Kode Mapel"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                        @error('kode_mapel')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Nama Mapel -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nama_mapel" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Nama Mapel <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="nama_mapel"
                            id="nama_mapel"
                            value="{{ old('nama_mapel', isset($mapel) ? $mapel->nama_mapel : '') }}"
                            required
                            name="nama_mapel"
                            placeholder="Masukkan Nama Mapel"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />

                        @error('nama_mapel')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Guru -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="guru" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Guru Pengampu <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="guru"
                            id="guru"
                            required
                            class="w-full px-4 py-3 mb-4 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled {{ old('guru', $selectedGuruId ?? '') == '' ? 'selected' : '' }}>Pilih Guru</option>
                            @foreach ($guruList as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru', $selectedGuruId ?? '') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col justify-end gap-4 pt-6 border-t border-gray-200 sm:flex-row">
                <a href="{{ route('mapel.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data Mata Pelajaran
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectGuru = document.getElementById('guru');
        const selectedValue = @json(old('guru', $mapel->guru_id ?? ''));

        if (selectedValue) {
            selectGuru.value = selectedValue;
        }
    });
</script>
@endsection
