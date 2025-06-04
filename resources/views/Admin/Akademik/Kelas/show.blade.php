@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="relative z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Detail Data Kelas</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('room.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Kelas</a>
                <span>/</span>
                <span class="text-gray-400">Detail Kelas</span>
            </div>
        </div>
    </div>

    {{-- Show Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm drop-shadow">
        {{-- Back Page --}}
        <div class="flex items-center mb-2">
            <a href="{{ route('room.index') }}" class="inline-flex items-center px-4 py-2 font-sans text-sm font-medium text-white bg-purple-500 rounded-lg hover:bg-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="w-full">
            <div class="p-4">
                <div class="mb-8">
                    <h2 class="pb-2 mb-6 text-lg font-semibold text-purple-900 border-b border-gray-200">Informasi Mata Pelajaran</h2>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Kelas</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $room->nama_kelas }}</p>
                            </div>
                        </div>

                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Jenis Kelas</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $room->jenis_kelas }}</p>
                            </div>
                        </div>

                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Wali Kelas</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $room->guru->nama_guru }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mb-8">
                    <h2 class="pb-2 mb-6 text-lg font-semibold text-purple-900 border-b border-gray-200">Informasi Sistem</h2>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Dibuat Pada</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $room->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $room->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
