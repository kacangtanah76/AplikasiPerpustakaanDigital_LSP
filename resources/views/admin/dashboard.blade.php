@extends('layout.layout')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    body {
        background-color: #FFF9F0;
    }

    .bg-primary-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        border: none;
    }

    .btn-primary-modern:hover {
        background: linear-gradient(135deg, #2A3E8F 0%, #6086B8 100%);
        color: white;
    }

    .btn-outline-modern {
        border: 2px solid #334EAC;
        color: #334EAC;
    }

    .btn-outline-modern:hover {
        background-color: #334EAC;
        color: white;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(51, 78, 172, 0.1);
        border: 1px solid rgba(112, 150, 209, 0.1);
    }

    .stat-card {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 140px;
        border-radius: 15px;
    }

    .stat-card.primary {
        background: linear-gradient(135deg, #7096D1 0%, #334EAC 100%);
        color: white;
    }

    .stat-card.secondary {
        background: linear-gradient(135deg, #E0E7FF 0%, #F0F4FF 100%);
        color: #334EAC;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
    }

    .table th,
    .table td {
        padding: 14px 16px;
        font-size: 1rem;
        vertical-align: middle;
        word-wrap: break-word;
    }

    .table th {
        background-color: #F5F7FF;
        font-weight: 600;
        color: #334EAC;
    }

    .table tbody tr:hover {
        background-color: #F9FAFF;
    }
</style>

<div class="container-fluid px-0">
    <!-- Navbar -->
    <div class="bg-primary-modern text-white py-5 mb-5" style="background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);">
        <div class="container">
            <h1 class="mb-2" style="font-size: 36px; font-weight: 700;">Admin Dashboard</h1>
            <p class="mb-0" style="font-size: 15px; opacity: 0.9;">Kelola dan monitor aplikasi perpustakaan digital</p>
        </div>
    </div>

    <div class="container">
        <!-- Statistik Cards -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card primary">
                    <div style="text-align: center; width: 100%;">
                        <h6 style="margin: 0 0 10px 0; font-weight: 500; font-size: 14px; opacity: 0.95;">Total Pengguna</h6>
                        <h2 style="margin: 0; font-weight: 700; font-size: 42px;">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card primary" style="background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);">
                    <div style="text-align: center; width: 100%;">
                        <h6 style="margin: 0 0 10px 0; font-weight: 500; font-size: 14px; opacity: 0.95;">Total Admin</h6>
                        <h2 style="margin: 0; font-weight: 700; font-size: 42px;">{{ $totalAdmin }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card secondary">
                    <div style="text-align: center; width: 100%;">
                        <h6 style="margin: 0 0 10px 0; font-weight: 500; font-size: 14px;">Kelas XI</h6>
                        <h2 style="margin: 0; font-weight: 700; font-size: 42px;">{{ $kelasXI }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card secondary">
                    <div style="text-align: center; width: 100%;">
                        <h6 style="margin: 0 0 10px 0; font-weight: 500; font-size: 14px;">Kelas XII</h6>
                        <h2 style="margin: 0; font-weight: 700; font-size: 42px;">{{ $kelasXII }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pengguna -->
        <div class="card mb-5">
            <div class="card-header-modern">
                <h5 class="mb-0" style="font-weight: 600; font-size: 16px;">Daftar Pengguna Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 25%;">Email</th>
                            <th style="width: 12%;">Kelas</th>
                            <th style="width: 18%;">Jurusan</th>
                            <th style="width: 25%;">Terdaftar pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td><small>{{ $user->email }}</small></td>
                                <td><span class="badge" style="background-color: #7096D1;">{{ $user->kelas }}</span></td>
                                <td>
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
                                </td>
                                <td><small>{{ $user->created_at->format('d M Y H:i') }}</small></td>
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
            </div>
            <div class="card-footer" style="background-color: #F9FAFF; border-top: 1px solid rgba(112, 150, 209, 0.1);">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-5 d-flex gap-3">
            <a href="{{ route('admin.users') }}" class="btn btn-primary-modern">
                <i class="bi bi-people-fill"></i> Lihat Semua Pengguna
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-modern">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
