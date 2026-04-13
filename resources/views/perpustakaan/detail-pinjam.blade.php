@extends('layout.layout')

@section('title', 'Detail Peminjaman Buku')

@section('content')
<style>
    body {
        background-color: #F9F6EE;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        color: #334EAC;
        font-size: 2rem;
        margin: 0;
    }

    .breadcrumb {
        padding: 0;
        margin: 0 0 30px 0;
        background: transparent;
        font-size: 0.95rem;
    }

    .breadcrumb a {
        color: #334EAC;
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
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

    .detail-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .detail-section {
        margin-bottom: 30px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        color: #334EAC;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #7096D1;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-row.full {
        grid-template-columns: 1fr;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #7096D1;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 1.1rem;
        color: #333;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        width: fit-content;
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

    .kategori-badge {
        display: inline-block;
        background: #334EAC;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .denda-box {
        background: #fff3cd;
        border: 2px solid #ffc107;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
    }

    .denda-label {
        color: #856404;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .denda-amount {
        color: #dc3545;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .terlambat-warning {
        background: #f8d7da;
        border-left: 4px solid #dc3545;
        padding: 15px;
        border-radius: 6px;
        margin: 20px 0;
        color: #721c24;
    }

    .catatan-box {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        color: #555;
        line-height: 1.6;
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 25px;
        position: relative;
    }

    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 15px;
        top: 40px;
        width: 2px;
        height: calc(100% + 15px);
        background: #ddd;
    }

    .timeline-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #334EAC;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 20px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .timeline-content {
        flex: 1;
        padding-top: 5px;
    }

    .timeline-date {
        font-size: 0.9rem;
        color: #666;
        font-weight: 600;
    }

    .timeline-description {
        color: #555;
        font-size: 1rem;
        margin-top: 5px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(51, 78, 172, 0.3);
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .info-box {
        background: linear-gradient(135deg, rgba(51, 78, 172, 0.05), rgba(112, 150, 209, 0.05));
        border: 1px solid #7096D1;
        border-radius: 10px;
        padding: 15px;
    }

    .info-box-title {
        font-size: 0.85rem;
        color: #7096D1;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .info-box-value {
        font-size: 1.2rem;
        color: #334EAC;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .detail-row {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>

<div class="container">
<div class="container">
    <!-- Navigation -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
        <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
            <i class="bi bi-house-door"></i> Beranda
        </a>
        <a href="{{ route('perpustakaan.riwayat') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('perpustakaan.riwayat') }}">← Kembali ke Riwayat</a>
    </div>

    <!-- Header -->
    <div class="page-header">
        <h1>📖 Detail Peminjaman</h1>
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

    <div class="detail-card">
        <!-- Section 1: Informasi Buku -->
        <div class="detail-section">
            <div class="section-title">📚 Informasi Buku</div>
            
            <div class="detail-row">
                <div class="detail-item">
                    <span class="detail-label">Judul Buku</span>
                    <span class="detail-value">{{ $peminjaman->judul_buku }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kategori</span>
                    <span class="kategori-badge">{{ $peminjaman->kategori }}</span>
                </div>
            </div>
        </div>

        <!-- Section 2: Status Peminjaman -->
        <div class="detail-section">
            <div class="section-title">📋 Status Peminjaman</div>
            
            <div class="detail-row">
                <div class="detail-item">
                    <span class="detail-label">Status Saat Ini</span>
                    <span class="status-badge status-{{ $peminjaman->status }}">
                        @switch($peminjaman->status)
                            @case('dipinjam')
                                ⏳ Sedang Dipinjam
                                @break
                            @case('dikembalikan')
                                ✓ Dikembalikan
                                @break
                            @case('hilang')
                                ✗ Hilang
                                @break
                            @default
                                {{ ucfirst($peminjaman->status) }}
                        @endswitch
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Permintaan pada</span>
                    <span class="detail-value">{{ $peminjaman->tanggal_peminjaman->format('d M Y H:i') }}</span>
                </div>
            </div>

            @if($peminjaman->status === 'dipinjam' && $peminjaman->isTerlambat())
                <div class="terlambat-warning">
                    ⚠️ <strong>Perhatian!</strong> Peminjaman Anda sudah melewati tanggal rencana pengembalian. 
                    Segera kembalikan untuk menghindari denda keterlambatan.
                </div>
            @endif
        </div>

        <!-- Section 3: Jadwal Pengembalian -->
        <div class="detail-section">
            <div class="section-title">📅 Jadwal Pengembalian</div>
            
            <div class="timeline">
                <!-- Peminjaman -->
                <div class="timeline-item">
                    <div class="timeline-dot">📍</div>
                    <div class="timeline-content">
                        <div class="timeline-date">Tanggal Peminjaman</div>
                        <div class="timeline-description">{{ $peminjaman->tanggal_peminjaman->format('l, d M Y H:i') }}</div>
                    </div>
                </div>

                <!-- Rencana Kembali -->
                <div class="timeline-item">
                    <div class="timeline-dot">🎯</div>
                    <div class="timeline-content">
                        <div class="timeline-date">Rencana Pengembalian</div>
                        <div class="timeline-description">{{ $peminjaman->tanggal_kembali_rencana->format('l, d M Y') }}</div>
                        @if($peminjaman->status === 'dipinjam')
                            <div style="margin-top: 5px; font-size: 0.9rem; color: #666;">
                                📆 
                                @if($peminjaman->isTerlambat())
                                    <span style="color: #dc3545; font-weight: 600;">Sudah terlambat!</span>
                                @else
                                    <span style="color: #28a745;">{{ now()->diffInDays($peminjaman->tanggal_kembali_rencana) }} hari lagi</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kembali Aktual (jika sudah dikembalikan) -->
                @if($peminjaman->tanggal_kembali_aktual)
                    <div class="timeline-item">
                        <div class="timeline-dot">✓</div>
                        <div class="timeline-content">
                            <div class="timeline-date">Tanggal Pengembalian Aktual</div>
                            <div class="timeline-description">{{ $peminjaman->tanggal_kembali_aktual->format('l, d M Y H:i') }}</div>
                            @if($peminjaman->isTerlambat())
                                <div style="margin-top: 5px; font-size: 0.9rem; color: #dc3545; font-weight: 600;">
                                    ⚠️ Terlambat {{ $peminjaman->tanggal_kembali_aktual->diffInDays($peminjaman->tanggal_kembali_rencana) }} hari
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section 4: Denda (jika ada) -->
        @if($peminjaman->denda > 0 || ($peminjaman->status === 'dipinjam' && $peminjaman->isTerlambat()))
            <div class="detail-section">
                <div class="section-title">💰 Informasi Denda</div>
                
                @if($peminjaman->status === 'dipinjam' && $peminjaman->isTerlambat())
                    <div class="denda-box">
                        <div class="denda-label">Denda Sementara (Belum Dikembalikan)</div>
                        <div class="denda-amount">Rp {{ number_format($peminjaman->calculateDenda(), 0, ',', '.') }}</div>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #856404;">
                            📊 Hari Keterlambatan: <strong>{{ $peminjaman->getHariTerlambat() }} hari</strong>
                            <br/>💵 Tarif: <strong>Rp 5.000 per hari</strong>
                            <br/>⚠️ Denda akan terus bertambah setiap hari sampai buku dikembalikan
                        </div>
                    </div>
                @elseif($peminjaman->status === 'dikembalikan' && $peminjaman->denda > 0)
                    <div class="denda-box">
                        <div class="denda-label">Denda yang Ditetapkan</div>
                        <div class="denda-amount">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</div>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #856404;">
                            📊 Hari Keterlambatan: <strong>{{ $peminjaman->getHariTerlambat() }} hari</strong>
                            <br/>💵 Tarif: <strong>Rp 5.000 per hari</strong>
                        </div>
                    </div>
                @else
                    <div class="denda-box">
                        <div class="denda-label">Status Denda</div>
                        <div style="font-size: 1.5rem; color: #28a745; font-weight: 600; margin-top: 10px;">
                            ✓ Tidak Ada Denda
                        </div>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #156804;">
                            Pengembalian tepat waktu atau lebih awal - tidak ada keterlambatan 🎉
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Section 5: Catatan -->
        @if($peminjaman->catatan)
            <div class="detail-section">
                <div class="section-title">📝 Catatan</div>
                <div class="catatan-box">
                    {{ $peminjaman->catatan }}
                </div>
            </div>
        @endif

        <!-- Section 6: Informasi Pengguna -->
        <div class="detail-section">
            <div class="section-title">👤 Informasi Pengguna</div>
            
            <div class="detail-row">
                <div class="detail-item">
                    <span class="detail-label">Nama</span>
                    <span class="detail-value">{{ $peminjaman->user->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $peminjaman->user->email }}</span>
                </div>
            </div>

            @if($peminjaman->user->role === 'user')
                <div class="detail-row">
                    <div class="detail-item">
                        <span class="detail-label">Kelas</span>
                        <span class="detail-value">{{ $peminjaman->user->kelas }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jurusan</span>
                        <span class="detail-value">
                            @switch($peminjaman->user->jurusan)
                                @case('AnalisKimia')
                                    Analis Kimia
                                    @break
                                @case('Farmasi')
                                    Farmasi
                                    @break
                                @case('PPLG')
                                    PPLG
                                    @break
                                @default
                                    {{ $peminjaman->user->jurusan }}
                            @endswitch
                        </span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('perpustakaan.riwayat') }}" class="btn btn-secondary">
                ← Kembali ke Riwayat
            </a>

            @if($peminjaman->status === 'dipinjam')
                <form method="POST" action="{{ route('perpustakaan.return', $peminjaman->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pengembalian buku?')">
                        ✓ Kembalikan Buku
                    </button>
                </form>

                <button type="button" class="btn btn-danger" onclick="openLostModal()">
                    ✗ Lapor Hilang
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Lapor Hilang -->
<div id="lostModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; padding:20px;">
    <div style="background:white; max-width:500px; margin:100px auto; padding:30px; border-radius:12px;">
        <h2 style="color:#334EAC; margin-bottom:20px;">Lapor Buku Hilang</h2>
        
        <form id="lostForm" method="POST" action="{{ route('perpustakaan.lost', $peminjaman->id) }}">
            @csrf
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Catatan Kehilangan *</label>
                <textarea name="catatan" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; resize:vertical;" rows="4" placeholder="Jelaskan bagaimana buku hilang..."></textarea>
                <small style="color:#666;">Minimal 10 karakter</small>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" style="flex:1; padding:12px; background:#dc3545; color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
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
    function openLostModal() {
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
