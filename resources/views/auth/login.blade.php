<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <a href="/auth/google" class="inline-flex mt-5 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-base text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <x-google-logo class="mr-2" /> <span>Login dengan Google</span>
    </a>
</x-guest-layout>