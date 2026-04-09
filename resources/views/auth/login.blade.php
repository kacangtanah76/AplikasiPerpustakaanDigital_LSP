@extends('layout.layout')

@section('title', 'Login')

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

    .navbar-header {
        background: linear-gradient(135deg, #334EAC 0%, #7096D1 100%);
        padding: 20px 0;
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.15);
        text-align: center;
        color: white;
    }

    .navbar-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        width: 100%;
        max-width: 450px;
        padding: 20px;
    }

    .login-card {
        background: white;
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 10px 40px rgba(51, 78, 172, 0.15);
        border: 1px solid rgba(112, 150, 209, 0.1);
    }

    .login-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-header h1 {
        color: #334EAC;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .login-header p {
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

    .conditional-fields {
        display: none;
        animation: slideIn 0.3s ease;
    }

    .conditional-fields.show {
        display: block;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-login {
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

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(51, 78, 172, 0.3);
    }

    .alert-danger-modern {
        background: #FEE;
        border-left: 4px solid #E74C3C;
        color: #C0392B;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .login-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #E0E7FF;
    }

    .login-footer p {
        color: #666;
        font-size: 0.95rem;
    }

    .login-footer a {
        color: #334EAC;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-footer a:hover {
        color: #7096D1;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>📚 Login</h1>
            <p>Aplikasi Perpustakaan Digital</p>
        </div>

        @if ($errors->any())
            <div class="alert-danger-modern">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" id="loginForm">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama / Email</label>
                <input type="text" name="username" class="form-control-modern" placeholder="Masukkan nama atau email" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control-modern" placeholder="Masukkan password" required>
            </div>

            <div id="userFields" class="conditional-fields">
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" class="form-select-modern" id="kelasSelect">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-select-modern" id="jurusanSelect">
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="AnalisKimia" {{ old('jurusan') == 'AnalisKimia' ? 'selected' : '' }}>Analis Kimia</option>
                        <option value="Farmasi" {{ old('jurusan') == 'Farmasi' ? 'selected' : '' }}>Farmasi</option>
                        <option value="PPLG" {{ old('jurusan') == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="login-footer">
            <p>Belum punya akun? <a href="/register">Buat akun baru</a></p>
        </div>
    </div>
</div>

<script>
function toggleUserFields() {
    var username = document.getElementById('loginForm').querySelector('input[name="username"]').value;
    var userFields = document.getElementById('userFields');
    var kelasSelect = document.getElementById('kelasSelect');
    var jurusanSelect = document.getElementById('jurusanSelect');
    
    var isEmail = username.includes('@');
    
    if (isEmail) {
        userFields.classList.remove('show');
        kelasSelect.removeAttribute('required');
        jurusanSelect.removeAttribute('required');
        kelasSelect.value = '';
        jurusanSelect.value = '';
    } else if (username.trim() !== '') {
        userFields.classList.add('show');
        kelasSelect.setAttribute('required', 'required');
        jurusanSelect.setAttribute('required', 'required');
    } else {
        userFields.classList.remove('show');
    }
}

document.getElementById('loginForm').querySelector('input[name="username"]').addEventListener('input', toggleUserFields);

window.addEventListener('load', function() {
    toggleUserFields();
});
</script>
@endsection