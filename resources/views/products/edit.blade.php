@extends('layouts.admin')

@section('title', 'Edit Produk - Admin Wonder Shope')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="font-display-xl text-headline-lg text-on-surface">Edit Produk</h1>
            <p class="font-body-md text-on-surface-variant mt-1">Perbarui data, foto, dan kelola varian stok Wonder Shope</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="glass-card hover:bg-white/10 text-on-surface px-4 py-2 rounded-xl font-label-md text-label-md transition flex items-center gap-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
        </a>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf 
        @method('PUT')

        <div class="glass-card rounded-2xl p-8 border border-white/10">
            <h2 class="font-headline-md text-lg text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">info</span> Informasi Utama
            </h2>

            <div class="space-y-6">
                <div>
                    <label class="block font-label-md text-sm text-on-surface mb-2">Nama Produk <span class="text-error">*</span></label>
                    <input type="text" name="name" value="{{ $product->name }}" required
                           class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-label-md text-sm text-on-surface mb-2">Nama Brand <span class="text-error">*</span></label>
                        <input type="text" name="brand" value="{{ $product->brand }}" required
                               class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                    </div>
                    
                    <div>
                        <label class="block font-label-md text-sm text-on-surface mb-2">Harga Dasar (Rp) <span class="text-error">*</span></label>
                        <input type="number" name="base_price" value="{{ $product->base_price }}" required
                               class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-sm text-on-surface mb-2">Deskripsi Produk <span class="text-error">*</span></label>
                    <textarea name="description" rows="4" required
                              class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">{{ $product->description }}</textarea>
                </div>

                <div>
                    <label class="block font-label-md text-sm text-on-surface mb-2">Link Foto Produk (URL) <span class="text-error">*</span></label>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-white/5 rounded-xl border border-white/10">
                        @if($product->image)
                            <div class="text-center bg-black/20 p-2 rounded-xl border border-white/10 shrink-0">
                                <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/products/' . $product->image) }}" alt="Foto Produk" class="w-20 h-20 object-contain rounded-lg">
                            </div>
                        @endif
                        <div class="flex-1 w-full">
                            <input type="text" name="image" value="{{ $product->image }}" required placeholder="Contoh: https://imgur.com/gambar.jpg"
                                   class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                            <p class="text-[10px] text-on-surface-variant mt-2 uppercase tracking-widest">Karena hosting Vercel tidak bisa menyimpan file, masukkan link gambar (URL).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-8 border border-white/10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-headline-md text-lg text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">category</span> Varian & Stok
                </h2>
                <button type="button" id="btn-tambah-varian" class="bg-primary/20 hover:bg-primary/30 text-primary border border-primary/30 px-3 py-1.5 rounded-lg text-xs font-bold transition inline-flex items-center gap-1 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[14px]">add</span> Tambah Varian
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="space-y-3">
                    @foreach($product->variants as $index => $variant)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-white/5 rounded-xl border border-white/10">
                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                            <div>
                                <label class="block font-label-md text-xs text-on-surface-variant uppercase tracking-widest mb-1">Nama Varian</label>
                                <input type="text" name="variants[{{ $index }}][nama_varian]" value="{{ $variant->nama_varian }}" required
                                       class="w-full px-3 py-2 text-sm rounded-lg border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary bg-surface-container-lowest text-on-surface outline-none transition">
                            </div>
                            <div>
                                <label class="block font-label-md text-xs text-on-surface-variant uppercase tracking-widest mb-1">Stok Barang</label>
                                <input type="number" name="variants[{{ $index }}][stok]" value="{{ $variant->stok }}" required min="0"
                                       class="w-full px-3 py-2 text-sm rounded-lg border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary bg-surface-container-lowest text-on-surface outline-none transition">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="container-varian-baru" class="space-y-3 pt-3"></div>
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] hover:-translate-y-0.5 text-on-primary-fixed font-label-md text-sm font-bold uppercase tracking-widest py-4 px-6 rounded-xl transition-all text-center flex items-center justify-center gap-2">
            <span class="material-symbols-outlined">save</span> Simpan Perubahan Data
        </button>
    </form>
</div>

<script>
    let indexVarianBaru = 0;

    document.getElementById('btn-tambah-varian').addEventListener('click', function() {
        const container = document.getElementById('container-varian-baru');
        const htmlBaru = `
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 p-4 bg-primary/5 rounded-xl border border-primary/20 items-end dynamic-variant-row">
                <div class="sm:col-span-6">
                    <label class="block font-label-md text-xs text-primary uppercase tracking-widest mb-1">Nama Varian Baru</label>
                    <input type="text" name="new_variants[${indexVarianBaru}][nama_varian]" required placeholder="Misal: Merah / 128GB"
                           class="w-full px-3 py-2 text-sm rounded-lg border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary bg-surface-container-lowest text-on-surface outline-none transition">
                </div>
                <div class="sm:col-span-4">
                    <label class="block font-label-md text-xs text-primary uppercase tracking-widest mb-1">Stok Awal</label>
                    <input type="number" name="new_variants[${indexVarianBaru}][stok]" required min="0" value="0"
                           class="w-full px-3 py-2 text-sm rounded-lg border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary bg-surface-container-lowest text-on-surface outline-none transition">
                </div>
                <div class="sm:col-span-2 text-right">
                    <button type="button" class="btn-hapus-row bg-error/10 hover:bg-error/20 text-error border border-error/20 px-3 py-2 rounded-lg font-label-md text-xs font-bold transition w-full h-[38px] inline-flex items-center justify-center gap-1 uppercase tracking-widest">
                        <span class="material-symbols-outlined text-[14px]">delete</span>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', htmlBaru);
        indexVarianBaru++;
    });

    document.getElementById('container-varian-baru').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus-row') || e.target.closest('.btn-hapus-row')) {
            const row = e.target.closest('.dynamic-variant-row');
            row.remove();
        }
    });
</script>
@endsection