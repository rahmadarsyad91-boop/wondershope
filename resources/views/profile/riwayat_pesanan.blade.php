@extends('layouts.app')

@section('title', 'Pesanan Saya | Wonder Shope')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- HEADER -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-display-xl text-headline-lg text-on-surface">Pesanan Saya</h1>
            <p class="font-body-md text-on-surface-variant mt-1">Halo, <span class="font-bold text-primary">{{ Auth::user()->name }}</span>! Pantau semua status belanjaan Anda di sini.</p>
        </div>
        <a href="{{ route('home') }}" class="glass-card hover:bg-white/10 text-on-surface px-4 py-2 rounded-xl font-label-md text-label-md transition flex items-center gap-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">shopping_bag</span> Belanja Lagi
        </a>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="glass-card rounded-2xl p-6 border border-white/10 flex flex-col gap-2 hover:-translate-y-1 transition duration-300">
            <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">Total Pesanan</p>
            <p class="font-headline-lg text-3xl text-on-surface">{{ $stats['total'] }}</p>
            <p class="text-xs text-on-surface-variant opacity-60">Semua transaksi</p>
        </div>
        <div class="glass-card rounded-2xl p-6 border border-primary/20 flex flex-col gap-2 hover:-translate-y-1 transition duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-primary/10 rounded-full blur-xl"></div>
            <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-primary">Diproses</p>
            <p class="font-headline-lg text-3xl text-primary">{{ $stats['diproses'] }}</p>
            <p class="text-xs text-on-surface-variant opacity-60">Menunggu dikirim</p>
        </div>
        <div class="glass-card rounded-2xl p-6 border border-secondary-fixed/20 flex flex-col gap-2 hover:-translate-y-1 transition duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-secondary-fixed/10 rounded-full blur-xl"></div>
            <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-secondary-fixed-dim">Dikirim</p>
            <p class="font-headline-lg text-3xl text-secondary-fixed-dim">{{ $stats['dikirim'] }}</p>
            <p class="text-xs text-on-surface-variant opacity-60">Dalam perjalanan</p>
        </div>
        <div class="glass-card rounded-2xl p-6 border border-green-500/20 flex flex-col gap-2 hover:-translate-y-1 transition duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-green-500/10 rounded-full blur-xl"></div>
            <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-green-400">Selesai</p>
            <p class="font-headline-lg text-3xl text-green-400">{{ $stats['selesai'] }}</p>
            <p class="text-xs text-on-surface-variant opacity-60">Transaksi berhasil</p>
        </div>
    </div>

    <!-- TABS FILTER -->
    <div class="mb-8 overflow-x-auto scrollbar-hide">
        <div class="flex gap-2 min-w-max pb-2" id="filter-tabs">
            <button onclick="filterOrders('semua')" class="tab-btn active px-6 py-2.5 rounded-full font-label-md text-sm transition-all bg-primary/20 text-primary border border-primary/30" data-status="semua">
                Semua Pesanan
            </button>
            <button onclick="filterOrders('diproses')" class="tab-btn px-6 py-2.5 rounded-full font-label-md text-sm transition-all glass-card text-on-surface-variant hover:text-on-surface border border-white/5 hover:bg-white/5" data-status="diproses">
                Sedang Diproses
            </button>
            <button onclick="filterOrders('dikirim')" class="tab-btn px-6 py-2.5 rounded-full font-label-md text-sm transition-all glass-card text-on-surface-variant hover:text-on-surface border border-white/5 hover:bg-white/5" data-status="dikirim">
                Dikirim
            </button>
            <button onclick="filterOrders('selesai')" class="tab-btn px-6 py-2.5 rounded-full font-label-md text-sm transition-all glass-card text-on-surface-variant hover:text-on-surface border border-white/5 hover:bg-white/5" data-status="selesai">
                Selesai
            </button>
            <button onclick="filterOrders('batal')" class="tab-btn px-6 py-2.5 rounded-full font-label-md text-sm transition-all glass-card text-on-surface-variant hover:text-on-surface border border-white/5 hover:bg-white/5" data-status="batal">
                Batal
            </button>
            <button onclick="filterOrders('retur')" class="tab-btn px-6 py-2.5 rounded-full font-label-md text-sm transition-all glass-card text-on-surface-variant hover:text-on-surface border border-white/5 hover:bg-white/5" data-status="retur">
                Retur
            </button>
        </div>
    </div>

    <!-- ORDER LIST -->
    <div class="space-y-6" id="orders-container">
        @forelse($pesananSaya as $order)
            <div class="order-card glass-card rounded-2xl border border-white/10 overflow-hidden" data-status="{{ strtolower($order->status) }}">
                
                <!-- Card Header -->
                <div class="bg-surface-container-low/50 px-6 py-4 flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center 
                            @if($order->status == 'diproses') bg-primary/20 text-primary border border-primary/30
                            @elseif($order->status == 'dikirim') bg-secondary-fixed/20 text-secondary-fixed-dim border border-secondary-fixed/30
                            @elseif($order->status == 'selesai') bg-green-500/20 text-green-400 border border-green-500/30
                            @elseif($order->status == 'batal') bg-error/20 text-error border border-error/30
                            @else bg-orange-500/20 text-orange-400 border border-orange-500/30 @endif
                        ">
                            <span class="material-symbols-outlined text-sm">
                                @if($order->status == 'diproses') pending_actions
                                @elseif($order->status == 'dikirim') local_shipping
                                @elseif($order->status == 'selesai') check_circle
                                @elseif($order->status == 'batal') cancel
                                @else assignment_return @endif
                            </span>
                        </div>
                        <div>
                            <p class="font-label-md text-xs text-on-surface-variant mb-0.5">ID Pesanan: <span class="text-on-surface font-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                            <p class="text-xs text-on-surface-variant">{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full font-label-md text-[11px] tracking-widest uppercase font-bold border
                            @if($order->status == 'diproses') bg-primary/10 text-primary border-primary/20
                            @elseif($order->status == 'dikirim') bg-secondary-fixed/10 text-secondary-fixed-dim border-secondary-fixed/20
                            @elseif($order->status == 'selesai') bg-green-500/10 text-green-400 border-green-500/20
                            @elseif($order->status == 'batal') bg-error/10 text-error border-error/20
                            @else bg-orange-500/10 text-orange-400 border-orange-500/20 @endif
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <!-- Progress Tracker (only for active orders) -->
                @if(in_array($order->status, ['diproses', 'dikirim', 'selesai']))
                <div class="px-6 py-5 border-b border-white/5 bg-black/10">
                    <div class="relative max-w-2xl mx-auto">
                        <div class="overflow-hidden h-1 mb-4 text-xs flex rounded-full bg-white/10">
                            @php
                                $progress = 0;
                                if($order->status == 'diproses') $progress = 33;
                                if($order->status == 'dikirim') $progress = 66;
                                if($order->status == 'selesai') $progress = 100;
                            @endphp
                            <div style="width: {{ $progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] transition-all duration-1000"></div>
                        </div>
                        <div class="flex justify-between text-[11px] font-label-md text-on-surface-variant font-bold uppercase tracking-wider">
                            <div class="text-center w-1/3 {{ $progress >= 33 ? 'text-primary' : '' }}">Diproses</div>
                            <div class="text-center w-1/3 {{ $progress >= 66 ? 'text-secondary-fixed-dim' : '' }}">Dikirim</div>
                            <div class="text-center w-1/3 {{ $progress == 100 ? 'text-green-400' : '' }}">Diterima</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Card Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Items list -->
                        <div class="md:col-span-2 space-y-4">
                            <p class="font-label-md text-xs text-on-surface-variant uppercase tracking-widest mb-3">Detail Produk</p>
                            @foreach($order->items as $item)
                            <div class="flex items-center gap-4 bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="w-16 h-16 bg-black/20 rounded-lg flex items-center justify-center border border-white/10">
                                    <span class="material-symbols-outlined text-3xl text-on-surface-variant">devices</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-sm font-bold text-on-surface">{{ $item->product_name }}</p>
                                    <p class="text-xs text-on-surface-variant mt-1">{{ $item->variant_name }} <span class="mx-2">•</span> {{ $item->quantity }} pcs</p>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="font-label-md text-sm text-primary font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Summary -->
                        <div class="border-t md:border-t-0 md:border-l border-white/10 pt-4 md:pt-0 md:pl-6 flex flex-col">
                            <p class="font-label-md text-xs text-on-surface-variant uppercase tracking-widest mb-3">Pengiriman & Pembayaran</p>
                            
                            <div class="mb-4">
                                <p class="text-xs text-on-surface-variant mb-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">location_on</span> Alamat</p>
                                <p class="font-body-md text-sm text-on-surface leading-snug">{{ $order->alamat_lengkap }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-xs text-on-surface-variant mb-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">payments</span> Metode</p>
                                <p class="font-label-md text-sm text-on-surface font-bold">{{ $order->metode_bayar }}</p>
                            </div>

                            <div class="mt-auto bg-surface-container-highest/50 p-4 rounded-xl border border-white/5">
                                <p class="font-label-md text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <p class="font-headline-md text-xl text-primary font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                            
                            <!-- Action Button -->
                            @if($order->status == 'dikirim')
                            <form action="{{ route('member.pesanan.diterima', $order->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Apakah Anda yakin pesanan sudah diterima dengan baik?')">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-400 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] text-white hover:-translate-y-0.5 py-3 rounded-xl font-label-md text-sm font-bold uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-sm">check_circle</span> Sudah Diterima
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('member.pesanan.show', $order->id) }}" class="mt-2 w-full glass-card hover:bg-white/10 border border-white/10 text-on-surface hover:-translate-y-0.5 py-3 rounded-xl font-label-md text-sm font-bold uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">receipt_long</span> Lihat Invoice
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-20 border border-dashed border-white/20 rounded-2xl glass-card">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10">
                    <span class="material-symbols-outlined text-3xl text-on-surface-variant">receipt_long</span>
                </div>
                <p class="text-on-surface font-headline-md text-headline-md mb-2">Belum ada pesanan</p>
                <p class="text-on-surface-variant font-body-md text-body-md mb-8">Anda belum pernah melakukan transaksi.</p>
                <a href="{{ route('home') }}" class="bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] text-on-primary-fixed px-8 py-3 rounded-xl font-label-md text-label-md font-bold uppercase tracking-widest transition inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">shopping_cart</span> Mulai Belanja
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection

@section('scripts')
<script>
function filterOrders(status) {
    // Update tabs styling
    document.querySelectorAll('.tab-btn').forEach(btn => {
        if(btn.dataset.status === status) {
            btn.className = 'tab-btn active px-6 py-2.5 rounded-full font-label-md text-sm transition-all bg-primary/20 text-primary border border-primary/30';
        } else {
            btn.className = 'tab-btn px-6 py-2.5 rounded-full font-label-md text-sm transition-all glass-card text-on-surface-variant hover:text-on-surface border border-white/5 hover:bg-white/5';
        }
    });

    // Filter cards
    const cards = document.querySelectorAll('.order-card');
    cards.forEach(card => {
        if(status === 'semua' || card.dataset.status === status) {
            card.style.display = 'block';
            // Add a small fade-in effect
            card.style.opacity = '0';
            setTimeout(() => { card.style.opacity = '1'; }, 50);
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection