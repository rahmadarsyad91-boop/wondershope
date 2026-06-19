@extends('layouts.admin')

@section('title', 'Kelola Katalog - Admin Wonder Shope')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-display-xl text-headline-lg text-on-surface">Kelola Katalog</h1>
        <p class="font-body-md text-on-surface-variant mt-1">Daftar produk teknologi Wonder Shope</p>
    </div>
    
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <!-- Search bar (Mockup) -->
        <div class="hidden sm:flex items-center bg-surface-container-highest/50 rounded-xl px-4 py-2 border border-white/10 focus-within:border-primary/50 transition-all">
            <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
            <input type="text" placeholder="Cari produk..." class="bg-transparent border-none focus:ring-0 text-label-md text-on-surface outline-none w-48">
        </div>
        
        <a href="{{ route('products.create') }}" class="bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] hover:-translate-y-0.5 text-on-primary-fixed px-5 py-2.5 rounded-xl font-label-md text-label-md font-bold uppercase tracking-widest transition-all inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">add</span> Tambah Produk
        </a>
    </div>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="font-label-md text-label-md text-on-surface-variant uppercase bg-surface-container-low/50 border-b border-white/5">
                <tr>
                    <th class="px-6 py-4 font-bold tracking-wider">No</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Nama Produk</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Merek</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Harga Dasar</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Varian / Stok</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($products as $index => $product)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4 text-on-surface-variant">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center p-1">
                                @if($product->image)
                                    <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/products/' . $product->image) }}" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-on-surface-variant">devices</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-on-surface">{{ $product->name }}</p>
                                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">{{ str()->limit($product->slug, 20) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-surface-container-highest text-on-surface-variant px-2 py-1 rounded font-label-md text-xs uppercase tracking-widest border border-white/10">{{ $product->brand }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($product->base_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="text-on-surface-variant text-xs">{{ $product->variants->count() }} Varian</span>
                        <div class="text-[10px] text-green-400 font-bold mt-1">{{ $product->variants->sum('stok') }} Stok Total</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('products.edit', $product->id) }}" class="p-2 rounded-lg bg-primary/10 text-primary border border-primary/20 hover:bg-primary/20 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg bg-error/10 text-error border border-error/20 hover:bg-error/20 transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto mb-3">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant">inventory_2</span>
                        </div>
                        <p class="font-headline-md text-on-surface mb-1">Belum ada produk</p>
                        <p class="text-on-surface-variant text-sm">Mulai tambahkan produk ke katalog Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection