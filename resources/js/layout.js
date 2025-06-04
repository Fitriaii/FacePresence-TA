function data() {
    return {
        // Sidebar
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
        },
        closeSideMenu() {
            this.isSideMenuOpen = false;
        },

        // Notifications
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false;
        },

        // Profile
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false;
        },

        // Pages (optional menu toggles)
        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen;
        },

        isPagesUserOpen: false,
        toggleUserMenu() {
            this.isPagesUserOpen = !this.isPagesUserOpen;
        },

        // Active Menu (local only, optional if not using store)
        activeMenu: '',
        setActiveMenu(menu) {
            this.activeMenu = menu;
        },

        isMainMenuActive: false,
        setMainMenuActive() {
            this.isMainMenuActive = true; // Mengaktifkan menu utama
        },
        setMainMenuInactive() {
            this.isMainMenuActive = false; // Menonaktifkan menu utama
        },

        // Modal
        isModalOpen: false,
        trapCleanup: null,
        openModal() {
            this.isModalOpen = true;
            this.trapCleanup = focusTrap(document.querySelector('#modal'));
        },
        closeModal() {
            this.isModalOpen = false;
            this.trapCleanup();
        },
    };
}

// ✅ Registrasi data Alpine
window.data = data;
