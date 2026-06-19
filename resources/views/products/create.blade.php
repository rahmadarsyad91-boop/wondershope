@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin Wonder Shope')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="font-display-xl text-headline-lg text-on-surface">Tambah Produk Baru</h1>
            <p class="font-body-md text-on-surface-variant mt-1">Input data produk beserta varian stoknya</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="glass-card hover:bg-white/10 text-on-surface px-4 py-2 rounded-xl font-label-md text-label-md transition flex items-center gap-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
        </a>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf 

        <div class="glass-card rounded-2xl p-8 border border-white/10">
            <h2 class="font-headline-md text-lg text-primary mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">info</span> Informasi Utama
            </h2>

            <div class="space-y-6">
                <div>
                    <label class="block font-label-md text-sm text-on-surface mb-2">Nama Produk <span class="text-error">*</span></label>
                    <input type="text" name="name" placeholder="Contoh: Hyperion X-1 Pro" required
                           class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-label-md text-sm text-on-surface mb-2">Nama Brand <span class="text-error">*</span></label>
                        <input type="text" name="brand" placeholder="Contoh: WonderTech" required
                               class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                    </div>
                    
                    <div>
                        <label class="block font-label-md text-sm text-on-surface mb-2">Harga Dasar (Rp) <span class="text-error">*</span></label>
                        <input type="number" name="base_price" placeholder="Contoh: 15000000" required
                               class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-sm text-on-surface mb-2">Deskripsi Produk <span class="text-error">*</span></label>
                    <textarea name="description" rows="4" placeholder="Tuliskan spesifikasi produk..." required
                              class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition"></textarea>
                </div>

                <div>
                    <label class="block font-label-md text-sm text-on-surface mb-2">Link Foto Produk (URL) <span class="text-error">*</span></label>
                    <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl border border-white/10">
                        <div class="flex-1">
                            <input type="text" name="image" required placeholder="Contoh: https://imgur.com/gambar.jpg"
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
                <button type="button" id="add-variant-btn" class="bg-primary/20 hover:bg-primary/30 text-primary border border-primary/30 px-3 py-1.5 rounded-lg text-xs font-bold transition inline-flex items-center gap-1 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[14px]">add</span> Tambah Baris Varian
                </button>
            </div>
            
            <div id="variants-container" class="space-y-3">
                <div class="flex gap-4 items-center variant-row">
                    <div class="flex-1">
                        <input type="text" name="variants[0][nama_varian]" placeholder="Nama Varian (cth: Hitam 128GB)" required
                               class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition text-sm">
                    </div>
                    <div class="w-32">
                        <input type="number" name="variants[0][stok]" placeholder="Stok" min="0" required
                               class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition text-sm text-center">
                    </div>
                    <button type="button" class="text-on-surface-variant/50 p-2 transition remove-variant-btn" disabled>
                        <span class="material-symbols-outlined text-xl">delete</span>
                    </button>
                </div>
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-gradient-to-r from-[#4F8EF7] to-[#00F5FF] hover:shadow-[0_0_20px_rgba(0,245,255,0.4)] hover:-translate-y-0.5 text-on-primary-fixed font-label-md text-sm font-bold uppercase tracking-widest py-4 px-6 rounded-xl transition-all text-center flex items-center justify-center gap-2">
            <span class="material-symbols-outlined">save</span> Simpan Produk
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('variants-container');
        const addBtn = document.getElementById('add-variant-btn');
        let variantIndex = 1;

        addBtn.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.className = 'flex gap-4 items-center variant-row';
            newRow.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="variants[\${variantIndex}][nama_varian]" placeholder="Nama Varian" required
                           class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition text-sm">
                </div>
                <div class="w-32">
                    <input type="number" name="variants[\${variantIndex}][stok]" placeholder="Stok" min="0" required
                           class="w-full bg-surface-container-lowest border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 text-on-surface placeholder:text-on-surface-variant/50 outline-none transition text-sm text-center">
                </div>
                <button type="button" class="text-error hover:text-red-400 p-2 transition remove-variant-btn">
                    <span class="material-symbols-outlined text-xl">delete</span>
                </button>
            `;
            container.appendChild(newRow);
            variantIndex++;
            checkRemoveButtons();
        });

        container.addEventListener('click', function (e) {
            if (e.target.closest('.remove-variant-btn')) {
                const row = e.target.closest('.variant-row');
                row.remove();
                checkRemoveButtons();
            }
        });

        function checkRemoveButtons() {
            const rows = container.querySelectorAll('.variant-row');
            const deleteBtns = container.querySelectorAll('.remove-variant-btn');
            deleteBtns.forEach(btn => {
                btn.disabled = rows.length === 1;
                if(rows.length === 1) {
                    btn.classList.add('text-on-surface-variant/50');
                    btn.classList.remove('text-error', 'hover:text-red-400');
                } else {
                    btn.classList.remove('text-on-surface-variant/50');
                    btn.classList.add('text-error', 'hover:text-red-400');
                }
            });
        }
    });
</script>
@endsection