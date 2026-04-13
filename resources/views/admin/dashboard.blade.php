@extends('layout.admin-layout')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #F9F6EE;
        min-height: 100vh;
    }

    .navbar-top {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        padding: 0;
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.15);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navbar-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: white !important;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .navbar-logo {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .navbar-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 40px;
        flex: 1;
        margin-left: 60px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .navbar-item a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s ease;
        padding: 8px 12px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .navbar-item a:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #FFF9F0;
    }

    .navbar-item a.active {
        background: rgba(255, 255, 255, 0.25);
        border-bottom: 2px solid #FFF9F0;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-left: auto;
    }

    .navbar-user {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        font-weight: 500;
    }

    .navbar-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .navbar-divider {
        width: 1px;
        height: 30px;
        background: rgba(255, 255, 255, 0.2);
    }

    .btn-navbar-logout {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-navbar-logout:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .hero-section {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        padding: 80px 40px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(51, 78, 172, 0.2);
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
        letter-spacing: -1px;
    }

    .hero-section p {
        font-size: 1.3rem;
        margin-bottom: 10px;
        opacity: 0.95;
    }

    .container-modern {
        max-width: 1200px;
        margin: 0 auto;
        padding: 50px 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(51, 78, 172, 0.1);
        transition: all 0.3s ease;
        border-top: 4px solid;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(51, 78, 172, 0.15);
    }

    .stat-card h6 {
        color: #7096D1;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin: 15px 0;
    }

    .stat-card.users {
        border-top-color: #334EAC;
    }

    .stat-card.users .stat-number {
        color: #334EAC;
    }

    .stat-card.books {
        border-top-color: #4CAF50;
    }

    .stat-card.books .stat-number {
        color: #4CAF50;
    }

    .stat-card.loans {
        border-top-color: #FFD700;
    }

    .stat-card.loans .stat-number {
        color: #FFD700;
    }

    .stat-card.returned {
        border-top-color: #2196F3;
    }

    .stat-card.returned .stat-number {
        color: #2196F3;
    }

    .stat-card.lost {
        border-top-color: #F44336;
    }

    .stat-card.lost .stat-number {
        color: #F44336;
    }

    .stat-card.limited {
        border-top-color: #FF9800;
    }

    .stat-card.limited .stat-number {
        color: #FF9800;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #334EAC;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(51, 78, 172, 0.1);
        border: 1px solid rgba(112, 150, 209, 0.1);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        padding: 20px 30px;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .card-body {
        padding: 30px;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
    }

    .table th {
        background-color: #F5F7FF;
        font-weight: 600;
        color: #334EAC;
        padding: 14px 16px;
        text-align: left;
    }

    .table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(112, 150, 209, 0.1);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #F9FAFF;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-kelas {
        background-color: #E3F2FD;
        color: #334EAC;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(51, 78, 172, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-outline-modern {
        background: white;
        color: #334EAC;
        border: 2px solid #334EAC;
        padding: 10px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-outline-modern:hover {
        background: #334EAC;
        color: white;
    }

    .pagination {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .navbar-menu {
            display: none;
        }

        .navbar-content {
            height: 60px;
        }

        .navbar-brand {
            font-size: 1.2rem;
        }

        .navbar-brand span {
            display: none;
        }

        .hero-section h1 {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .section-title {
            font-size: 1.4rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary-modern,
        .btn-outline-modern {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Navbar -->
<nav class="navbar-top">
    <div class="navbar-content">
        <!-- Branding -->
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <div class="navbar-logo">
                <img src="{{ asset('asset/logosmkkpng.png') }}" alt="Logo AK Nusa Bangsa">
            </div>
            <span>SMKAKNB</span>
        </a>

        <!-- Navigation Menu -->
        <ul class="navbar-menu">
            <li class="navbar-item">
                <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) active @endif">
                    <i class="bi bi-house-fill"></i> Dashboard
                </a>
            </li>
            <li class="navbar-item">
                <a href="{{ route('admin.users') }}" class="@if(request()->routeIs('admin.users')) active @endif">
                    <i class="bi bi-people-fill"></i> Pengguna
                </a>
            </li>
        </ul>

        <!-- Right Section -->
        <div class="navbar-right">
            <!-- User Info -->
            <div class="navbar-user">
                <div class="navbar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span style="display: none; max-width: 120px; overflow: hidden; text-overflow: ellipsis;">
                    {{ auth()->user()->name }}
                </span>
            </div>

            <!-- Divider -->
            <div class="navbar-divider"></div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">
                @csrf
                <button type="submit" class="btn-navbar-logout" title="Logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <h1>👨‍💼 Admin Dashboard</h1>
    <p><strong>{{ auth()->user()->name }}</strong></p>
    <p>Kelola sistem perpustakaan digital dengan mudah</p>
</div>

<!-- Main Content -->
<div class="container-modern">
    <!-- User Statistics Section -->
    <div style="margin-bottom: 50px;">
        <h2 class="section-title">
            <i class="bi bi-people-circle" style="color: #334EAC;"></i> Statistik Pengguna
        </h2>
        <div>
            
        </div>
        <div class="stats-grid">
            <div class="stat-card users">
                <h6>👥 Total Pengguna</h6>
                <div class="stat-number">{{ $totalUsers }}</div>
                <small style="color: #7096D1;">Siswa terdaftar</small>
            </div>
            <div class="stat-card users">
                <h6>🔑 Total Admin</h6>
                <div class="stat-number">{{ $totalAdmin }}</div>
                <small style="color: #7096D1;">Administrator</small>
            </div>
            <div class="stat-card users">
                <h6>📚 Kelas X</h6>
                <div class="stat-number">{{ $kelasX }}</div>
                <small style="color: #7096D1;">Siswa</small>
            </div>
            <div class="stat-card users">
                <h6>📚 Kelas XI</h6>
                <div class="stat-number">{{ $kelasXI }}</div>
                <small style="color: #7096D1;">Siswa</small>
            </div>
            <div class="stat-card users">
                <h6>📚 Kelas XII</h6>
                <div class="stat-number">{{ $kelasXII }}</div>
                <small style="color: #7096D1;">Siswa</small>
            </div>
        </div>
    </div>

    <!-- Book Statistics Section -->
    <div style="margin-bottom: 50px;">
        <h2 class="section-title">
            <i class="bi bi-book" style="color: #4CAF50;"></i> Statistik Koleksi Buku
        </h2>
        <div class="stats-grid">
            <div class="stat-card books">
                <h6>📖 Total Judul</h6>
                <div class="stat-number">{{ $totalBooks }}</div>
                <small style="color: #7096D1;">Buku tersedia</small>
            </div>
            <div class="stat-card books">
                <h6>Total Stok</h6>
                <div class="stat-number">{{ $totalStok }}</div>
                <small style="color: #7096D1;">Eksemplar</small>
            </div>
            <div class="stat-card limited">
                <h6>⚠️ Stok Terbatas</h6>
                <div class="stat-number">{{ $bukuTerbatas }}</div>
                <small style="color: #7096D1;">≤ 5 eksemplar</small>
            </div>
            <div class="stat-card lost">
                <h6>🚫 Habis</h6>
                <div class="stat-number">{{ $bukuHabis }}</div>
                <small style="color: #7096D1;">Tidak tersedia</small>
            </div>
        </div>
    </div>

    <!-- Loan Statistics Section -->
    <div style="margin-bottom: 50px;">
        <h2 class="section-title">
            <i class="bi bi-clock-history" style="color: #FFD700;"></i> Statistik Peminjaman
        </h2>
        <div class="stats-grid">
            <div class="stat-card loans">
                <h6>📤 Sedang Dipinjam</h6>
                <div class="stat-number">{{ $peminjamanAktif }}</div>
                <small style="color: #7096D1;">Aktif</small>
            </div>
            <div class="stat-card returned">
                <h6>✅ Dikembalikan</h6>
                <div class="stat-number">{{ $peminjamanDikembalikan }}</div>
                <small style="color: #7096D1;">Selesai</small>
            </div>
            <div class="stat-card lost">
                <h6>❌ Hilang</h6>
                <div class="stat-number">{{ $peminjamanHilang }}</div>
                <small style="color: #7096D1;">Hilang/Rusak</small>
            </div>
            <div class="stat-card users">
                <h6>📊 Total Peminjaman</h6>
                <div class="stat-number">{{ $totalPeminjaman }}</div>
                <small style="color: #7096D1;">Semua status</small>
            </div>
        </div>
    </div>

    <!-- Recent Users Section -->
    <div class="card">
        <div class="card-header-modern">
            <i class="bi bi-person-lines-fill"></i> Daftar Pengguna Terbaru
        </div>
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Nama</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 12%;">Kelas</th>
                        <th style="width: 20%;">Jurusan</th>
                        <th style="width: 18%;">Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td><small>{{ $user->email }}</small></td>
                            <td><span class="badge badge-kelas">{{ $user->kelas }}</span></td>
                            <td>
                                <small>
                                    @switch($user->jurusan)
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
                                            {{ $user->jurusan }}
                                    @endswitch
                                </small>
                            </td>
                            <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> Tidak ada data pengguna
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($users->hasPages())
            <div style="padding: 20px 30px; border-top: 1px solid rgba(112, 150, 209, 0.1);">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.users') }}" class="btn-primary-modern">
            <i class="bi bi-people-fill"></i> Lihat Semua Pengguna
        </a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline" style="width: 100%; max-width: fit-content;">
            @csrf
            <button type="submit" class="btn-outline-modern" style="width: 100%;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <!-- Info Alert -->
    <div style="background: linear-gradient(135deg, rgba(51, 78, 172, 0.05), rgba(112, 150, 209, 0.05)); border-left: 4px solid #7096D1; border-radius: 12px; padding: 25px; margin-top: 40px;">
        <h5 style="color: #334EAC; font-weight: 700; margin-bottom: 10px;">
            <i class="bi bi-lightbulb"></i> Tips Admin
        </h5>
        <p style="color: #555; margin: 0;">
            📊 Pantau statistik perpustakaan secara berkala untuk memastikan stok buku terjaga dengan baik. 
            👥 Kelola pengguna dan pastikan data tetap akurat. 
            🔒 Gunakan Logout untuk menutup session dengan aman.
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
