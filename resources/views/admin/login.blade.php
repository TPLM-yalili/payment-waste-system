<x-guest-layout :tag_line="__('Halaman login untuk admin Kapays, silahkan masukkan username dan password akun admin anda.')">
    <div class="m-6">
        <h1 class="font-semibold text-xl mb-4">Login Admin</h1>
        @if ($errors->any())
            <x-error-alert :messages="$errors->all()" />
        @endif
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            {{-- <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div> --}}

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <label class="input input-bordered flex items-center gap-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="h-4 w-4 opacity-70">
                        <path
                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                    </svg>
                <input id="username" class="block mt-1 w-full grow" placeholder="Username" type="text" name="username" :value="old('username')"
                required autofocus autocomplete="username" />
                </label>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                
                <label class="input input-bordered flex items-center gap-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="h-4 w-4 opacity-70">
                        <path
                        fill-rule="evenodd"
                        d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                        clip-rule="evenodd" />
                    </svg>
                    <input id="password" class="block mt-1 w-full grow" type="password" placeholder="⦁ ⦁ ⦁ ⦁ ⦁ ⦁" name="password" required
                    autocomplete="new-password" />
                </label>
                <!-- <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" /> -->

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Login') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
