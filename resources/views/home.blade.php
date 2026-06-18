@extends('layouts.app')

@section('title', 'Wonder Shope | Premium Electronics')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[716px] flex items-center overflow-hidden px-8 md:px-margin-desktop py-20">
    <div class="absolute inset-0 hero-glow"></div>
    <div class="relative z-10 max-w-4xl">
        <span class="inline-block px-4 py-1.5 mb-6 rounded-full glass-card text-primary font-label-md text-label-md border-primary/20">NEXT-GEN ELECTRONICS</span>
        <h1 class="font-display-xl text-headline-lg md:text-display-xl mb-6 leading-tight">
            Temukan <span class="bg-gradient-to-r from-primary to-secondary-fixed-dim bg-clip-text text-transparent">Gadget Impianmu</span> di Masa Depan
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-2xl">
            Experience the synergy of high-performance technology and futuristic design. Curated premium electronics for the modern visionary.
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="#koleksi" class="px-8 py-4 rounded-xl bg-gradient-to-r from-primary-container to-secondary-container text-on-primary-container font-label-md text-label-md font-bold shadow-[0_0_25px_rgba(80,143,248,0.4)] hover:shadow-[0_0_40px_rgba(80,143,248,0.6)] hover:scale-105 active:scale-95 transition-all">
                Belanja Sekarang
            </a>
            <a href="#koleksi" class="px-8 py-4 rounded-xl glass-card font-label-md text-label-md hover:bg-white/10 transition-all active:scale-95 inline-block text-center">
                Lihat Koleksi
            </a>
        </div>
    </div>
    <!-- Floating Product Silhouette -->
    <div class="hidden lg:block absolute right-0 top-1/2 -translate-y-1/2 w-1/3 h-full opacity-40">
        <div class="w-full h-full bg-contain bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop')"></div>
    </div>
</section>

<!-- Catalog Filter/Search -->
<section id="koleksi" class="px-8 md:px-margin-desktop py-8 border-y border-white/5 bg-surface-container-low/50 backdrop-blur-md">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex gap-4 overflow-x-auto pb-2 w-full md:w-auto scrollbar-hide">
            <a href="{{ route('home') }}" class="px-6 py-2 rounded-full glass-card font-label-md text-label-md whitespace-nowrap {{ !request('brand') ? 'text-primary border-primary/40' : 'text-on-surface-variant hover:text-on-surface' }}">Semua Gadget</a>
            <a href="{{ route('home', ['brand' => 'Sony']) }}" class="px-6 py-2 rounded-full glass-card font-label-md text-label-md whitespace-nowrap {{ request('brand') == 'Sony' ? 'text-primary border-primary/40' : 'text-on-surface-variant hover:text-on-surface' }}">Sony</a>
            <a href="{{ route('home', ['brand' => 'ASUS']) }}" class="px-6 py-2 rounded-full glass-card font-label-md text-label-md whitespace-nowrap {{ request('brand') == 'ASUS' ? 'text-primary border-primary/40' : 'text-on-surface-variant hover:text-on-surface' }}">ASUS</a>
            <a href="{{ route('home', ['brand' => 'GravaStar']) }}" class="px-6 py-2 rounded-full glass-card font-label-md text-label-md whitespace-nowrap {{ request('brand') == 'GravaStar' ? 'text-primary border-primary/40' : 'text-on-surface-variant hover:text-on-surface' }}">GravaStar</a>
        </div>
        <div class="text-on-surface-variant font-label-md text-label-md">
            Menampilkan <span class="text-primary">{{ count($products) }} Gadget</span> Terbaik
        </div>
    </div>
</section>

<!-- Product Grid -->
<section class="px-8 md:px-margin-desktop py-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        @foreach($products as $product)
        <div class="product-card glass-card rounded-2xl p-6 flex flex-col group transition-all duration-500 hover:-translate-y-2 relative">
            <div class="product-image-container relative h-48 mb-6 flex items-center justify-center overflow-hidden rounded-xl bg-black/20 p-4">
                @if($product->image)
                    <img class="h-full w-full object-contain drop-shadow-[0_20px_30px_rgba(0,0,0,0.5)] transition-transform duration-500 group-hover:scale-110" src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"/>
                @else
                    <img class="h-full w-full object-contain drop-shadow-[0_20px_30px_rgba(0,0,0,0.5)] transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?q=80&w=500" alt="{{ $product->name }}"/>
                @endif
                <span class="absolute top-2 right-2 px-3 py-1 rounded-full bg-secondary-container/20 text-secondary-fixed-dim text-[10px] font-bold tracking-widest uppercase backdrop-blur-md">
                    {{ $product->brand }}
                </span>
            </div>
            <div class="flex-grow">
                <p class="text-[10px] font-bold text-on-surface-variant tracking-[0.2em] mb-1 uppercase">{{ $product->brand }}</p>
                <h3 class="font-headline-md text-headline-md text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2 min-h-[3.5rem]">{{ $product->name }}</h3>
                <p class="font-body-md text-primary font-bold text-xl mb-6">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('products.show', $product->slug) }}" class="w-full py-3 rounded-xl bg-white/5 border border-white/10 hover:bg-primary-container hover:text-on-primary-container hover:border-transparent transition-all duration-300 font-label-md text-label-md active:scale-95 text-center block">
                Lihat Detail
            </a>
            <!-- Decorative Glow -->
            <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/5 rounded-2xl pointer-events-none transition-all duration-500 blur-xl"></div>
        </div>
        @endforeach
    </div>
</section>

<!-- Newsletter CTA -->
<section class="px-8 md:px-margin-desktop py-20">
    <div class="glass-card rounded-[2rem] p-12 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 border-primary/20">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-primary/10 blur-[100px] rounded-full"></div>
        <div class="relative z-10 max-w-xl text-center md:text-left">
            <h2 class="font-headline-lg text-headline-lg mb-4">Dapatkan Update Eksklusif</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Jadilah yang pertama mengetahui rilis gadget terbaru dan penawaran terbatas khusus untuk member Wonder Shope.</p>
        </div>
        <div class="relative z-10 flex w-full md:w-auto items-stretch gap-2">
            <input class="bg-surface-container-low border border-white/10 rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary focus:border-transparent text-label-md w-full md:w-80 transition-all text-on-surface" placeholder="Email Anda" type="email"/>
            <button class="px-8 py-4 rounded-xl bg-primary text-on-primary font-bold hover:brightness-110 active:scale-95 transition-all">Subscribe</button>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Micro-interaction for product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    });
</script>
@endsection