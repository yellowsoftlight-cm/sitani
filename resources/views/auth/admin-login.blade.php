<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('images/logo-sitani-256.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Access — SiTani</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/template.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="st-auth-body st-auth-body--admin">

  <div class="st-auth-card st-auth-card--admin">
    <div class="st-admin-lock">
      <span class="material-icons">admin_panel_settings</span>
    </div>

    <div class="st-auth-brand">
      <img src="{{ asset('images/logo-sitani-256.png') }}" alt="Logo SiTani" class="st-auth-logo-img">
      <span class="st-auth-mark" style="color: var(--st-cream);">SiTani</span>
      <span class="st-auth-tag" style="color: var(--st-khaki);">Kontrol Sistem</span>
    </div>
    <h1 class="st-auth-title" style="color: var(--st-cream);">Akses Admin</h1>
    <p class="st-admin-warning">
      Halaman ini khusus untuk pengelola sistem SiTani. Aktivitas login dicatat dan dibatasi.
    </p>

    @if ($errors->any())
      <div class="st-auth-alert st-auth-alert--danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
      @csrf
      <div class="st-auth-group">
        <label for="email">Email Admin</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off">
      </div>
      <div class="st-auth-group">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" required>
      </div>

      <button type="submit" class="st-btn st-btn--solid st-auth-submit st-admin-submit">
        <span class="material-icons" style="font-size: 18px;">lock</span> Masuk sebagai Admin
      </button>
    </form>
  </div>

</body>
</html>
