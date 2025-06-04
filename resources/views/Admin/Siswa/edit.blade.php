@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Siswa</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('siswa.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Siswa</a>
                <span>/</span>
                <span class="text-gray-400">Edit Siswa</span>
            </div>
        </div>
    </div>

    {{-- Input Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm drop-shadow">

        <form id="siswaForm" action="{{ route('siswa.update', $siswa) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Personal</h3>

                <!-- Nama -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nama_siswa" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="nama_siswa"
                            name="nama_siswa"
                            value="{{ old('nama_siswa', isset($siswa) ? $siswa->nama_siswa : '') }}"
                            required
                            placeholder="Masukkan Nama Lengkap"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                        />
                        @error('nama_siswa')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- NIS -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nis" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            NIS <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            value="{{ old('nis', isset($siswa) ? $siswa->nis : '') }}"
                            required
                            placeholder="Masukkan NIS"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                        />
                        @error('nis')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- JK -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="jenis_kelamin" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="jenis_kelamin"
                            id="jenis_kelamin"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                        >
                            <option value="" disabled {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Akademik</h3>

                <!-- Kelas -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="kelas_id" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="kelas_id"
                            id="kelas_id"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 focus:border-purple-600 focus:ring-2 focus:ring-purple-100"
                        >
                            <option value="" disabled>Pilih Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : ''}}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>



                <!-- TA -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="tahun_ajaran_id" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input type="hidden" name="tahun_ajaran_id" value="{{ $activeTahunAjaran->id }}">
                        <input
                            type="text"
                            value="{{ $activeTahunAjaran->tahun_ajaran }}"
                            readonly
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 bg-gray-100 border border-gray-300 rounded-lg outline-none cursor-not-allowed"
                        >
                        <p class="mt-2 text-xs text-gray-500">Hanya menampilkan tahun ajaran yang aktif</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col justify-end gap-4 pt-8 border-t border-gray-200 sm:flex-row">
                <a href="{{ route('siswa.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data Siswa
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectKelas = document.getElementById('kelas_id');
        const selectTahunAjaran = document.getElementById('tahunajaran');
        const oldKelas = @json(old('kelas_id', $siswa->kelas_id ?? ''));
        const oldTahunAjaran = @json(old('tahun_ajaran_id', $siswa->tahun_ajaran_id ?? ''));
        if (oldKelas) {
            selectKelas.value = oldKelas;
        }
        if (oldTahunAjaran) {
            selectTahunAjaran.value = oldTahunAjaran;
        }

    });
</script> --}}
@endsection
