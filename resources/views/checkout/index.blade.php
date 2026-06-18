@extends('layouts.app')

@section('title', 'Checkout | Wonder Shope')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="font-display-xl text-headline-lg text-on-surface">Checkout</h1>
            <p class="font-body-md text-on-surface-variant mt-1">Lengkapi data pengiriman untuk memproses pesanan</p>
        </div>
        <a href="{{ route('cart.index') }}" class="glass-card hover:bg-white/10 text-on-surface px-4 py-2 rounded-xl font-label-md text-label-md transition flex items-center gap-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Keranjang
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-error/10 border border-error/20 text-error rounded-xl font-body-md text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        
        <!-- Left: Form -->
        <div class="lg:col-span-8">
            <div class="glass-card rounded-2xl p-8 border border-white/10">
                <h2 class="font-headline-md text-headline-md text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">local_shipping</span> Informasi Pengiriman
                </h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2">Nama Penerima <span class="text-error">*</span></label>
                        <input type="text" name="nama_penerima" value="{{ old('nama_penerima', $user->name ?? '') }}" class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition" required>
                    </div>

                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2">Nomor Telepon/WhatsApp <span class="text-error">*</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon', $user->phone ?? '') }}" class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition" placeholder="Contoh: 081234567890" required>
                    </div>

                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2">Alamat Lengkap <span class="text-error">*</span></label>
                        <textarea name="alamat_lengkap" rows="4" class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition" placeholder="Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Kota/Kabupaten, Kode Pos" required>{{ old('alamat_lengkap', $user->address ?? '') }}</textarea>
                    </div>
                </div>

                <h2 class="font-headline-md text-headline-md text-primary mt-10 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">payments</span> Metode Pembayaran
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Transfer Bank -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="metode_bayar" value="Transfer Bank" class="peer sr-only" required>
                        <div class="h-full p-4 rounded-xl border border-white/10 bg-white/5 text-center hover:border-primary/50 transition-all peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:shadow-[0_0_15px_rgba(172,199,255,0.2)]">
                            <span class="material-symbols-outlined text-3xl mb-2 text-on-surface peer-checked:text-primary">account_balance</span>
                            <div class="font-label-md text-label-md text-on-surface font-bold">Transfer Bank</div>
                            <div class="text-xs text-on-surface-variant mt-1">BCA, Mandiri, BNI</div>
                        </div>
                    </label>

                    <!-- COD -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="metode_bayar" value="COD" class="peer sr-only" required>
                        <div class="h-full p-4 rounded-xl border border-white/10 bg-white/5 text-center hover:border-primary/50 transition-all peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:shadow-[0_0_15px_rgba(172,199,255,0.2)]">
                            <span class="material-symbols-outlined text-3xl mb-2 text-on-surface peer-checked:text-primary">handshake</span>
                            <div class="font-label-md text-label-md text-on-surface font-bold">Cash on Delivery</div>
                            <div class="text-xs text-on-surface-variant mt-1">Bayar di Tempat</div>
                        </div>
                    </label>

                    <!-- QRIS -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="metode_bayar" value="QRIS" class="peer sr-only" required>
                        <div class="h-full p-4 rounded-xl border border-white/10 bg-white/5 text-center hover:border-primary/50 transition-all peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:shadow-[0_0_15px_rgba(172,199,255,0.2)]">
                            <span class="material-symbols-outlined text-3xl mb-2 text-on-surface peer-checked:text-primary">qr_code_scanner</span>
                            <div class="font-label-md text-label-md text-on-surface font-bold">QRIS</div>
                            <div class="text-xs text-on-surface-variant mt-1">Scan & Bayar</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right: Summary -->
        <div class="lg:col-span-4">
            <div class="glass-card rounded-2xl p-6 border border-primary/20 sticky top-28 shadow-[0_0_30px_rgba(172,199,255,0.05)]">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-6 border-b border-white/10 pb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                    @foreach($cart as $id => $details)
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <p class="font-label-md text-sm text-on-surface font-bold line-clamp-1">{{ $details['name'] }}</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">{{ $details['variant_name'] }} <span class="mx-1">•</span> {{ $details['quantity'] }} pcs</p>
                        </div>
                        <p class="font-label-md text-sm text-primary font-bold whitespace-nowrap">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-white/10 pt-4 mb-6 space-y-3">
                    <div class="flex justify-between text-on-surface-variant text-sm font-label-md">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-on-surface-variant text-sm font-label-md">
                        <span>Biaya Pengiriman</span>
                        <span class="text-green-400">Gratis</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-white/10">
                        <span class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Total</span>
                        <span class="font-headline-lg text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] hover:-translate-y-0.5 h-14 rounded-xl flex items-center justify-center gap-2 text-on-primary-fixed font-label-md text-label-md uppercase tracking-widest font-bold transition-all">
                    <span class="material-symbols-outlined">check_circle</span>
                    Buat Pesanan Sekarang
                </button>
            </div>
        </div>

    </form>
</div>
@endsection