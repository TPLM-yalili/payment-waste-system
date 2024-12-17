<x-admin-layout>
    <div class="flex">
        <!-- Sidebar Component -->
        @include('components.admin-sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-4">

            @include('layouts.navigation')

            bills page
        </div>
    </div>
</x-admin-layout>
