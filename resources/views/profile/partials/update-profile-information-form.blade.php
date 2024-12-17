<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Harap isi informasi akun Anda berikut sesuai dengan data Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <p class="text-xs text-error">*harap nama sesuai KTP</p>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="no_kk" :value="__('No. KK')" />
            <p class="text-xs text-error">*harap diisi sesuai dengan No. KK Anda</p>
            <x-text-input id="no_kk" name="no_kk" type="text" class="mt-1 block w-full" :value="old('no_kk', $user->no_kk)" required autofocus autocomplete="no_kk" />
            <x-input-error class="mt-2" :messages="$errors->get('no_kk')" />
        </div>

        <div>
            <x-input-label for="no_wa" :value="__('No. WhatsApp')" />
            <p class="text-xs text-error">*harap diisi sesuai dengan Nomor WhatsApp Anda</p>
            <x-text-input id="no_wa" name="no_wa" type="text" class="mt-1 block w-full" :value="old('no_wa', $user->no_wa)" required autofocus autocomplete="no_wa" />
            <x-input-error class="mt-2" :messages="$errors->get('no_wa')" />
        </div>

        <!-- <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div> -->

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
