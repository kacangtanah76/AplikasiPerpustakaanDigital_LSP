@extends('layout.layout')

@section('title', 'Riwayat Peminjaman')

@section('content')
<style>
    body {
        background-color: #F9F6EE;
    }

    .container {
        max-width: 1000px;
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

    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 10px 20px;
        border: 2px solid #ddd;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        color: #666;
        transition: all 0.3s;
    }

    .filter-btn.active {
        border-color: #334EAC;
        background: #334EAC;
        color: white;
    }

    .peminjaman-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .peminjaman-item {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        transition: all 0.3s;
        gap: 20px;
    }

    .peminjaman-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .peminjaman-thumbnail {
        width: 100px;
        height: 140px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .peminjaman-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .peminjaman-info {
        flex: 1;
    }

    .peminjaman-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .peminjaman-kategori {
        display: inline-block;
        background: #334EAC;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .peminjaman-details {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
    }

    .peminjaman-detail-item {
        display: inline-block;
        margin-right: 20px;
        margin-bottom: 5px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-dipinjam {
        background: #fff3cd;
        color: #856404;
    }

    .status-dikembalikan {
        background: #d4edda;
        color: #155724;
    }

    .status-hilang {
        background: #f8d7da;
        color: #721c24;
    }

    .peminjaman-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
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

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
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

    .denda-info {
        font-weight: 600;
        color: #dc3545;
    }

    .terlambat-warning {
        padding: 10px;
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        border-radius: 4px;
        margin-top: 10px;
    }
</style>

<div class="container">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="page-header">
        <h1>📋 Riwayat Peminjaman</h1>
        <p style="color: #666;">Kelola peminjaman buku Anda</p>
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

    @if($peminjaman->count() > 0)
        <div class="peminjaman-list">
            @foreach($peminjaman as $pinjam)
                <div class="peminjaman-item">
                    <div class="peminjaman-info">
                        <div class="peminjaman-title">{{ $pinjam->judul_buku }}</div>
                        <div>
                            <span class="peminjaman-kategori">{{ $pinjam->kategori }}</span>
                            <span class="status-badge status-{{ $pinjam->status }}">{{ ucfirst($pinjam->status) }}</span>
                        </div>
                        <div class="peminjaman-details">
                            <div class="peminjaman-detail-item">
                                📅 Pinjam: <strong>{{ $pinjam->tanggal_peminjaman->format('d M Y') }}</strong>
                            </div>
                            <div class="peminjaman-detail-item">
                                📆 Kembali: <strong>{{ $pinjam->tanggal_kembali_rencana->format('d M Y') }}</strong>
                            </div>
                        </div>

                        @if($pinjam->status === 'dikembalikan' && $pinjam->denda > 0)
                            <div style="margin-top: 10px;">
                                <span class="denda-info">💰 Denda: Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        @if($pinjam->status === 'dipinjam' && $pinjam->isTerlambat())
                            <div class="terlambat-warning">
                                ⚠️ Peminjaman Anda sudah terlambat {{ $pinjam->getHariTerlambat() }} hari! 
                                <br/>💰 Denda sementara: <strong>Rp {{ number_format($pinjam->calculateDenda(), 0, ',', '.') }}</strong> (Rp 5000/hari)
                                <br/>Segera kembalikan untuk menghindari denda yang terus bertambah.
                            </div>
                        @endif
                    </div>

                    <div class="peminjaman-actions">
                        <a href="{{ route('perpustakaan.detail', $pinjam->id) }}" class="btn btn-secondary">
                            📄 Detail
                        </a>

                        @if($pinjam->status === 'dipinjam')
                            <form method="POST" action="{{ route('perpustakaan.return', $pinjam->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pengembalian buku?')">
                                    ✓ Kembalikan
                                </button>
                            </form>

                            <button type="button" class="btn btn-danger" onclick="openLostModal({{ $pinjam->id }})">
                                ✗ Lapor Hilang
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $peminjaman->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📚</div>
            <p class="empty-state-text">Anda belum meminjam buku apapun</p>
            <a href="{{ route('perpustakaan.pinjam') }}" style="display:inline-block; margin-top:20px; padding:12px 28px; background:linear-gradient(135deg, #334EAC 0%, #7096D1 100%); color:white; text-decoration:none; border-radius:6px; font-weight:600;">
                Mulai Pinjam Buku
            </a>
        </div>
    @endif
</div>

<!-- Modal Lapor Hilang -->
<div id="lostModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; padding:20px;">
    <div style="background:white; max-width:500px; margin:100px auto; padding:30px; border-radius:12px;">
        <h2 style="color:#334EAC; margin-bottom:20px;">Lapor Buku Hilang</h2>
        
        <form id="lostForm" method="POST">
            @csrf
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Catatan Kehilangan *</label>
                <textarea name="catatan" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; resize:vertical;" rows="4" placeholder="Jelaskan bagaimana buku hilang..."></textarea>
                <small style="color:#666;">Minimal 10 karakter</small>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-danger" style="flex:1; padding:12px;">
                    Laporkan Hilang
                </button>
                <button type="button" onclick="closeLostModal()" style="flex:1; padding:12px; background:#ddd; color:#333; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openLostModal(id) {
        document.getElementById('lostForm').action = `/perpustakaan/hilang/${id}`;
        document.getElementById('lostModal').style.display = 'block';
    }

    function closeLostModal() {
        document.getElementById('lostModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('lostModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection
