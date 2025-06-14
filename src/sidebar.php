<!-- Sidebar component -->
<!-- Modern Sidebar Component -->
<div id="sidebar" class="min-h-screen fixed flex flex-col top-0 left-0 w-72 bg-white dark:bg-gray-900 h-full shadow-xl z-50 transition-all duration-300 ease-in-out md:translate-x-0">
    <!-- Header -->
    <div class="flex items-center h-20 px-8 border-b dark:border-gray-800">
        <div class="flex items-center space-x-3">
            <img src="logo.png" alt="Logo" class="w-8 h-8">
            <!-- <span class="font-semibold text-xl text-gray-800 dark:text-white">WebPOS</span> -->
        </div>
        <button id="sidebar-close" class="md:hidden absolute right-4 text-gray-500 hover:text-gray-800 dark:text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6">
        <div class="px-6 space-y-6">
            <!-- Main Navigation -->
            <div>
                <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Main</h2>
                <div class="space-y-1">
                    <a href="dashboard.php" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-900 dark:text-white hover:bg-indigo-50 dark:hover:bg-indigo-900/30">
                        <svg class="w-5 h-5 mr-3 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Products Section -->
                    <div class="space-y-1 mt-4">
                        <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Products</h2>
                        <a href="add_product.php" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-900 dark:text-white hover:bg-indigo-50 dark:hover:bg-indigo-900/30">
                            <svg class="w-5 h-5 mr-3 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Product
                        </a>
                        <a href="view_product.php" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-900 dark:text-white hover:bg-indigo-50 dark:hover:bg-indigo-900/30">
                            <svg class="w-5 h-5 mr-3 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t dark:border-gray-800">
        <div class="flex items-center justify-between">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                <svg id="theme-toggle-light-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            <!-- Logout Button -->
            <button id="logout-btn" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </button>
        </div>
    </div>
</div>

<!-- Hamburger menu button for mobile -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-40 p-2 rounded-md bg-white dark:bg-gray-800 shadow-md text-gray-600 dark:text-gray-200 hover:text-gray-800 dark:hover:text-white focus:outline-none">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Backdrop for mobile -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden md:hidden"></div>

<!-- Logout Confirmation Modal -->
<div id="logout-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full mx-4 overflow-hidden shadow-xl transform transition-all">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Confirm Logout</h3>
                <button id="modal-close" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to logout? Any unsaved changes will be lost.</p>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button id="cancel-logout" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none">
                    Cancel
                </button>
                <a href="../auth/logout.php" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none">
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Script for sidebar toggle and modal functionality -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Elements
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const backdrop = document.getElementById('sidebar-backdrop');
        const logoutBtn = document.getElementById('logout-btn');
        const logoutModal = document.getElementById('logout-modal');
        const modalClose = document.getElementById('modal-close');
        const cancelLogout = document.getElementById('cancel-logout');

        // Initial state - hide sidebar on mobile
        if (window.innerWidth < 768) {
            sidebar.classList.add('-translate-x-full');
        }

        // Theme detection (optional)
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }

        // Toggle sidebar on mobile
        menuToggle?.addEventListener('click', function() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden', 'md:overflow-auto'); // Prevent scrolling when sidebar is open
        });

        // Close sidebar on mobile
        sidebarClose?.addEventListener('click', closeSidebar);
        backdrop?.addEventListener('click', closeSidebar);

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
        }

        // Logout modal functionality
        logoutBtn?.addEventListener('click', function() {
            logoutModal.classList.remove('hidden');
        });

        // Close modal
        modalClose?.addEventListener('click', closeModal);
        cancelLogout?.addEventListener('click', closeModal);

        function closeModal() {
            logoutModal.classList.add('hidden');
        }

        // Close modal when clicking outside
        logoutModal?.addEventListener('click', function(e) {
            if (e.target === logoutModal) {
                closeModal();
            }
        });

        // Keyboard accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!logoutModal.classList.contains('hidden')) {
                    closeModal();
                } else if (window.innerWidth < 768 && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else if (!backdrop.classList.contains('hidden')) {
                // Keep sidebar open on resize if it was already open
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Theme Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');

        if (themeToggleBtn) {
            // Check for saved theme preference
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggleDarkIcon.classList.add('hidden');
                themeToggleLightIcon.classList.remove('hidden');
            }

            // Toggle button click handler
            themeToggleBtn.addEventListener('click', function() {
                // Toggle icons
                themeToggleLightIcon.classList.toggle('hidden');
                themeToggleDarkIcon.classList.toggle('hidden');

                // Toggle theme
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
        }
    });


</script>