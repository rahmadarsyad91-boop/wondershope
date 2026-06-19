<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Katalog Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Produk Wonder Shope</h3>
                    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                        + Tambah Produk
                    </a>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Nama Produk</th>
                                <th class="px-6 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Brand</th>
                                <th class="px-6 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Harga Base</th>
                                <th class="px-6 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Varian & Stok</th>
                                <th class="px-6 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/products/' . $product->image) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200" alt="{{ $product->name }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $product->brand }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        Rp {{ number_format($product->base_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @if($product->variants && $product->variants->count() > 0)
                                                @foreach($product->variants as $variant)
                                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded border border-gray-200">
                                                        {{ $variant->nama_varian }} (Stok: {{ $variant->stok }})
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs text-amber-600 font-medium">Tidak ada varian</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1.5 rounded-md transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1.5 rounded-md transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada produk di katalog. Silakan tambah produk baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>