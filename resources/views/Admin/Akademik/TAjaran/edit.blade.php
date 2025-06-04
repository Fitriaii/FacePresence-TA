@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Tahun Ajaran</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('tahunajaran.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Tahun Ajaran</a>
                <span>/</span>
                <span class="text-gray-400">Edit Tahun Ajaran</span>
            </div>
        </div>
    </div>


    {{-- Input Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm drop-shadow">

        <form id="userForm" action="{{ route('tahunajaran.update', $ta) }}" method="POST" class="space-y-3">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <h3 class="pb-4 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Tahun Ajaran</h3>

                <!-- Tahun Ajaran -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nama_siswa" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="tahun_ajaran"
                            name="tahun_ajaran"
                            value="{{ old('tahun_ajaran', $ta->tahun_ajaran ?? '') }}"
                            required
                            placeholder="Contoh: 2024/2025"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                        />
                        @error('tahun_ajaran')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Mulai -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="tanggal_mulai" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input
                                type="date"
                                id="tanggal_mulai"
                                name="tanggal_mulai"
                                value="{{ old('tanggal_mulai', $ta->tanggal_mulai ?? '') }}"
                                required
                                class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                            />
                            @error('tanggal_mulai')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Tanggal Selesai -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="tanggal_mulai" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input
                                type="date"
                                id="tanggal_selesai"
                                name="tanggal_selesai"
                                value="{{ old('tanggal_selesai', $ta->tanggal_selesai ?? '') }}"
                                required
                                class="w-full px-4 py-3 mb-4 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                            />
                        </div>

                        @error('tanggal_selesai')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>


            <div class="flex flex-col justify-end gap-4 pt-6 border-t border-gray-200 sm:flex-row">
                <a href="{{ route('tahunajaran.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data Tahun Ajaran
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const inputTanggalMulai = document.getElementById('tanggal_mulai');
    if (inputTanggalMulai && typeof inputTanggalMulai.showPicker === 'function') {
        inputTanggalMulai.addEventListener('focus', () => {
            inputTanggalMulai.showPicker();
        });
    }
    const inputTanggalSelesai = document.getElementById('tanggal_selesai');
    if (inputTanggalSelesai && typeof inputTanggalSelesai.showPicker === 'function') {
        inputTanggalSelesai.addEventListener('focus', () => {
            inputTanggalSelesai.showPicker();
        });
    }
</script>
@endsection
