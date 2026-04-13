@extends('layout.admin-layout')

@section('title', 'Daftar Pengguna')

@section('content')
<style>
    body {
        background-color: #F9F6EE;
    }

    .navbar-admin {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 20px rgba(51, 78, 172, 0.2);
        padding: 20px 0;
        margin-bottom: 40px;
    }

    .navbar-admin h1 {
        color: white;
        margin: 0;
        font-size: 32px;
        font-weight: 700;
    }

    .navbar-admin p {
        color: rgba(255, 255, 255, 0.9);
        margin: 5px 0 0 0;
        font-size: 14px;
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

    .card-header-modern {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
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

    .badge {
        font-size: 0.9rem;
        padding: 6px 10px;
    }

    .badge-no {
        background-color: #E0E7FF;
        color: #334EAC;
        min-width: 40px;
        display: inline-block;
        text-align: center;
        font-weight: 600;
        border-radius: 6px;
    }

    .badge-admin {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF8787 100%) !important;
    }

    .badge-user {
        background: linear-gradient(135deg, #51CF66 0%, #69DB7C 100%) !important;
    }

    .badge-kelas {
        background-color: #7096D1 !important;
    }
</style>

<div class="container-fluid px-0">
    <!-- Navbar -->
    <div class="navbar-admin">
        <div class="container">
            <h1>Daftar Semua Pengguna</h1>
            <p>Kelola seluruh data pengguna yang terdaftar di sistem</p>
        </div>
    </div>

    <div class="container">
        <!-- Card Table -->
        <div class="card mb-5">
            <div class="card-header-modern">
                <h5 class="mb-0" style="font-weight: 600; font-size: 16px;">
                    <i class="bi bi-table"></i> Daftar Pengguna Terdaftar
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 8%; text-align: center;">#</th>
                            <th style="width: 18%;">Nama</th>
                            <th style="width: 24%;">Email</th>
                            <th style="width: 12%; text-align: center;">Role</th>
                            <th style="width: 12%; text-align: center;">Kelas</th>
                            <th style="width: 18%;">Jurusan</th>
                            <th style="width: 8%; text-align: center;">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td style="text-align: center;">
                                    <span class="badge badge-no">{{ $users->firstItem() + $index }}</span>
                                </td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td style="text-align: center;">
                                    @if($user->role === 'admin')
                                        <span class="badge badge-admin text-white">Admin</span>
                                    @else
                                        <span class="badge badge-user text-white">User</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($user->kelas)
                                        <span class="badge badge-kelas text-white">{{ $user->kelas }}</span>
                                    @else
                                        <span style="color: #999; font-size: 0.95rem;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->jurusan)
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
                                        <span style="color: #999; font-size: 0.95rem;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Tidak ada data pengguna
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="card-footer" style="background-color: #F9FAFF; border-top: 1px solid rgba(112, 150, 209, 0.1);">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="mb-5 d-flex gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary-modern">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
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
