<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="/auth/post-register" class="w-full max-w-sm px-6 pt-8 pb-6">
        @csrf

        {{-- No. KK --}}
        <div>
            <x-input-label for="no_kk" class="text-black">
                No. KK
            </x-input-label>
            <x-text-input id="no_kk" class="block mt-1 w-full" type="text" name="no_kk" :value="old('no_kk')" required
                autofocus />
            <x-input-error :messages="$errors->get('no_kk')" class="mt-2" />
        </div>

        {{-- No. Wa --}}
        <div class="mt-4">
            <x-input-label for="no_wa" class="text-black">
                No. WhatsApp
            </x-input-label>
            <x-text-input id="no_wa" class="block mt-1 w-full" type="text" name="no_wa" :value="old('no_wa')"
                required />
            <x-input-error :messages="$errors->get('no_wa')" class="mt-2" />
        </div>

        <x-primary-button class="w-full mt-8 rounded-md justify-center bg-blue-700">
            Submit
        </x-primary-button>
    </form>
</x-guest-layout>