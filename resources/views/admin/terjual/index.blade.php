@extends('layouts.admin')

@section('title', 'Barang Terjual - Admin Wonder Shope')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-display-xl text-headline-lg text-on-surface">Barang Terjual</h1>
        <p class="font-body-md text-on-surface-variant mt-1">Laporan produk yang telah berhasil terjual (Status: Selesai)</p>
    </div>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="font-label-md text-label-md text-on-surface-variant uppercase bg-surface-container-low/50 border-b border-white/5">
                <tr>
                    <th class="px-6 py-4 font-bold tracking-wider">No</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Nama Produk</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Varian</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-center">Terjual</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Harga Satuan</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Subtotal</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Tgl Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($itemsTerjual as $index => $item)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4 text-on-surface-variant">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-bold text-on-surface">
                        {{ $item->product_name }}
                        <div class="text-[10px] text-on-surface-variant mt-1 font-normal">ID Pesanan: #ORD-{{ str_pad($item->order_id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-surface-container-highest text-on-surface-variant px-2 py-1 rounded font-label-md text-xs border border-white/10">{{ $item->variant_name }}</span>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-primary">{{ $item->quantity }} pcs</td>
                    <td class="px-6 py-4 text-on-surface-variant">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-bold text-green-400">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-xs text-on-surface-variant">
                        {{ \Carbon\Carbon::parse($item->order->updated_at)->translatedFormat('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto mb-3">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant">check_circle</span>
                        </div>
                        <p class="font-headline-md text-on-surface mb-1">Belum ada barang terjual</p>
                        <p class="text-on-surface-variant text-sm">Pesanan dengan status selesai akan muncul di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection