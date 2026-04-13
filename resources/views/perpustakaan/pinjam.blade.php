@extends('layout.layout')

@section('title', 'Pinjam Buku')

@section('content')
<style>
    body {
        background-color: #F9F6EE;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        color: #334EAC;
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .book-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .book-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
    }

    .book-cover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        overflow: hidden;
        background-size: cover;
        background-position: center;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-cover.no-image {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 3rem;
    }

    .book-info {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .book-kategori {
        display: inline-block;
        background: #334EAC;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        margin-bottom: 10px;
        width: fit-content;
    }

    .book-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .book-stok {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 12px;
    }

    .stok-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .stok-badge.tersedia {
        background: #d4edda;
        color: #155724;
    }

    .stok-badge.terbatas {
        background: #fff3cd;
        color: #856404;
    }

    .stok-badge.habis {
        background: #f8d7da;
        color: #721c24;
    }

    .book-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-pinjam {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
    }

    .btn-pinjam:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    .btn-pinjam:disabled {
        background: #ccc;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination a,
    .pagination span {
        padding: 8px 12px;
        border: 1px solid #334EAC;
        border-radius: 4px;
        color: #334EAC;
        text-decoration: none;
    }

    .pagination a:hover {
        background: #334EAC;
        color: white;
    }

    .pagination .active span {
        background: #334EAC;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .empty-state-text {
        font-size: 1.2rem;
        color: #666;
    }
</style>

<div class="container">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="page-header">
        <h1>📚 Pinjam Buku</h1>
        <p style="color: #666;">Jelajahi koleksi buku dan pinjam buku favorit Anda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if($bookStocks->count() > 0)
        <div class="books-grid">
            @foreach($bookStocks as $stock)
                <div class="book-card">
                    <div class="book-cover @if(!$stock->cover_image) no-image @endif">
                        @if($stock->cover_image)
                            <img src="{{ asset('storage/' . $stock->cover_image) }}" alt="{{ $stock->judul_buku }}">
                        @else
                            📖
                        @endif
                    </div>
                    <div class="book-info">
                        <span class="book-kategori">{{ $stock->kategori }}</span>
                        <h3 class="book-title">{{ $stock->judul_buku }}</h3>
                        
                        <div class="book-stok">
                            Stok: <strong>{{ $stock->stok_saat_ini }}</strong>
                            <span class="stok-badge @if($stock->stok_saat_ini <= 0) habis @elseif($stock->stok_saat_ini <= 5) terbatas @else tersedia @endif">
                                @if($stock->stok_saat_ini <= 0)
                                    Habis
                                @elseif($stock->stok_saat_ini <= 5)
                                    Terbatas
                                @else
                                    Tersedia
                                @endif
                            </span>
                        </div>

                        <p style="font-size: 0.85rem; color: #999; margin-bottom: 12px;">
                            @if($stock->stok_saat_ini > 0)
                                ✓ Siap untuk dipinjam
                            @else
                                ✗ Tidak tersedia saat ini
                            @endif
                        </p>

                        <div class="book-actions">
                            @if($stock->stok_saat_ini > 0)
                                <button class="btn btn-pinjam" onclick="openPinjamModal({{ $stock->id }}, '{{ $stock->judul_buku }}')">
                                    Pinjam Sekarang
                                </button>
                            @else
                                <button class="btn btn-pinjam" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $bookStocks->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📖</div>
            <p class="empty-state-text">Tidak ada buku yang tersedia untuk dipinjam</p>
        </div>
    @endif
</div>

<!-- Modal Pinjam -->
<div id="pinjamModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; padding:20px;">
    <div style="background:white; max-width:500px; margin:100px auto; padding:30px; border-radius:12px;">
        <h2 id="modalTitle" style="color:#334EAC; margin-bottom:20px;">Pinjam Buku</h2>
        
        <form id="pinjamForm" method="POST" action="{{ route('perpustakaan.store') }}">
            @csrf
            
            <input type="hidden" id="bookStockId" name="book_stock_id">
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Judul Buku</label>
                <input type="text" id="judulBuku" readonly style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; background:#f5f5f5;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Tanggal Kembali Rencana *</label>
                <input type="date" name="tanggal_kembali_rencana" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" id="tanggalKembali">
                <small style="color:#666;">Minimal 1 hari dari hari ini</small>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Catatan (Opsional)</label>
                <textarea name="catatan" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; resize:vertical;" rows="3" placeholder="Contoh: Buku untuk tugas..."></textarea>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" style="flex:1; padding:12px; background:linear-gradient(135deg, #334EAC 0%, #7096D1 100%); color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                    Pinjam Buku
                </button>
                <button type="button" onclick="closePinjamModal()" style="flex:1; padding:12px; background:#ddd; color:#333; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPinjamModal(id, judul) {
        document.getElementById('bookStockId').value = id;
        document.getElementById('judulBuku').value = judul;
        
        // Set minimal date ke besok
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('tanggalKembali').min = tomorrow.toISOString().split('T')[0];
        document.getElementById('tanggalKembali').value = tomorrow.toISOString().split('T')[0];
        
        document.getElementById('pinjamModal').style.display = 'block';
    }

    function closePinjamModal() {
        document.getElementById('pinjamModal').style.display = 'none';
    }

    // Close modal saat click di luar
    window.onclick = function(event) {
        const modal = document.getElementById('pinjamModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection
