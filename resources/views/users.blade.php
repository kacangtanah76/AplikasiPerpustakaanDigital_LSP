@extends('layout.layout')

@section('title', 'Daftar Pengguna Terdaftar')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #FFF9F0;
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
        font-size: 2rem;
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

    .container-modern {
        max-width: 1200px;
        margin: 0 auto;
        padding: 50px 20px;
    }

    .page-header {
        margin-bottom: 50px;
    }

    .page-header h1 {
        color: #334EAC;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #7096D1;
        font-size: 1.1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(51, 78, 172, 0.1);
        border-left: 4px solid #7096D1;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(51, 78, 172, 0.15);
    }

    .stat-number {
        color: #334EAC;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #7096D1;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .card {
        border-radius: 15px;
        background-color: white;
        box-shadow: 0 4px 20px rgba(51, 78, 172, 0.1);
        border: 1px solid rgba(112, 150, 209, 0.1);
        margin-bottom: 30px;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 15px 15px 0 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background-color: #F5F7FF;
    }

    .table th {
        color: #334EAC;
        font-weight: 600;
        border: none;
        padding: 16px;
    }

    .table tbody tr:hover {
        background-color: #F9FAFF;
    }

    .table td {
        padding: 14px 16px;
        border: none;
        vertical-align: middle;
    }

    .badge-user {
        background: linear-gradient(135deg, #51CF66 0%, #69DB7C 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-admin {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF8787 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(51, 78, 172, 0.3);
        color: white;
        text-decoration: none;
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

        .page-header h1 {
            font-size: 1.8rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<!-- Navbar -->
<nav class="navbar-top">
    <div class="navbar-content">
        <!-- Branding -->
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <span class="navbar-logo">📚</span>
            <span>SmartLib</span>
        </a>

        <!-- Navigation Menu -->
        <ul class="navbar-menu">
            <li class="navbar-item">
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                    <i class="bi bi-house-fill"></i> Dashboard
                </a>
            </li>
            <li class="navbar-item">
                <a href="{{ route('list.users') }}" class="@if(request()->routeIs('list.users')) active @endif">
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
            </div>

            <!-- Divider -->
            <div class="navbar-divider"></div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">
                @csrf
                <button type="submit" class="btn-navbar-logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container-modern">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Daftar Pengguna Terdaftar</h1>
        <p>Kelola semua pengguna yang terdaftar di sistem perpustakaan</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $studentCount }}</div>
            <div class="stat-label">Siswa</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $adminCount }}</div>
            <div class="stat-label">Admin</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $totalUsers + $adminCount }}</div>
            <div class="stat-label">Total Akun</div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header-modern">
            <i class="bi bi-table"></i> Daftar Pengguna
        </div>
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 12%;">Kelas</th>
                        <th style="width: 18%;">Jurusan</th>
                        <th style="width: 10%; text-align: center;">Role</th>
                        <th style="width: 15%; text-align: center;">Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td><small>{{ $user->email }}</small></td>
                            <td>{{ $user->kelas ?? '-' }}</td>
                            <td>
                                @if ($user->jurusan)
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
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if ($user->role === 'admin')
                                    <span class="badge-admin">Admin</span>
                                @else
                                    <span class="badge-user">User</span>
                                @endif
                            </td>
                            <td style="text-align: center;"><small>{{ $user->created_at->format('d M Y') }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5" style="color: #7096D1;">
                                <i class="bi bi-inbox" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i> Belum ada pengguna terdaftar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div style="padding: 20px; background-color: #F9FAFF; border-top: 1px solid rgba(112, 150, 209, 0.1);">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Info Alert -->
    <div style="background: linear-gradient(135deg, rgba(112, 150, 209, 0.1), rgba(112, 150, 209, 0.05)); border-left: 4px solid #7096D1; border-radius: 12px; padding: 25px; margin-top: 40px;">
        <strong style="color: #334EAC;">📊 Informasi:</strong>
        <p style="color: #555; margin-top: 8px; margin-bottom: 0;">Data pengguna di atas adalah semua pengguna yang sudah melakukan registrasi atau mendapat akun admin dalam sistem perpustakaan digital.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
