@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Kelas</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('room.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Kelas</a>
                <span>/</span>
                <span class="text-gray-400">Edit Kelas</span>
            </div>
        </div>
    </div>

    {{-- Input Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm drop-shadow">

        <form id="userForm" action="{{ route('room.update', $room) }}" method="POST" class="space-y-3">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Kelas</h3>

                <!-- Nama Kelas -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nama_kelas" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="nama_kelas"
                            name="nama_kelas"
                            value="{{ old('nama_kelas' ,isset($room) ? $room->nama_kelas : '') }}"
                            required
                            placeholder="Contoh: 7A Reguler"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                        @error('nama_kelas')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Jenis Kelas -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="jenis_kelas" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Jenis Kelas <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="jenis_kelas"
                            id="jenis_kelas"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled {{ old('jenis_kelas', $room->jenis_kelas ?? '') == '' ? 'selected' : '' }}>Pilih Jenis Kelas</option>
                            <option value="Reguler" {{ old('jenis_kelas', $room->jenis_kelas ?? '') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="Tahfidz" {{ old('jenis_kelas', $room->jenis_kelas ?? '') == 'Tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                        </select>
                        @error('jenis_kelas')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tingkatan Kelas -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="tingkatan_kelas" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Tingkatan Kelas <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="tingkatan_kelas"
                            id="tingkatan_kelas"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled {{ old('tingkatan_kelas', $room->tingkatan_kelas ?? '') == '' ? 'selected' : '' }}>Pilih Tingkatan Kelas</option>
                            <option value="7" {{ old('tingkatan_kelas', $room->tingkatan_kelas ?? '') == '7' ? 'selected' : '' }}>7</option>
                            <option value="8" {{ old('tingkatan_kelas', $room->tingkatan_kelas ?? '') == '8' ? 'selected' : '' }}>8</option>
                            <option value="9" {{ old('tingkatan_kelas', $room->tingkatan_kelas ?? '') == '9' ? 'selected' : '' }}>9</option>
                        </select>
                        @error('tingkatan_kelas')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Wali Kelas -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="guru" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Wali Kelas <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="guru"
                            id="guru"
                            required
                            class="w-full px-4 py-3 mb-4 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled {{ old('guru') == '' ? 'selected' : '' }}>Pilih Wali Kelas</option>
                            @foreach ($guruList as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru') == $guru->id ? 'selected' : '' }}>
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
                <a href="{{ route('room.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data Kelas
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectGuru = document.getElementById('guru');
        const selectedValue = @json(old('guru', $room->guru_id ?? ''));

        if (selectedValue) {
            selectGuru.value = selectedValue;
        }
    });
</script>
@endsection
