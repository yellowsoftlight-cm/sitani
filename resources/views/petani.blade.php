<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('images/logo-sitani-256.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Petani — SiTani</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

  <!-- Google Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Style Sheets -->
  <link rel="stylesheet" href="{{ asset('css/template.css') }}">
  <link rel="stylesheet" href="{{ asset('css/petani.css') }}">
</head>
<body class="st-dashboard-body">

  <!-- Tombol Toggle Sidebar (Mobile) -->
  <button class="st-dash-toggle" id="stDashToggle" aria-label="Toggle Sidebar">
    <span class="material-icons">menu</span>
  </button>

  <div class="st-dash-wrapper">
    
    <!-- ============ SIDEBAR NAVIGASI ============ -->
<aside class="st-sidebar" id="stSidebar">
  <div class="st-sidebar__head">
    <img src="{{ asset('images/logo-sitani-256.png') }}" alt="Logo SiTani" class="st-sidebar__logo-img">
    <span class="st-nav__mark">SiTani</span>
    <span class="st-nav__tag">Panel Petani</span>
  </div>
  
  <div class="st-sidebar__user">
    <div class="st-user-avatar">
      <span class="material-icons">account_circle</span>
    </div>
    <div>
      <div class="st-user-name">{{ Auth::user()->name }}</div>
      <div class="st-user-meta">ID: {{ Auth::user()->id }}/POKTAN</div>
    </div>
  </div>

  <nav class="st-sidebar__nav">
    <a href="{{ route('petani.dashboard') }}#ringkasan" class="st-sidebar__link {{ Request::is('petani/dashboard') ? 'is-active' : '' }}">
      <span class="material-icons st-sidebar__icon">dashboard</span> Ringkasan Tani
    </a>
    <a href="{{ route('petani.dashboard') }}#input-panen" class="st-sidebar__link" id="triggerFormPanen">
      <span class="material-icons st-sidebar__icon">grass</span> Input Hasil Panen
    </a>
    <a href="{{ route('petani.dashboard') }}#riwayat" class="st-sidebar__link">
      <span class="material-icons st-sidebar__icon">history_edu</span> Riwayat Verifikasi
    </a>
  </nav>

  <div class="st-sidebar__foot">
    <a href="#" class="st-btn st-btn--outline st-logout-btn" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <span class="material-icons" style="font-size: 16px;">logout</span> Keluar Sistem
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
        @csrf
    </form>
  </div>
</aside>

<main class="st-dash-main">
  <header class="st-dash-header">
    <div>
      <h1 class="st-dash-title">Selamat Datang, {{ Auth::user()->name }}</h1>
      <p class="st-dash-subtitle">Pantau lahan, laporkan hasil panen bumi, dan cek transparansi distribusi bagi hasil kelompok.</p>
    </div>
    <div class="st-dash-header__right">
      <div class="st-status-badge st-status-badge--success">
        <span class="material-icons" style="font-size: 14px;">verified</span> Lahan Terverifikasi
      </div>
      <x-notif-bell />
    </div>
  </header>

      <!-- Grid Statistik Utama (Cards) -->
      <section class="st-dash-grid" id="ringkasan">

        @if (session('success'))
          <div class="st-alert st-alert--success" style="grid-column: 1 / -1;">{{ session('success') }}</div>
        @endif

        <div class="st-dash-card">
          <div class="st-card-header">
            <span class="st-card-label">Total Setor Panen</span>
            <span class="material-icons st-card-icon st-icon--green">inventory_2</span>
          </div>
          <div class="st-card-value">{{ number_format($totalSetorPanen, 0, ',', '.') }} <span class="st-card-unit">Kg</span></div>
          <div class="st-card-sub text-mono">
            @if ($riwayatPanen->isEmpty())
              Belum ada data panen
            @else
              Seluruh Musim Tanam
            @endif
          </div>
        </div>

        <div class="st-dash-card">
          <div class="st-card-header">
            <span class="st-card-label">Estimasi Bagi Hasil</span>
            <span class="material-icons st-card-icon st-icon--amber">payments</span>
          </div>
          <div class="st-card-value"><span class="st-card-unit">Rp</span> {{ number_format($estimasiBagiHasil, 0, ',', '.') }}</div>
          <div class="st-card-sub text-mono text-success">Terverifikasi Pengurus</div>
        </div>

        <div class="st-dash-card">
          <div class="st-card-header">
            <span class="st-card-label">Menunggu Verifikasi</span>
            <span class="material-icons st-card-icon st-icon--blue">pending_actions</span>
          </div>
          <div class="st-card-value">{{ number_format($totalMenungguKg, 0, ',', '.') }} <span class="st-card-unit">Kg</span></div>
          <div class="st-card-sub text-mono text-muted">{{ $jumlahBerkasMenunggu }} Berkas Nota</div>
        </div>
        
      </section>

      <!-- Area Form Input & Riwayat Kerja -->
      <section class="st-dash-sections">
        
        <!-- Form Pencatatan Panen Baru -->
        <div class="st-form-section" id="input-panen">
          <div class="st-section-header">
            <span class="material-icons text-success">add_box</span>
            <h3 class="st-section-sub">Laporkan Hasil Panen Baru</h3>
          </div>
          <p class="st-form-tip">Pastikan timbangan berat gabah/komoditas basah telah disaksikan perwakilan kelompok tani.</p>
          
          <form action="{{ route('petani.panen.store') }}" method="POST" class="st-minimal-form">
            @csrf
            <div class="st-form-group">
              <label for="komoditas">Komoditas Hasil Bumi</label>
              <select id="komoditas" name="komoditas" required>
                <option value="padi">Padi (Gabah Kering Giling)</option>
                <option value="jagung">Jagung Manis</option>
                <option value="kedelai">Kedelai Hitam</option>
              </select>
            </div>

            <div class="st-form-row">
              <div class="st-form-group">
                <label for="berat">Berat Bersih (Kilogram)</label>
                <input type="number" id="berat" name="berat" placeholder="Contoh: 1250" min="1" required>
              </div>
              <div class="st-form-group">
                <label for="musim">Periode Musim Tanam</label>
                <select id="musim" name="musim" required>
                  <option value="2026-1">Musim I — 2026</option>
                  <option value="2026-2">Musim II — 2026</option>
                  <option value="2026-3">Musim III — 2026</option>
                </select>
              </div>
            </div>

            <button type="submit" class="st-btn st-btn--solid st-submit-dash">
              <span class="material-icons" style="font-size: 18px;">send</span> Kirim Data ke Pengurus
            </button>
          </form>

          @if ($errors->any())
            <div class="st-alert st-alert--danger" style="margin-top: 12px;">
              {{ $errors->first() }}
            </div>
          @endif
        </div>

        <!-- Tabel Riwayat Pencatatan Baku -->
        <div class="st-table-section" id="riwayat">
          <div class="st-section-header">
            <span class="material-icons text-muted">receipt_long</span>
            <h3 class="st-section-sub">Riwayat Verifikasi Nota Panen</h3>
          </div>
          <div class="st-table-responsive">
            <table class="st-ledger-table">
              <thead>
                <tr>
                  <th>No. Nota</th>
                  <th>Tanggal</th>
                  <th>Komoditas</th>
                  <th>Jumlah</th>
                  <th>Musim</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($riwayatPanen as $panen)
                  <tr>
                    <td class="text-mono font-bold">{{ $panen->no_nota }}</td>
                    <td>{{ $panen->created_at->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>{{ $panen->komoditas }}</td>
                    <td class="text-mono font-bold">{{ number_format($panen->berat, 0, ',', '.') }} Kg</td>
                    <td>{{ $panen->musim }}</td>
                    <td>
                      @if ($panen->status === 'menunggu')
                        <span class="st-badge st-badge--pending">
                          <span class="material-icons">hourglass_empty</span> Menunggu
                        </span>
                      @elseif ($panen->status === 'disetujui')
                        <span class="st-badge st-badge--success">
                          <span class="material-icons">check_circle</span> Disetujui
                        </span>
                      @else
                        <span class="st-badge st-badge--danger">
                          <span class="material-icons">cancel</span> Ditolak
                        </span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 24px 0;">
                      Belum ada riwayat panen. Silakan input hasil panen pertama Anda.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </section>
    </main>

  </div>

  <script src="{{ asset('js/main.js') }}"></script>
  <x-realtime-scripts />
</body>
</html>