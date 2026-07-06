<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('images/logo-sitani-256.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kelompok — SiTani</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/template.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="st-auth-body">

  <div class="st-auth-card">
    <a href="{{ url('/') }}" class="st-auth-back">
      <span class="material-icons" style="font-size: 16px;">arrow_back</span> Kembali ke Beranda
    </a>

    <div class="st-auth-brand">
      <img src="{{ asset('images/logo-sitani-256.png') }}" alt="Logo SiTani" class="st-auth-logo-img">
      <span class="st-auth-mark">SiTani</span>
      <span class="st-auth-tag">Sistem Tani</span>
    </div>
    <h1 class="st-auth-title">Daftar Anggota SiTani</h1>

    @if ($errors->any())
      <div class="st-auth-alert st-auth-alert--danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="st-auth-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
      </div>
      <div class="st-auth-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
      </div>
      <div class="st-auth-group">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" minlength="6" required>
      </div>
      <div class="st-auth-group">
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" minlength="6" required>
      </div>
      <div class="st-auth-group">
        <label for="role">Daftar Sebagai</label>
        <select id="role" name="role" required>
          <option value="Petani" {{ old('role') === 'Petani' ? 'selected' : '' }}>Petani</option>
          <option value="Pengurus" {{ old('role') === 'Pengurus' ? 'selected' : '' }}>Pengurus</option>
        </select>
      </div>

      <button type="submit" class="st-btn st-btn--solid st-auth-submit">
        <span class="material-icons" style="font-size: 18px;">person_add</span> Daftar
      </button>
    </form>

    <p class="st-auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
  </div>

</body>
</html>
