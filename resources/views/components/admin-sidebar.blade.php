@props(['active'])

<div class="bg-blue-700 shadow-lg w-full text-white h-screen md:w-64" data-active="{{ $active }}">
    <!-- Logo Section -->
    <div class="flex items-center justify-center py-6">
        <span class="text-xl font-bold text-white sidebar-toggle">Kapays</span>
    </div>

    <!-- User Section -->
    <div class="px-4 py-3 bg-blue-500 mx-4 rounded flex justify-between items-center">
        <span class="font-semibold">Admin</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-6 px-4 text-white">
        <ul class="space-y-3">
            <li data-id="dashboard" class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li data-id="user-list" class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('admin.users-list') }}">List Pengguna</a>
            </li>
            <li data-id="bills" class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('admin.bills') }}">Tagihan</a>
            </li>
            <li data-id="info" class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('admin.info') }}">Pengaturan</a>
            </li>
            <li class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" class="logout-link mt-4" onclick="event.preventDefault(); 
                    $('#logout-form').submit();">
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Ambil elemen sidebar
        const sidebar = document.querySelector('.bg-blue-700');
        if (!sidebar) return;

        // Ambil nilai "active" dari atribut data-active
        const activeMenu = sidebar.getAttribute('data-active');
        if (!activeMenu) return;

        // Temukan elemen menu dengan data-id yang cocok
        const activeElement = sidebar.querySelector(`[data-id="${activeMenu}"]`);
        if (activeElement) {
            // Tambahkan class ke elemen aktif
            activeElement.classList.add('border', 'hover:border-gray-50/0', 'border-gray-50/50');
        }
    });
</script>
