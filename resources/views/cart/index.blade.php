@extends('layouts.app')

@section('title', 'Keranjang Belanja | Wonder Shope')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="font-display-xl text-headline-lg text-on-surface">Keranjang Belanja</h1>
            <p class="font-body-md text-on-surface-variant mt-1">Daftar item gadget yang siap kamu bawa pulang</p>
        </div>
        <a href="{{ route('home') }}" class="glass-card hover:bg-white/10 text-on-surface px-4 py-2 rounded-xl font-label-md text-label-md transition flex items-center gap-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Lanjut Belanja
        </a>
    </div>

    @if(count($cart) > 0)
        <div class="glass-card rounded-2xl border border-white/10 mb-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="font-label-md text-label-md text-on-surface-variant uppercase bg-surface-container-low/50 border-b border-white/5">
                        <tr>
                            <th class="px-6 py-4 font-bold tracking-wider">Nama Produk</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Varian</th>
                            <th class="px-6 py-4 font-bold tracking-wider text-center">Jumlah</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Harga</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Subtotal</th>
                            <th class="px-6 py-4 font-bold tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($cart as $id => $details)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 font-bold text-on-surface">{{ $details['name'] }}</td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium">
                                <span class="bg-primary/10 text-primary text-xs px-2.5 py-1 rounded-md border border-primary/20 font-bold">
                                    {{ $details['variant_name'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-on-surface">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 bg-surface-container border border-white/10 rounded-lg px-2 py-1 text-center text-on-surface focus:ring-1 focus:ring-primary focus:border-primary outline-none" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-headline-md text-primary">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Keluarkan item ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:text-red-400 font-bold text-xs bg-error/10 hover:bg-error/20 border border-error/20 px-3 py-1.5 rounded-lg transition inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">delete</span> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center glass-card p-6 rounded-2xl border border-white/10 bg-surface-container-low/50">
            <div class="mb-4 sm:mb-0">
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Total Pembayaran</p>
                <h3 class="font-headline-lg text-headline-lg text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
            <a href="{{ url('/checkout') }}" class="w-full sm:w-auto bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] text-on-primary-fixed text-center px-8 py-3 rounded-xl font-label-md text-label-md font-bold uppercase tracking-widest transition inline-flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">lock</span> Lanjut ke Pembayaran
            </a>
        </div>
    @else
        <div class="text-center py-20 border border-dashed border-white/20 rounded-2xl glass-card">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10">
                <span class="material-symbols-outlined text-3xl text-on-surface-variant">shopping_bag</span>
            </div>
            <p class="text-on-surface font-headline-md text-headline-md mb-2">Keranjang Kamu Kosong</p>
            <p class="text-on-surface-variant font-body-md text-body-md mb-8">Yuk mulai pilih produk gadget favoritmu!</p>
            <a href="{{ route('home') }}" class="bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] text-on-primary-fixed px-8 py-3 rounded-xl font-label-md text-label-md font-bold uppercase tracking-widest transition inline-flex items-center gap-2">
                <span class="material-symbols-outlined">shopping_cart</span> Mulai Belanja Gadget
            </a>
        </div>
    @endif
    
</div>
@endsection