@extends('layout.layout')

@section('title', 'Info Koleksi Buku')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">📚 Koleksi Buku</h1>
        <p class="text-gray-600">Jelajahi dan pinjam koleksi buku perpustakaan digital kami</p>
    </div>

    <!-- Statistik Buku -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <div class="text-blue-600 text-sm font-semibold mb-2">TOTAL BUKU</div>
            <div class="text-3xl font-bold text-blue-900">{{ $totalBooks }}</div>
            <div class="text-xs text-blue-600 mt-2">{{ $totalBooks }} Judul</div>
        </div>
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <div class="text-green-600 text-sm font-semibold mb-2">TOTAL STOK</div>
            <div class="text-3xl font-bold text-green-900">{{ $totalStock }}</div>
            <div class="text-xs text-green-600 mt-2">Eksemplar Tersedia</div>
        </div>
        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
            <div class="text-yellow-600 text-sm font-semibold mb-2">STOK TERBATAS</div>
            <div class="text-3xl font-bold text-yellow-900">{{ $limitedStock }}</div>
            <div class="text-xs text-yellow-600 mt-2">≤ 5 Eksemplar</div>
        </div>
        <div class="bg-red-50 p-6 rounded-lg border border-red-200">
            <div class="text-red-600 text-sm font-semibold mb-2">HABIS</div>
            <div class="text-3xl font-bold text-red-900">{{ $emptyStock }}</div>
            <div class="text-xs text-red-600 mt-2">Tidak Tersedia</div>
        </div>
    </div>

    <!-- Statistik Peminjaman -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">📊 Statistik Peminjaman</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="text-3xl font-bold text-yellow-600">{{ $peminjamanStats['aktif'] }}</div>
                <div class="text-sm text-gray-600 mt-2">Sedang Dipinjam</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="text-3xl font-bold text-green-600">{{ $peminjamanStats['dikembalikan'] }}</div>
                <div class="text-sm text-gray-600 mt-2">Dikembalikan</div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
                <div class="text-3xl font-bold text-red-600">{{ $peminjamanStats['hilang'] }}</div>
                <div class="text-sm text-gray-600 mt-2">Hilang</div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-8 text-white">
        <h3 class="text-2xl font-bold mb-2">🎉 Ingin Meminjam Buku?</h3>
        <p class="mb-4">Jelajahi koleksi kami dan pinjam buku favorit Anda dengan mudah</p>
        <a href="{{ route('perpustakaan.pinjam') }}" class="inline-block px-6 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition duration-200">
            👉 Mulai Meminjam Sekarang
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🔍 Cari Buku</h2>
        <form action="{{ route('buku.info') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input 
                type="text" 
                name="search" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Cari judul buku..."
                value="{{ request('search') }}"
            >
            <select 
                name="category" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Semua Kategori</option>
                <option value="Fabel" {{ request('category') === 'Fabel' ? 'selected' : '' }}>Fabel</option>
                <option value="Pendidikan" {{ request('category') === 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="Laporan Karya Ilmiah" {{ request('category') === 'Laporan Karya Ilmiah' ? 'selected' : '' }}>Laporan Karya Ilmiah</option>
            </select>
            <button 
                type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-semibold"
            >
                Cari
            </button>
        </form>
    </div>

    <!-- Daftar Buku -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">📖 Daftar Buku</h2>
        </div>
        
        @if($bookStocks->isEmpty())
            <div class="p-8 text-center">
                <div class="text-6xl mb-4">📚</div>
                <p class="text-gray-500 text-lg">Tidak ada buku yang sesuai dengan pencarian</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Judul</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Stok Awal</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Stok Sekarang</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Masuk</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Keluar</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Rusak</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Hilang</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookStocks as $stock)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">{{ $stock->judul_buku }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        {{ $stock->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-gray-700">{{ $stock->stok_awal }}</td>
                                <td class="px-6 py-4 text-center font-semibold">
                                    <span class="inline-block px-3 py-1 rounded-lg {{ 
                                        $stock->stok_saat_ini <= 0 ? 'bg-red-100 text-red-700' :
                                        ($stock->stok_saat_ini <= 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700')
                                    }}">
                                        {{ $stock->stok_saat_ini }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $stock->stok_masuk }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $stock->stok_keluar }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $stock->stok_rusak }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $stock->stok_hilang }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($stock->stok_saat_ini <= 0)
                                        <span class="inline-block px-3 py-1 bg-red-500 text-white rounded-full text-xs font-semibold">Habis</span>
                                    @elseif($stock->stok_saat_ini <= 5)
                                        <span class="inline-block px-3 py-1 bg-yellow-500 text-white rounded-full text-xs font-semibold">Terbatas</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-green-500 text-white rounded-full text-xs font-semibold">Tersedia</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($stock->stok_saat_ini > 0)
                                        <a href="{{ route('perpustakaan.pinjam') }}" class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition duration-200">
                                            Pinjam
                                        </a>
                                    @else
                                        <button disabled class="inline-block px-3 py-1 bg-gray-300 text-gray-600 text-xs font-semibold rounded cursor-not-allowed">
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bookStocks->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bookStocks->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Distribusi Kategori -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">📈 Distribusi Kategori</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($categoryStats as $category => $count)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="font-semibold text-gray-700">{{ $category ?: 'Lainnya' }}</div>
                    <div class="bg-blue-600 text-white px-4 py-1 rounded-full font-bold">{{ $count }}</div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Tidak ada data kategori</p>
            @endforelse
        </div>
    </div>
</div>

<style>
    body {
        background-color: #F9F6EE;
    }

    [type="search"]::-webkit-search-cancel-button,
    [type="search"]::-webkit-search-decoration {
        -webkit-appearance: none;
    }
</style>
@endsection

