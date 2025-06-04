@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <div class="mb-1 bg-white rounded-sm shadow-sm ">
        <div class="p-4">
            <h1 class="text-2xl font-bold text-blue-800 font-heading">Dashboard Guru</h1>
            <p class="mb-4 font-sans text-gray-600">Selamat datang di dashboard guru PresenSee, {{ Auth::user()->name }}!</p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-orange-400 to-amber-400 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Kelas Diampu</div>
                                <div class="text-3xl font-bold">{{ $jumlahKelasDiampu }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white border-opacity-50">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="p-1 bg-green-400 rounded-full bg-opacity-70">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                    <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06l-6.22-6.22V21a.75.75 0 0 1-1.5 0V4.81l-6.22 6.22a.75.75 0 1 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-xs ">
                                <span class="font-semibold text-green-400">{{ $kelasAktifHariIni }}</span> kelas aktif hari ini
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-violet-400 to-purple-300 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                    <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                    <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                                </svg>
                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Total Siswa</div>
                                <div class="text-3xl font-bold">{{ $totalSiswaDiampu }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white border-opacity-50">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="p-1 bg-blue-400 rounded-full bg-opacity-70">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                    <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-xs ">
                                <span class="font-semibold text-blue-400">{{ $rataRataKehadiran }}%</span> rata-rata kehadiran
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Jadwal Hari Ini</div>
                                <div class="text-3xl font-bold">{{ $jumlahJadwalHariIni }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white border-opacity-50">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="p-1 bg-purple-400 rounded-full bg-opacity-70">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-xs ">
                                <span class="font-semibold text-red-400">{{ $jadwalSelanjutnya }}</span> jadwal selanjutnya
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-pink-500 to-rose-400 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <!-- Fixed attendance/user check icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Presensi Diambil</div>
                                <div class="text-3xl font-bold">{{ $jumlahPresensiHariIni }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white border-opacity-50">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="p-1 bg-red-400 rounded-full bg-opacity-70">
                                <!-- Fixed warning/alert icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-xs">
                                <span class="font-semibold text-red-100">{{ $siswaAlpha }}</span> siswa alpha hari ini
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 gap-1 lg:grid-cols-2">
        {{-- Jadwal Mengajar Hari ini --}}
        <div class="bg-white rounded-sm shadow-sm">
            <div class="p-6">
                <h2 class="mb-4 text-xl font-bold text-blue-800 font-heading">Jadwal Mengajar Hari Ini</h2>

                <div class="space-y-3">
                    @forelse ($jadwalHariIniDetail as $jadwal)
                        <div class="p-4 transition-shadow border border-gray-200 rounded-lg bg-gradient-to-r from-blue-50 to-indigo-50 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $jadwal->mapel->nama_mapel }}</h3>
                                        <p class="text-sm text-gray-600">{{ $jadwal->kelas->nama_kelas }} • {{ $jadwal->jam_mulai }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($jadwal->status)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                            ✓ Sudah Presensi
                                        </span>
                                    @else
                                        <a href="{{ route('presensi.create', $jadwal->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-semibold text-blue-700 transition-colors bg-blue-100 rounded-full hover:bg-blue-200">
                                            Ambil Presensi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 mx-auto mb-3 text-gray-400">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                            </svg>
                            <p>Tidak ada jadwal mengajar hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Statistik Presensi Kelas -->
        <div class="bg-white rounded-sm shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-blue-800 font-heading">Statistik Presensi Kelas</h2>
                        <p class="text-sm text-gray-600">Tingkat kehadiran per kelas yang diampu</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($statistikKelas as $kelas)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $kelas->nama_kelas }}</h3>
                                <span class="text-sm font-medium text-gray-600">{{ $kelas->persentase_kehadiran }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div class="h-2 rounded-full {{ $kelas->persentase_kehadiran >= 80 ? 'bg-green-500' : ($kelas->persentase_kehadiran >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                     style="width: {{ $kelas->persentase_kehadiran }}%"></div>
                            </div>
                            <div class="flex justify-between mt-2 text-xs text-gray-500">
                                <span>{{ $kelas->jumlah_hadir }} hadir</span>
                                <span>{{ $kelas->total_siswa }} total siswa</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p>Belum ada data statistik kelas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Presensi Terbaru -->
    <div class="mt-1 bg-white rounded-sm shadow-sm">
        <div class="p-6">
            <h2 class="mb-4 text-xl font-bold text-blue-800 font-heading">Rekapan Presensi Terbaru</h2>

            <div class="overflow-auto rounded-sm shadow-sm">
                <table class="min-w-full text-sm text-left whitespace-nowrap">
                    <thead>
                        <tr class="text-sm font-semibold text-gray-700 bg-gray-100 font-heading">
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase">NIS</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-700 uppercase">Nama Siswa</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-center text-gray-700 uppercase">Hadir</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-center text-gray-700 uppercase">Izin</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-center text-gray-700 uppercase">Sakit</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wider text-center text-gray-700 uppercase">Alpha</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPresensi as $riwayat)
                            <tr class="text-sm text-gray-700 border-t hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($riwayat->jam)->translatedFormat('H:i') }}
                                </td>
                                <td class="px-4 py-3">{{ $riwayat->kelas }}</td>
                                <td class="px-4 py-3">{{ $riwayat->nis }}</td>
                                <td class="px-4 py-3">{{ $riwayat->nama }}</td>
                                <td class="px-4 py-3 text-center">
                                    {{ $riwayat->Hadir }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $riwayat->Izin }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $riwayat->Sakit }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $riwayat->Alpha }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada riwayat presensi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
@endsection
