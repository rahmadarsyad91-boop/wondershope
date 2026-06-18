@extends('layouts.admin')

@section('title', 'Admin Dashboard - Wonder Shope')

@section('content')
<div class="mb-8">
    <h1 class="font-display-xl text-headline-lg text-on-surface">Admin Dashboard</h1>
    <p class="font-body-md text-on-surface-variant mt-1">Ringkasan aktivitas dan performa toko Anda.</p>
</div>

<!-- STAT CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Produk -->
    <div class="glass-card rounded-2xl p-6 border border-white/10 hover:-translate-y-1 hover:border-primary/30 transition duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 bg-primary/10 rounded-full blur-2xl group-hover:bg-primary/20 transition-all"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-on-surface-variant mb-2">Total Produk</p>
                <p class="font-headline-lg text-4xl text-on-surface">{{ $totalProduk }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/5 flex items-center gap-2 text-xs text-on-surface-variant">
            <span class="material-symbols-outlined text-[14px] text-green-400">trending_up</span>
            <span class="text-green-400 font-bold">+12%</span> dari bulan lalu
        </div>
    </div>

    <!-- Total Pesanan -->
    <div class="glass-card rounded-2xl p-6 border border-white/10 hover:-translate-y-1 hover:border-secondary-fixed/30 transition duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 bg-secondary-fixed/10 rounded-full blur-2xl group-hover:bg-secondary-fixed/20 transition-all"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-on-surface-variant mb-2">Total Pesanan</p>
                <p class="font-headline-lg text-4xl text-on-surface">{{ $totalPesanan }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-secondary-fixed-dim group-hover:bg-secondary-fixed/10 transition-colors">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/5 flex items-center gap-2 text-xs text-on-surface-variant">
            <span class="text-secondary-fixed-dim font-bold">{{ $totalPesanan }}</span> transaksi sukses
        </div>
    </div>

    <!-- Barang Terjual -->
    <div class="glass-card rounded-2xl p-6 border border-white/10 hover:-translate-y-1 hover:border-green-500/30 transition duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-all"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-on-surface-variant mb-2">Barang Terjual</p>
                <p class="font-headline-lg text-4xl text-on-surface">{{ $totalTerjual }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-green-400 group-hover:bg-green-500/10 transition-colors">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/5 flex items-center gap-2 text-xs text-on-surface-variant">
            <span class="text-green-400 font-bold">Laris Manis!</span>
        </div>
    </div>

    <!-- Barang Retur -->
    <div class="glass-card rounded-2xl p-6 border border-white/10 hover:-translate-y-1 hover:border-orange-500/30 transition duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 bg-orange-500/10 rounded-full blur-2xl group-hover:bg-orange-500/20 transition-all"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="font-label-md text-[11px] font-bold uppercase tracking-widest text-on-surface-variant mb-2">Barang Retur</p>
                <p class="font-headline-lg text-4xl text-on-surface">{{ $totalRetur }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-orange-400 group-hover:bg-orange-500/10 transition-colors">
                <span class="material-symbols-outlined">assignment_return</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/5 flex items-center gap-2 text-xs text-on-surface-variant">
            <span class="text-orange-400 font-bold">Perlu Perhatian</span>
        </div>
    </div>
</div>

<!-- CHARTS / RECENT ACTIVITY SECTION (MOCKUP) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Chart Mockup -->
    <div class="lg:col-span-2 glass-card rounded-2xl border border-white/10 p-6 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-headline-md text-xl text-on-surface">Tren Penjualan (Minggu Ini)</h2>
            <button class="px-3 py-1 rounded-lg bg-white/5 border border-white/10 text-xs font-label-md hover:bg-white/10 transition">Lihat Detail</button>
        </div>
        <div class="flex-1 w-full bg-surface-container-lowest/50 rounded-xl border border-white/5 flex items-end p-4 gap-2 h-64">
            <!-- Simulated Bar Chart -->
            @php $heights = [30, 50, 40, 70, 60, 90, 80]; @endphp
            @foreach($heights as $h)
                <div class="flex-1 bg-gradient-to-t from-primary/20 to-primary/80 rounded-t-sm hover:brightness-125 transition-all cursor-pointer relative group" style="height: {{ $h }}%">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface px-2 py-1 rounded text-xs font-bold border border-white/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Rp{{ $h }}Jt</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="glass-card rounded-2xl border border-white/10 p-6">
        <h2 class="font-headline-md text-xl text-on-surface mb-6">Aktivitas Terkini</h2>
        <div class="space-y-4">
            <div class="flex gap-4">
                <div class="w-2 h-2 rounded-full bg-primary mt-2"></div>
                <div>
                    <p class="text-sm text-on-surface font-bold">Pesanan Baru Masuk</p>
                    <p class="text-xs text-on-surface-variant mt-0.5">#ORD-00123 oleh Budi Santoso</p>
                    <p class="text-[10px] text-on-surface-variant opacity-60 mt-1">5 menit yang lalu</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-2 h-2 rounded-full bg-green-400 mt-2"></div>
                <div>
                    <p class="text-sm text-on-surface font-bold">Pesanan Selesai</p>
                    <p class="text-xs text-on-surface-variant mt-0.5">#ORD-00118 diterima pelanggan</p>
                    <p class="text-[10px] text-on-surface-variant opacity-60 mt-1">1 jam yang lalu</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-2 h-2 rounded-full bg-orange-400 mt-2"></div>
                <div>
                    <p class="text-sm text-on-surface font-bold">Permintaan Retur</p>
                    <p class="text-xs text-on-surface-variant mt-0.5">Produk: Hyperion X-1 Pro</p>
                    <p class="text-[10px] text-on-surface-variant opacity-60 mt-1">2 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection