@extends('layout.layout')

@section('title', 'Register')

@section('content')
<style>
    body {
        background-color: #FFF9F0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-container {
        width: 100%;
        max-width: 450px;
        padding: 20px;
    }

    .register-card {
        background: white;
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 10px 40px rgba(51, 78, 172, 0.15);
        border: 1px solid rgba(112, 150, 209, 0.1);
    }

    .register-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .register-header h1 {
        color: #334EAC;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .register-header p {
        color: #7096D1;
        font-size: 1.1rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        color: #334EAC;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control-modern {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E0E7FF;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #FFF9F0;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #7096D1;
        box-shadow: 0 0 0 3px rgba(112, 150, 209, 0.1);
        background-color: white;
    }

    .form-select-modern {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E0E7FF;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #FFF9F0;
        cursor: pointer;
    }

    .form-select-modern:focus {
        outline: none;
        border-color: #7096D1;
        box-shadow: 0 0 0 3px rgba(112, 150, 209, 0.1);
    }

    .btn-register {
        width: 100%;
        padding: 14px 20px;
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(51, 78, 172, 0.3);
    }

    .alert-error-modern {
        background: #FEE;
        border-left: 4px solid #E74C3C;
        color: #C0392B;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .alert-error-modern ul {
        margin: 10px 0 0 0;
        padding-left: 20px;
    }

    .alert-error-modern li {
        margin-bottom: 5px;
    }

    .register-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #E0E7FF;
    }

    .register-footer p {
        color: #666;
        font-size: 0.95rem;
    }

    .register-footer a {
        color: #334EAC;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .register-footer a:hover {
        color: #7096D1;
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h1>📝 Daftar</h1>
            <p>Buat akun perpustakaan digital</p>
        </div>

        @if ($errors->any())
            <div class="alert-error-modern">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control-modern" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select-modern" required>
                    <option value="">-- Pilih Kelas --</option>
                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-select-modern" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <option value="AnalisKimia" {{ old('jurusan') == 'AnalisKimia' ? 'selected' : '' }}>Analis Kimia</option>
                    <option value="Farmasi" {{ old('jurusan') == 'Farmasi' ? 'selected' : '' }}>Farmasi</option>
                    <option value="PPLG" {{ old('jurusan') == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control-modern" placeholder="Masukkan password" required>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control-modern" placeholder="Masukkan ulang password" required>
            </div>

            <button type="submit" class="btn-register">Daftar</button>
        </form>

        <div class="register-footer">
            <p>Sudah punya akun? <a href="/login">Login di sini</a></p>
        </div>
    </div>
</div>
@endsection