<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="font-display-xl text-3xl font-bold text-on-surface mb-2">Buat Akun Baru</h2>
        <p class="font-body-md text-sm text-on-surface-variant">Bergabung dan mulai nikmati pengalaman berbelanja gadget masa depan.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-label-md text-sm text-on-surface mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">person</span>
                </div>
                <input id="name" class="block w-full pl-10 pr-3 py-2.5 bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-error text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-label-md text-sm text-on-surface mb-1.5">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">mail</span>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-2.5 bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-error text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-label-md text-sm text-on-surface mb-1.5">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">lock</span>
                </div>
                <input id="password" class="block w-full pl-10 pr-3 py-2.5 bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all text-sm" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-error text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-label-md text-sm text-on-surface mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant text-sm">lock_reset</span>
                </div>
                <input id="password_confirmation" class="block w-full pl-10 pr-3 py-2.5 bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all text-sm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-error text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-primary-container to-secondary-fixed-dim hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] text-on-primary-fixed py-3.5 rounded-xl font-label-md text-sm font-bold uppercase tracking-widest transition-all hover:-translate-y-0.5">
                {{ __('Register Account') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="font-body-md text-sm text-on-surface-variant">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Masuk di sini</a></p>
        </div>
    </form>
</x-guest-layout>
