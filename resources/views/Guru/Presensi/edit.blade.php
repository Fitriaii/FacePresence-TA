@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Presensi</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('gurudashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('presensi.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Presensi</a>
                <span>/</span>
                <span class="text-gray-400">Edit Presensi</span>
            </div>
        </div>
    </div>

    <div class="z-50 p-6 mb-6 bg-white rounded-sm shadow-lg font-heading">
        <div class="mb-6">
            <h2 class="mb-6 text-lg font-bold text-purple-800 font-heading">Edit Presensi</h2>

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

            <!-- Form Presensi -->
            <div class="mb-6 space-x-8">

                <!-- Tab Konten: Manual -->
                <form action="{{ route('presensi.update', $presensi) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

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
                                @php
                                    $status = old("status", $presensi->status ?? null);
                                    $catatan = old("catatan", $presensi->catatan ?? '');
                                @endphp
                                <tr class="text-xs text-gray-700 border-t hover:bg-gray-50">
                                    <td class="px-6 py-2 text-sm text-gray-900 whitespace-nowrap">
                                        1
                                        {{-- bisa tambahkan hidden input jika perlu --}}
                                        <input type="hidden" name="siswa_kelas_id" value="{{ $presensi->siswa_kelas_id }}">
                                    </td>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $siswa->nis }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900">{{ $siswa->nama_siswa }}</td>

                                    {{-- Hadir --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="status" value="Hadir" {{ $status === 'Hadir' ? 'checked' : '' }} required>
                                    </td>

                                    {{-- Sakit --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="status" value="Sakit" {{ $status === 'Sakit' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Izin --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="status" value="Izin" {{ $status === 'Izin' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Alpha --}}
                                    <td class="px-6 py-2 text-sm text-center text-gray-900">
                                        <input type="radio" name="status" value="Alpha" {{ $status === 'Alpha' ? 'checked' : '' }}>
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="px-6 py-2 text-xs text-gray-600">
                                        <input type="text" name="catatan" class="w-full px-2 py-1 border rounded"
                                            placeholder="Opsional" value="{{ $catatan }}">
                                    </td>
                                </tr>
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
                                Perbarui Presensi
                            </span>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
@endsection
