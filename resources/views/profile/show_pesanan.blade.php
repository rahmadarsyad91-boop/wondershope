@extends('layouts.app')

@section('title', 'Detail Pesanan | Wonder Shope')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="font-display-xl text-headline-lg text-on-surface">Detail Pesanan #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="font-body-md text-on-surface-variant mt-1">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('member.pesanan') }}" class="glass-card hover:bg-white/10 text-on-surface px-4 py-2 rounded-xl font-label-md text-label-md transition flex items-center gap-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6 border border-white/10">
            <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Informasi Pengiriman</h3>
            <p class="font-bold text-on-surface">{{ $order->nama_penerima }}</p>
            <p class="text-sm text-on-surface-variant mt-1">{{ $order->telepon }}</p>
            <p class="text-sm text-on-surface-variant mt-2">{{ $order->alamat_lengkap }}</p>
        </div>
        
        <div class="glass-card rounded-2xl p-6 border border-white/10">
            <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Pembayaran</h3>
            <p class="font-bold text-on-surface">Metode: {{ $order->metode_bayar }}</p>
            <p class="text-sm text-on-surface-variant mt-1 border-t border-white/10 pt-2 mt-2">
                Status: 
                @if($order->status == 'diproses')
                    <span class="text-primary font-bold">Diproses</span>
                @elseif($order->status == 'dikirim')
                    <span class="text-orange-400 font-bold">Dikirim</span>
                @elseif($order->status == 'selesai')
                    <span class="text-green-400 font-bold">Selesai</span>
                @elseif($order->status == 'retur')
                    <span class="text-yellow-400 font-bold">Diretur</span>
                @else
                    <span class="text-error font-bold">Dibatalkan</span>
                @endif
            </p>
        </div>
        
        <div class="glass-card rounded-2xl p-6 border border-primary/20 bg-surface-container-low">
            <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Total Belanja</h3>
            <p class="font-headline-lg text-primary text-3xl">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            
            @if($order->status == 'dikirim')
            <form action="{{ route('member.pesanan.diterima', $order->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Apakah Anda yakin paket telah diterima dengan baik?')">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-xl transition text-sm flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span> Konfirmasi Diterima
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
        <h3 class="font-headline-md text-lg text-on-surface p-6 border-b border-white/10 bg-surface-container-low/50">Rincian Produk</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="font-label-md text-label-md text-on-surface-variant uppercase bg-surface-container-low/50 border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">Produk</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Varian</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Harga</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Qty</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($order->items as $item)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 font-bold text-on-surface">{{ $item->product_name }}</td>
                        <td class="px-6 py-4 text-on-surface-variant">
                            <span class="bg-primary/10 text-primary text-xs px-2.5 py-1 rounded-md border border-primary/20 font-bold">
                                {{ $item->variant_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-on-surface-variant">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center font-bold text-on-surface">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right font-bold text-primary">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
