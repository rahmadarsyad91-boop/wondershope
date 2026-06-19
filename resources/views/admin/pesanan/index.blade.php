@extends('layouts.admin')

@section('title', 'Pesanan Masuk - Admin Wonder Shope')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-display-xl text-headline-lg text-on-surface">Pesanan Masuk</h1>
        <p class="font-body-md text-on-surface-variant mt-1">Kelola status pesanan yang sedang diproses</p>
    </div>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="font-label-md text-label-md text-on-surface-variant uppercase bg-surface-container-low/50 border-b border-white/5">
                <tr>
                    <th class="px-6 py-4 font-bold tracking-wider">ID Pesanan</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Penerima</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Metode Bayar</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Total</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($orders as $order)
                <tr class="hover:bg-white/5 transition group">
                    <td class="px-6 py-4">
                        <span class="font-bold text-on-surface">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <div class="text-[10px] text-on-surface-variant mt-1">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-on-surface">{{ $order->nama_penerima }}</div>
                        <div class="text-xs text-on-surface-variant mt-0.5">{{ $order->telepon }}</div>
                        <div class="text-[10px] text-on-surface-variant mt-0.5 truncate max-w-[150px]" title="{{ $order->alamat_lengkap }}">{{ $order->alamat_lengkap }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-surface-container-highest text-on-surface-variant px-2 py-1 rounded font-label-md text-xs border border-white/10">{{ $order->metode_bayar }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full font-label-md text-[10px] tracking-widest uppercase font-bold border bg-primary/10 text-primary border-primary/20">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            @if($order->status == 'diproses')
                                <form action="{{ route('admin.pesanan.kirim', $order->id) }}" method="POST" onsubmit="return confirm('Kirim barang pesanan ini sekarang?')">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-secondary-fixed-dim to-[#00b3bb] hover:shadow-[0_0_15px_rgba(0,220,229,0.4)] text-on-secondary-fixed px-4 py-2 rounded-lg font-label-md text-xs font-bold uppercase tracking-widest transition-all inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">local_shipping</span> Kirim
                                    </button>
                                </form>
                                <form action="{{ route('admin.pesanan.batal', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini? Stok akan dikembalikan.')">
                                    @csrf
                                    <button type="submit" class="bg-error/10 hover:bg-error/20 border border-error/20 text-error px-4 py-2 rounded-lg font-label-md text-xs font-bold uppercase tracking-widest transition-all inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">cancel</span> Batal
                                    </button>
                                </form>
                            @elseif($order->status == 'selesai' || $order->status == 'dikirim')
                                <form action="{{ route('admin.pesanan.retur', $order->id) }}" method="POST" onsubmit="return confirm('Retur pesanan ini? Stok akan dikembalikan.')">
                                    @csrf
                                    <button type="submit" class="bg-yellow-500/10 hover:bg-yellow-500/20 border border-yellow-500/20 text-yellow-400 px-4 py-2 rounded-lg font-label-md text-xs font-bold uppercase tracking-widest transition-all inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">assignment_return</span> Retur
                                    </button>
                                </form>
                            @else
                                <span class="text-on-surface-variant text-xs italic">Tidak ada aksi</span>
                            @endif
                        </div>
                    </td>
                </tr>
                <!-- Rincian Item Collapse -->
                <tr class="bg-black/10 border-b border-white/5 hidden group-hover:table-row transition-all">
                    <td colspan="6" class="px-6 py-4">
                        <div class="flex flex-col gap-2">
                            <p class="font-label-md text-[10px] text-on-surface-variant uppercase tracking-widest mb-1">Rincian Item</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($order->items as $item)
                                <div class="flex items-center gap-3 bg-white/5 border border-white/5 p-2 rounded-lg">
                                    <span class="material-symbols-outlined text-on-surface-variant text-xl">devices</span>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface line-clamp-1">{{ $item->product_name }}</p>
                                        <p class="text-[10px] text-on-surface-variant">{{ $item->variant_name }} x {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto mb-3">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant">inbox</span>
                        </div>
                        <p class="font-headline-md text-on-surface mb-1">Tidak ada pesanan masuk</p>
                        <p class="text-on-surface-variant text-sm">Semua pesanan telah diproses.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection