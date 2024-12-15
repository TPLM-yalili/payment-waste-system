<!-- resources/views/components/admin-sidebar.blade.php -->
<div class="bg-blue-700 shadow-lg w-full text-white h-screens md:w-64">
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
            <li class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">Dashboard</li>
            <li class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('super.admin.info') }}">List Pengguna</a>
            </li>
            <li class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('super.admin.info') }}">Tagihan</a>
            </li>
            <li class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <a href="{{ route('super.admin.info') }}">Pengaturan</a>
            </li>
            <li class="text-white hover:bg-blue-600 px-4 py-3 rounded cursor-pointer">
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <!-- Logout Link with Confirmation -->
                <a href="#" class="logout-link mt-4" onclick="event.preventDefault(); 
                    if (confirm('Are you sure you want to log out?')) {
                        document.getElementById('logout-form').submit();
                    }">
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</div>