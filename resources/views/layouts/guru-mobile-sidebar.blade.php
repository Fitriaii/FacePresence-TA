<aside
    class="fixed inset-y-0 z-30 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white md:hidden"
    x-show="isSideMenuOpen"
    x-cloak
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="transform -translate-x-full"
    x-transition:enter-end="transform translate-x-0"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="transform translate-x-0"
    x-transition:leave-end="transform -translate-x-full"
    >
    <!-- Logo Section -->
    <div class="flex justify-center px-6 mt-4 mb-8">
        <a class="text-2xl font-bold tracking-tight text-purple-600 transition-colors duration-200 hover:text-purple-700" href="#">
            PresenSee
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="space-y-1" x-data x-init="
        const path = window.location.pathname;
        if (path.includes('dashboard')) activeMenu = 'dashboard';
        else if (path.includes('presensi')) activeMenu = 'presensi';
        else if (path.includes('daftarSiswa')) activeMenu = 'daftarSiswa';
        else if (path.includes('jadwalAjar')) activeMenu = 'jadwalAjar';
        else if (path.includes('siswa')) activeMenu = 'siswa';
        else if (path.includes('laporanGuru')) activeMenu = 'laporanGuru';
    ">

        <!-- Dashboard -->
        <div class="px-3">
            <a href="{{ route('dashboard') }}" @click="activeMenu = 'dashboard'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'dashboard'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'dashboard' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                </svg>
                Dashboard
            </a>
        </div>

        <!-- Presensi -->
        <div class="px-3">
            <a href="{{ route('presensi.index') }}" @click="activeMenu = 'presensi'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'presensi'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'presensi' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <polyline points="9,14 11,16 15,12"></polyline>
                </svg>
                Presensi
            </a>
        </div>

        <!-- Daftar Siswa -->
        <div class="px-3">
            <a href="{{ route('daftarSiswa.index') }}" @click="activeMenu = 'daftarSiswa'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'daftarSiswa'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'daftarSiswa' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"></path>
                </svg>
                Daftar Siswa
            </a>
        </div>

        <!-- Jadwal Mengajar -->
        <div class="px-3">
            <a href="{{ route('jadwalAjar.index') }}" @click="activeMenu = 'jadwalAjar'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'jadwalAjar'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'jadwalAjar' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 2v4"></path>
                    <path d="M16 2v4"></path>
                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                    <path d="M3 10h18"></path>
                    <circle cx="8" cy="14" r="0.5" fill="currentColor"></circle>
                    <circle cx="12" cy="14" r="0.5" fill="currentColor"></circle>
                    <circle cx="16" cy="14" r="0.5" fill="currentColor"></circle>
                    <circle cx="8" cy="18" r="0.5" fill="currentColor"></circle>
                    <circle cx="12" cy="18" r="0.5" fill="currentColor"></circle>
                    <circle cx="16" cy="18" r="0.5" fill="currentColor"></circle>
                </svg>
                Jadwal Mengajar
            </a>
        </div>


        <div class="px-3">
            <a href="{{ route('laporanGuru.index') }}" @click="activeMenu = 'laporanGuru'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'laporanGuru'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'laporanGuru' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Laporan Presensi
            </a>
        </div>

    </nav>
</aside>
