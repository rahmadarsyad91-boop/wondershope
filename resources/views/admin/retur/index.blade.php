@extends('layouts.admin')

@section('title', 'Barang Retur - Admin Wonder Shope')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-display-xl text-headline-lg text-on-surface">Barang Retur</h1>
        <p class="font-body-md text-on-surface-variant mt-1">Daftar pesanan dengan status dikembalikan atau retur</p>
    </div>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="font-label-md text-label-md text-on-surface-variant uppercase bg-surface-container-low/50 border-b border-white/5">
                <tr>
                    <th class="px-6 py-4 font-bold tracking-wider">No</th>
                    <th class="px-6 py-4 font-bold tracking-wider">ID Pesanan</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Penerima</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Item</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Total Harga</th>
                    <th class="px-6 py-4 font-bold tracking-wider">Tanggal Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($itemsRetur as $index => $item)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4 text-on-surface-variant">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-on-surface">#ORD-{{ str_pad($item->order_id, 5, '0', STR_PAD_LEFT) }}</span>
                        <div class="mt-1">
                            <span class="px-2 py-0.5 rounded-full font-label-md text-[10px] tracking-widest uppercase font-bold border bg-orange-500/10 text-orange-400 border-orange-500/20">RETUR</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-on-surface">{{ $item->order->nama_penerima }}</div>
                        <div class="text-[10px] text-on-surface-variant mt-0.5 truncate max-w-[150px]">{{ $item->order->alamat_lengkap }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <ul class="list-disc pl-4 text-on-surface-variant space-y-1">
                                <li>{{ $item->product_name }} <span class="text-[10px]">({{ $item->quantity }}x)</span></li>
                        </ul>
                    </td>
                    <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-xs text-on-surface-variant">
                        {{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d M Y, H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto mb-3">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant">assignment_return</span>
                        </div>
                        <p class="font-headline-md text-on-surface mb-1">Tidak ada retur</p>
                        <p class="text-on-surface-variant text-sm">Tidak ada pesanan yang diretur saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection