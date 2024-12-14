<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form class="card-body">
        <div class="form-control"> 
            <h1 class="text-2xl text-center font-medium mb-4">Login</h1>
            <p class="text-center mb-5 text-sm">
                Masuk dengan Google.
            </p>
            <a href="/auth/google" class="btn btn-outline">
                <x-google-logo class="mr-2" /> <span>Login dengan Google</span>
            </a>
        <!-- <div class="form-control mt-6">
          <button class="btn btn-neutral">Login</button>
        </div> -->
      </form>
</x-guest-layout>