<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="font-display-xl text-3xl font-bold text-on-surface mb-2">Welcome Back</h2>
        <p class="font-body-md text-sm text-on-surface-variant">Masuk untuk melanjutkan pengalaman berbelanja gadget premium Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-label-md text-sm text-on-surface mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">mail</span>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-3 bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-error text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block font-label-md text-sm text-on-surface">Password</label>
                @if (Route::has('password.request'))
                    <a class="font-label-md text-xs text-primary hover:text-primary-container transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">lock</span>
                </div>
                <input id="password" class="block w-full pl-10 pr-3 py-3 bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-error text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-surface-container border-white/10 text-primary focus:ring-primary/50 focus:ring-offset-0" name="remember">
                <span class="ml-2 text-sm text-on-surface-variant font-body-md">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full bg-gradient-to-r from-primary-container to-secondary-fixed-dim hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] text-on-primary-fixed py-3.5 rounded-xl font-label-md text-sm font-bold uppercase tracking-widest transition-all hover:-translate-y-0.5">
                {{ __('Log in') }}
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="font-body-md text-sm text-on-surface-variant">Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-bold hover:underline ml-1">Daftar sekarang</a></p>
        </div>
    </form>
</x-guest-layout>
