@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <div class="mb-1 bg-white rounded-sm shadow-sm ">
        <div class="p-4">
            <h1 class="text-2xl font-bold text-purple-800 font-heading">Dashboard Admin</h1>
            <p class="mb-4 font-sans text-gray-600">Selamat datang di dashboard admin PresenSee!</p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-orange-400 to-amber-400 hover:shadow-xl hover:scale-105">
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
                                <div class="text-3xl font-bold">{{ $jumlahSiswa }}</div>
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
                                <span class="font-semibold text-green-400">+{{ $siswaBaruHariIni }}</span> siswa baru hari ini
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-violet-400 to-purple-300 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                </svg>

                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Total Guru</div>
                                <div class="text-3xl font-bold">{{ $jumlahGuru }}</div>
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
                                <span class="font-semibold text-green-400">+{{ $guruBaruMingguIni }}</span> guru baru minggu ini
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z" clip-rule="evenodd" />
                                </svg>

                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Total Kelas</div>
                                <div class="text-3xl font-bold">{{ $jumlahKelas }}</div>
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
                <div class="p-6 text-white transition-all duration-300 shadow-md rounded-xl bg-gradient-to-br from-pink-500 to-rose-400 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white rounded-lg bg-opacity-20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                                </svg>

                            </div>
                            <div class="font-heading">
                                <div class="text-sm font-medium text-white opacity-90">Presensi Hari ini</div>
                                <div class="text-3xl font-bold">{{ $jumlahPresensiHariIni }}</div>
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
                                <span class="font-semibold text-green-400">{{ $presentaseKehadiranHariIni }}%</span> Kehadiran hari ini
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-1 bg-white rounded-sm shadow-sm">
        <div class="p-6 ">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-purple-800 font-heading">Statistik Presensi</h2>
                    <p class="font-sans text-sm font-medium text-gray-600">
                        Grafik statistik presensi siswa dan guru.
                    </p>
                    <p class="mt-1 font-sans text-xs text-gray-500">
                        Presensi minggu ini:
                        <span class="font-semibold">
                            {{ $awalMinggu}} - {{ $akhirMinggu}}
                        </span>
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <form method="GET" id="filterForm">
                        <select name="kelas_id" class="w-full px-3 py-2 pr-8 text-sm text-gray-900 transition-colors bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:text-gray-900 dark:border-gray-300" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <div class="relative w-full h-64 bg-white rounded-lg shadow">
                    <canvas id="grafikPresensi"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-1 bg-white rounded-sm shadow-sm">
        <div class="p-6">
            <h2 class="text-xl font-bold text-purple-800 font-heading">Log Presensi Terbaru</h2>

            <div class="mt-4 overflow-auto rounded-sm shadow-sm">
                <table class="min-w-full text-sm text-left whitespace-nowrap">
                    <thead class="text-gray-900 bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 font-semibold font-heading">No</th>
                            <th class="px-4 py-3 font-semibold font-heading">Nama Siswa</th>
                            <th class="px-4 py-3 font-semibold font-heading">Kelas</th>
                            <th class="px-4 py-3 font-semibold font-heading">Waktu Presensi</th>
                            <th class="px-4 py-3 font-semibold font-heading">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logPresensi as $index => $log)
                            <tr class="text-sm text-gray-700 border-t hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    {{ $log->siswa_kelas->siswa->nama_siswa ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $log->siswa_kelas->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($log->waktu_presensi)->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $status = strtolower($log->status);
                                        $badge = match ($status) {
                                            'hadir' => ['text-green-700', 'bg-green-100', 'Hadir'],
                                            'izin' => ['text-yellow-700', 'bg-yellow-100', 'Izin'],
                                            'sakit' => ['text-blue-700', 'bg-blue-100', 'Sakit'],
                                            'alpha', 'alpa' => ['text-red-700', 'bg-red-100', 'Alpha'],
                                            default => ['text-gray-700', 'bg-gray-100', ucfirst($log->status)],
                                        };
                                    @endphp

                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold {{ $badge[0] }} {{ $badge[1] }} rounded-full">
                                        {{ $badge[2] }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                    Tidak ada data presensi terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script>
    const ctx = document.getElementById('grafikPresensi').getContext('2d');

    const labels = @json($labels);
    const dataHadir = @json($dataHadir);
    const dataTidakHadir = @json($dataTidakHadir);

    // Create gradient backgrounds
    const gradientHadir = ctx.createLinearGradient(0, 0, 0, 400);
    gradientHadir.addColorStop(0, 'rgba(34, 197, 94, 0.8)');   // emerald-500
    gradientHadir.addColorStop(1, 'rgba(34, 197, 94, 0.4)');

    const gradientTidakHadir = ctx.createLinearGradient(0, 0, 0, 400);
    gradientTidakHadir.addColorStop(0, 'rgba(239, 68, 68, 0.8)');  // red-500
    gradientTidakHadir.addColorStop(1, 'rgba(239, 68, 68, 0.4)');

    const grafikPresensi = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Hadir',
                    data: dataHadir,
                    backgroundColor: gradientHadir,
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    borderRadius: {
                        topLeft: 8,
                        topRight: 8,
                        bottomLeft: 4,
                        bottomRight: 4
                    },
                    borderSkipped: false,
                    maxBarThickness: 45,
                    hoverBackgroundColor: 'rgba(34, 197, 94, 0.9)',
                    hoverBorderColor: 'rgba(34, 197, 94, 1)',
                    hoverBorderWidth: 3,
                    shadowOffsetX: 0,
                    shadowOffsetY: 4,
                    shadowBlur: 12,
                    shadowColor: 'rgba(34, 197, 94, 0.3)'
                },
                {
                    label: 'Tidak Hadir',
                    data: dataTidakHadir,
                    backgroundColor: gradientTidakHadir,
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2,
                    borderRadius: {
                        topLeft: 8,
                        topRight: 8,
                        bottomLeft: 4,
                        bottomRight: 4
                    },
                    borderSkipped: false,
                    maxBarThickness: 45,
                    hoverBackgroundColor: 'rgba(239, 68, 68, 0.9)',
                    hoverBorderColor: 'rgba(239, 68, 68, 1)',
                    hoverBorderWidth: 3,
                    shadowOffsetX: 0,
                    shadowOffsetY: 4,
                    shadowBlur: 12,
                    shadowColor: 'rgba(239, 68, 68, 0.3)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 20,
                    right: 20,
                    bottom: 10,
                    left: 10
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutCubic',
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default') {
                        delay = context.dataIndex * 100;
                    }
                    return delay;
                }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                animationDuration: 200,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)',
                        borderColor: 'rgba(148, 163, 184, 0.2)',
                        borderWidth: 1,
                        drawTicks: false,
                        lineWidth: 1
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: '#64748B',
                        font: {
                            family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                            size: 12,
                            weight: '500',
                        },
                        padding: 12,
                        maxTicksLimit: 8
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Siswa',
                        color: '#475569',
                        font: {
                            family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                            size: 13,
                            weight: '600',
                        },
                        padding: { bottom: 10 }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        color: 'rgba(148, 163, 184, 0.2)',
                        width: 1
                    },
                    ticks: {
                        color: '#334155',
                        font: {
                            family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                            size: 13,
                            weight: '600',
                        },
                        padding: 8,
                        maxRotation: 0
                    },
                    title: {
                        display: true,
                        text: 'Hari',
                        color: '#475569',
                        font: {
                            family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                            size: 13,
                            weight: '600',
                        },
                        padding: { top: 10 }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'center',
                    labels: {
                        font: {
                            family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                            size: 13,
                            weight: '600',
                        },
                        color: '#1E293B',
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'roundRect',
                        boxWidth: 12,
                        boxHeight: 12
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#F8FAFC',
                    bodyColor: '#E2E8F0',
                    borderColor: 'rgba(148, 163, 184, 0.2)',
                    borderWidth: 1,
                    titleFont: {
                        family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                        size: 14,
                        weight: '700',
                    },
                    bodyFont: {
                        family: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
                        size: 13,
                        weight: '500',
                    },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxHeight: 10,
                    boxWidth: 10,
                    boxPadding: 3,
                    caretPadding: 6,
                    caretSize: 6,
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(context) {
                            return `📅 ${context[0].label}`;
                        },
                        label: function(context) {
                            const icon = context.dataset.label === 'Hadir' ? '✅' : '❌';
                            return `${icon} ${context.dataset.label}: ${context.parsed.y} siswa`;
                        }
                    }
                }
            },
            elements: {
                bar: {
                    borderSkipped: false,
                    inflateAmount: 'auto'
                }
            }
        },
        plugins: [{
            id: 'customCanvasBackgroundColor',
            beforeDraw: (chart, args, options) => {
                const {ctx} = chart;
                ctx.save();
                ctx.globalCompositeOperation = 'destination-over';
                ctx.fillStyle = '#FEFEFE';
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        }, {
            id: 'barShadow',
            beforeDatasetsDraw: (chart, args, options) => {
                const {ctx} = chart;
                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);
                    meta.data.forEach((bar, index) => {
                        const {x, y, base, width} = bar;

                        ctx.save();
                        ctx.shadowColor = dataset.shadowColor || 'rgba(0, 0, 0, 0.1)';
                        ctx.shadowBlur = dataset.shadowBlur || 8;
                        ctx.shadowOffsetX = dataset.shadowOffsetX || 0;
                        ctx.shadowOffsetY = dataset.shadowOffsetY || 2;

                        ctx.fillStyle = dataset.backgroundColor;
                        ctx.fillRect(x - width/2, y, width, base - y);
                        ctx.restore();
                    });
                });
            }
        }]
    });

    // Add smooth resize handling
    window.addEventListener('resize', function() {
        grafikPresensi.resize();
    });

</script>
@endsection
