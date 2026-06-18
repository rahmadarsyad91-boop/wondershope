@extends('layouts.app')

@section('title', 'Detail Produk | ' . $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 pt-8 pb-24">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 mb-8 text-on-surface-variant flex-wrap">
        <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
            <span class="material-symbols-outlined text-base">home</span>
            <span class="font-label-md text-label-md">Home</span>
        </a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a class="hover:text-primary transition-colors font-label-md text-label-md uppercase" href="#">{{ $product->brand }}</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-on-surface font-label-md text-label-md line-clamp-1">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left: Product Image -->
        <div class="lg:col-span-7 flex flex-col gap-6">
            <div class="relative group aspect-square rounded-xl overflow-hidden glass-card flex items-center justify-center p-8 bg-black/20">
                @if($product->image)
                    <img class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-105 drop-shadow-[0_20px_30px_rgba(0,0,0,0.5)]" id="main-image" src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"/>
                @else
                    <img class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-105 drop-shadow-[0_20px_30px_rgba(0,0,0,0.5)]" id="main-image" src="https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?q=80&w=1000" alt="{{ $product->name }}"/>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="bg-primary/10 text-primary border border-primary/20 px-3 py-1 rounded-full font-label-md text-label-md backdrop-blur-md uppercase tracking-wider">{{ $product->brand }}</span>
                </div>
            </div>
        </div>

        <!-- Right: Product Info -->
        <div class="lg:col-span-5">
            <div class="glass-card rounded-xl p-8 sticky top-28 shadow-[0_0_40px_rgba(172,199,255,0.05)] border-primary/20">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-secondary-fixed-dim font-label-md text-label-md tracking-widest uppercase">Wonder Shope</span>
                    <div class="flex items-center gap-1 text-secondary-fixed-dim">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="font-label-md text-label-md">5.0</span>
                    </div>
                </div>
                
                <h1 class="font-headline-lg text-headline-md md:text-headline-lg mb-4 text-on-surface">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-6">
                    <span class="font-headline-md text-headline-md text-primary">Rp {{ number_format($product->base_price, 0, ',', '.') }}</span>
                </div>
                
                <p class="text-on-surface-variant mb-8 font-body-md leading-relaxed">
                    {{ $product->description }}
                </p>

                {{-- 
                    PENTING: route('cart.add') tidak menerima URL param.
                    product_id dikirim via hidden input di body form.
                --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    @if($product->variants->count() > 0)
                    <!-- Variants Selection -->
                    <div class="mb-8">
                        <label class="block font-label-md text-label-md text-on-surface mb-4">Pilih Varian</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->variants as $variant)
                            <label class="cursor-pointer relative">
                                <input type="radio" name="variant_id" value="{{ $variant->id }}" class="peer sr-only" required {{ $loop->first ? 'checked' : '' }}>
                                <div class="px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-on-surface-variant font-label-md text-label-md hover:border-primary/50 transition-all peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:shadow-[0_0_15px_rgba(172,199,255,0.2)]">
                                    {{-- Kolom yang benar dari DB: nama_varian & stok --}}
                                    <div class="font-bold mb-1">{{ $variant->nama_varian }}</div>
                                    <div class="text-[10px] mt-1 {{ $variant->stok > 0 ? 'text-green-400' : 'text-red-400' }}">
                                        Stok: {{ $variant->stok }}
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @else
                        <!-- No variants: still need a hidden variant_id - set a dummy or handle in controller -->
                        <div class="flex items-center gap-2 mb-8">
                            <div class="w-2 h-2 rounded-full bg-secondary-fixed shadow-[0_0_8px_rgba(0,220,229,0.8)]"></div>
                            <span class="font-label-md text-label-md text-secondary-fixed-dim">Tersedia</span>
                        </div>
                    @endif

                    <!-- Action Area -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex items-center bg-surface-container-highest rounded-xl border border-white/10 px-2 h-14">
                            <button type="button" class="w-12 h-12 flex items-center justify-center text-on-surface hover:text-primary transition-colors" onclick="const i=document.getElementById('qty'); if(i.value>1) i.value=parseInt(i.value)-1;">
                                <span class="material-symbols-outlined">remove</span>
                            </button>
                            <input id="qty" name="quantity" class="w-12 bg-transparent border-none text-center focus:ring-0 font-bold text-on-surface" type="number" value="1" min="1"/>
                            <button type="button" class="w-12 h-12 flex items-center justify-center text-on-surface hover:text-primary transition-colors" onclick="const i=document.getElementById('qty'); i.value=parseInt(i.value)+1;">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </div>
                        <button type="submit" class="flex-1 bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] hover:-translate-y-0.5 h-14 rounded-xl flex items-center justify-center gap-2 text-on-primary-fixed font-label-md text-label-md uppercase tracking-widest font-bold transition-all">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>

                <!-- Extra Perks -->
                <div class="mt-8 grid grid-cols-2 gap-4 pt-8 border-t border-white/10">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">verified_user</span>
                        <div>
                            <p class="text-[12px] font-bold text-on-surface uppercase tracking-tighter">Garansi</p>
                            <p class="text-[12px] text-on-surface-variant">Resmi 1 Tahun</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        <div>
                            <p class="text-[12px] font-bold text-on-surface uppercase tracking-tighter">Pengiriman</p>
                            <p class="text-[12px] text-on-surface-variant">Aman & Cepat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection