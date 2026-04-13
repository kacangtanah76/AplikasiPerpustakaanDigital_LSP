@extends('layout.layout')

@section('title', 'Dashboard')

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
    }

    .hero-section {
        background: linear-gradient(135deg, rgba(51, 78, 172, 0.85) 0%, rgba(112, 150, 209, 0.85) 100%), url('{{ asset('asset/gambarSekolah.jpeg') }}') center/cover no-repeat;
        color: white;
        padding: 80px 40px;
        border-radius: 0;
        margin-bottom: 50px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(51, 78, 172, 0.2);
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
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

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .modern-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(51, 78, 172, 0.1);
        transition: all 0.3s ease;
        border: 1px solid rgba(112, 150, 209, 0.1);
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(51, 78, 172, 0.15);
    }

    .modern-card h2 {
        color: #334EAC;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modern-card i {
        font-size: 1.8rem;
        color: #7096D1;
    }

    .info-row {
        margin-bottom: 20px;
    }

    .info-label {
        color: #7096D1;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #334EAC;
        font-size: 1.2rem;
        font-weight: 600;
        margin-top: 5px;
    }

    .badge-role {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 5px;
    }

    .badge-user {
        background-color: #E3F2FD;
        color: #334EAC;
    }

    .badge-admin {
        background-color: #FFF3E0;
        color: #F57C00;
    }

    .divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, #7096D1, transparent);
        margin: 30px 0;
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
        display: inline-block;
        text-decoration: none;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(51, 78, 172, 0.3);
        color: white;
    }

    .btn-logout {
        background: white;
        color: #334EAC;
        border: 2px solid #334EAC;
    }

    .btn-logout:hover {
        background: #334EAC;
        color: white;
    }

    .alert-info-modern {
        background: linear-gradient(135deg, rgba(112, 150, 209, 0.1), rgba(112, 150, 209, 0.05));
        border-left: 4px solid #7096D1;
        border-radius: 12px;
        padding: 25px;
        margin-top: 40px;
    }

    .alert-info-modern h5 {
        color: #334EAC;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .alert-info-modern p {
        color: #555;
        margin: 0;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .profile-item {
        background: linear-gradient(135deg, rgba(51, 78, 172, 0.05), rgba(112, 150, 209, 0.05));
        padding: 20px;
        border-radius: 15px;
        border: 1px solid rgba(112, 150, 209, 0.2);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .container-modern {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
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
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                    <i class="bi bi-house-fill"></i> Beranda
                </a>
            </li>
            <li class="navbar-item">
                <!--  -->
                    <i class="bi bi-people-fill"></i> Pengguna
                </a>
            </li>
            <li class="navbar-item">
                <a href="#" onclick="return false;">
                    <i class="bi bi-book-fill"></i> Koleksi
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
    <h1>Selamat Datang! 👋</h1>
        <p><strong>{{ auth()->user()->name }}</strong></p>
        <p style="font-size: 1.1rem; opacity: 0.9;">
        @if(auth()->user()->role === 'admin')
            Kelola sistem perpustakaan digital dengan mudah
        @else
            Jelajahi koleksi buku dan kelola peminjaman Anda
        @endif
        </p>
</div>

<!-- Main Content -->
<div class="container-modern py-5">
    <!-- User Dashboard Section -->
    @if(auth()->user()->role !== 'admin')
        <!-- User Statistics -->
        <div class="cards-grid" style="margin-bottom: 40px;">
            <div class="modern-card" style="border-top: 4px solid #FFD700;">
                <h2 style="color: #FFD700;">
                    <i class="bi bi-hourglass-split"></i> Sedang Dipinjam
                </h2>
                <div style="font-size: 3rem; font-weight: 700; color: #FFD700; margin: 20px 0;">
                    {{ $activeLoanCount ?? 0 }}
                </div>
                <a href="{{ route('perpustakaan.riwayat') }}" class="btn btn-primary-modern" style="background: linear-gradient(135deg, #FFD700, #FFA500);">
                    Lihat Detail
                </a>
            </div>

            <div class="modern-card" style="border-top: 4px solid #4CAF50;">
                <h2 style="color: #4CAF50;">
                    <i class="bi bi-check-circle"></i> Dikembalikan
                </h2>
                <div style="font-size: 3rem; font-weight: 700; color: #4CAF50; margin: 20px 0;">
                    {{ $returnedLoanCount ?? 0 }}
                </div>
                <a href="{{ route('perpustakaan.riwayat') }}" class="btn btn-primary-modern" style="background: linear-gradient(135deg, #4CAF50, #45a049);">
                    Lihat Riwayat
                </a>
            </div>

            <div class="modern-card" style="border-top: 4px solid #F44336;">
                <h2 style="color: #F44336;">
                    <i class="bi bi-exclamation-circle"></i> Hilang
                </h2>
                <div style="font-size: 3rem; font-weight: 700; color: #F44336; margin: 20px 0;">
                    {{ $lostLoanCount ?? 0 }}
                </div>
                <a href="{{ route('perpustakaan.riwayat') }}" class="btn btn-primary-modern" style="background: linear-gradient(135deg, #F44336, #da190b);">
                    Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="modern-card" style="margin-bottom: 40px;">
            <h2>
                <i class="bi bi-lightning-fill"></i> Akses Cepat
            </h2>
            <div class="action-buttons" style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('perpustakaan.pinjam') }}" class="btn btn-primary-modern" style="flex: 1; min-width: 200px; text-align: center;">
                    <i class="bi bi-plus-circle"></i> Pinjam Buku Baru
                </a>
                <a href="{{ route('perpustakaan.riwayat') }}" class="btn btn-primary-modern" style="flex: 1; min-width: 200px; text-align: center; background: linear-gradient(135deg, #7096D1 0%, #334EAC 100%);">
                    <i class="bi bi-clock-history"></i> Lihat Riwayat
                </a>
                <a href="{{ route('perpustakaan.pinjam') }}" class="btn btn-primary-modern" style="flex: 1; min-width: 200px; text-align: center; background: linear-gradient(135deg, #9C27B0, #7B1FA2);">
                    <i class="bi bi-bookmark"></i> koleksi Buku
                </a>
            </div>
        </div>
    @endif

    <!-- Profile Card -->
    <div class="cards-grid">
        <div class="modern-card">
            <h2>
                <i class="bi bi-person-circle"></i> Profil Anda
            </h2>

            <div class="profile-grid">
                <div class="profile-item">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ auth()->user()->name }}</div>
                </div>
                <div class="profile-item">
                    <div class="info-label">Email</div>
                    <div class="info-value" style="font-size: 0.95rem;">{{ auth()->user()->email }}</div>
                </div>
                <div class="profile-item">
                    <div class="info-label">Role</div>
                    <div>
                        @if (auth()->user()->role === 'admin')
                            <span class="badge-role badge-admin">Admin</span>
                        @else
                            <span class="badge-role badge-user">Student</span>
                        @endif
                    </div>
                </div>
                @if (auth()->user()->role !== 'admin')
                <div class="profile-item">
                    <div class="info-label">Kelas</div>
                    <div class="info-value">{{ auth()->user()->kelas }}</div>
                </div>
                <div class="profile-item">
                    <div class="info-label">Jurusan</div>
                    <div class="info-value" style="font-size: 0.95rem;">
                        @switch(auth()->user()->jurusan)
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
                                {{ auth()->user()->jurusan }}
                        @endswitch
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Access Card -->
        <div class="modern-card">
            <h2>
                @if (auth()->user()->role === 'admin')
                    <i class="bi bi-shield-check"></i> Dashboard Admin
                @else
                    <i class="bi bi-info-circle"></i> Informasi Akses
                @endif
            </h2>

            @if (auth()->user()->role === 'admin')
                <p style="color: #555; line-height: 1.6; margin-bottom: 25px;">
                    Anda memiliki akses penuh untuk mengelola sistem, melihat semua pengguna, dan mengonfigurasi aplikasi perpustakaan digital.
                </p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary-modern">
                    <i class="bi bi-speedometer2"></i> Akses Admin Dashboard
                </a>
            @else
                <p style="color: #555; line-height: 1.6; margin-bottom: 25px;">
                    Sebagai pengguna/siswa, Anda dapat mengakses konten perpustakaan digital dan mengelola peminjaman buku dengan mudah.
                </p>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('perpustakaan.pinjam') }}" class="btn btn-primary-modern">
                        <i class="bi bi-book"></i> Mulai Meminjam
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Warning for Users -->
    @if(auth()->user()->role !== 'admin')
    <div class="alert-info-modern" style="margin-top: 40px; border-left-color: #4CAF50; background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(76, 175, 80, 0.05));">
        <h5 style="color: #2E7D32;">
            <i class="bi bi-info-circle"></i> Panduan Penggunaan
        </h5>
        <p>
            📚 Anda dapat meminjam buku dari koleksi kami yang lengkap. Pastikan untuk mengembalikan buku sesuai dengan tanggal yang sudah ditentukan untuk menghindari denda keterlambatan sebesar Rp 5.000 per hari.
        </p>
    </div>
    @endif

    <!-- Info Alert -->
    <div class="alert-info-modern">
        <h5>
            <i class="bi bi-lightbulb"></i> Keamanan Akun
        </h5>
        <p>
            🔒 Data profil Anda telah tersimpan dengan aman di sistem perpustakaan digital. Untuk menjaga keamanan akun, 
            jangan bagikan email dan password Anda kepada siapa pun. Gunakan tombol Logout untuk keluar dari aplikasi.
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
