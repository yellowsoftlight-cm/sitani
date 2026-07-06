<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('images/logo-sitani-256.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengurus — SiTani</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/template.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pengurus.css') }}">
</head>
<body class="st-dashboard-body">

  <button class="st-dash-toggle" id="stDashToggle" aria-label="Toggle Sidebar">
    <span class="material-icons">menu</span>
  </button>

  <div class="st-dash-wrapper">

    <aside class="st-sidebar" id="stSidebar">
      <div class="st-sidebar__head">
        <img src="{{ asset('images/logo-sitani-256.png') }}" alt="Logo SiTani" class="st-sidebar__logo-img">
        <span class="st-nav__mark">SiTani</span>
        <span class="st-nav__tag st-nav__tag--pengurus">Panel Pengurus</span>
      </div>

      <div class="st-sidebar__user">
        <div class="st-user-avatar">
          <span class="material-icons">account_circle</span>
        </div>
        <div>
          <div class="st-user-name">{{ Auth::user()->name }}</div>
          <div class="st-user-meta">ID: {{ Auth::user()->id }}/PENGURUS</div>
        </div>
      </div>

      <nav class="st-sidebar__nav">
        <a href="{{ route('pengurus.dashboard') }}#ringkasan" class="st-sidebar__link is-active">
          <span class="material-icons st-sidebar__icon">dashboard</span> Ringkasan Kelompok
        </a>
        <a href="{{ route('pengurus.dashboard') }}#verifikasi-panen" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">fact_check</span> Verifikasi Hasil Tani
        </a>
        <a href="{{ route('pengurus.dashboard') }}#data-anggota" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">groups</span> Data Anggota Poktan
        </a>
        <a href="{{ route('pengurus.dashboard') }}#distribusi-pasar" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">local_shipping</span> Distribusi ke Pasar
        </a>
      </nav>

      <div class="st-sidebar__foot">
        <a href="#" class="st-btn st-btn--outline st-logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <span class="material-icons" style="font-size: 16px;">logout</span> Keluar Sistem
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </aside>

    <main class="st-dash-main">

      <header class="st-dash-header">
        <div>
          <h1 class="st-dash-title">Selamat Datang, Pengurus {{ Auth::user()->name }}</h1>
          <p class="st-dash-subtitle">Kelola verifikasi data panen masuk, approval pendaftaran anggota baru, dan pantau produktivitas pangan kelompok.</p>
        </div>
        <div class="st-dash-header__right">
          <x-notif-bell />
        </div>
      </header>

      @if (session('success'))
        <div class="st-alert st-alert--success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="st-alert st-alert--danger">{{ session('error') }}</div>
      @endif

      <section class="st-dash-grid" id="ringkasan">
        <div class="st-stat-card">
          <div class="st-stat-icon card-icon-green"><span class="material-icons">groups</span></div>
          <div class="st-stat-info">
            <span class="st-stat-label">Total Anggota Aktif</span>
            <h2 class="st-stat-value">{{ $totalAnggota }} Petani</h2>
          </div>
        </div>
        <div class="st-stat-card">
          <div class="st-stat-icon card-icon-yellow"><span class="material-icons">pending_actions</span></div>
          <div class="st-stat-info">
            <span class="st-stat-label">Menunggu Verifikasi</span>
            <h2 class="st-stat-value">{{ $jumlahMenunggu }} Laporan</h2>
          </div>
        </div>
        <div class="st-stat-card">
          <div class="st-stat-icon card-icon-blue"><span class="material-icons">scale</span></div>
          <div class="st-stat-info">
            <span class="st-stat-label">Total Volume Panen Disetujui</span>
            <h2 class="st-stat-value">{{ number_format($totalVolumeDisetujui, 0, ',', '.') }} Kg</h2>
          </div>
        </div>
      </section>

      <section class="st-dash-content">
        <div class="st-table-section" id="verifikasi-panen">
          <div class="st-section-header">
            <h2 class="st-section-title">Antrean Verifikasi Hasil Panen</h2>
            <p class="st-section-subtitle">Periksa kesesuaian laporan berat komoditas sebelum disetujui untuk masuk kalkulasi distribusi.</p>
          </div>

          <div class="st-table-responsive">
            <table class="st-table">
              <thead>
                <tr>
                  <th>Nama Petani</th>
                  <th>Tanggal Input</th>
                  <th>Komoditas</th>
                  <th>Berat Bersih</th>
                  <th>Musim</th>
                  <th style="min-width: 220px;">Aksi Keputusan</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($antreanVerifikasi as $panen)
                  <tr>
                    <td><strong>{{ $panen->user->name ?? 'Petani tidak ditemukan' }}</strong></td>
                    <td>{{ $panen->created_at->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>{{ $panen->komoditas }}</td>
                    <td class="text-mono font-bold text-success">{{ number_format($panen->berat, 0, ',', '.') }} Kg</td>
                    <td>{{ $panen->musim }}</td>
                    <td>
                      <div class="st-verify-actions">
                        <form action="{{ route('pengurus.panen.approve', $panen) }}" method="POST" class="st-verify-form">
                          @csrf
                          <input type="number" name="estimasi_bagi_hasil" placeholder="Rp bagi hasil" min="0" required class="st-verify-input">
                          <button type="submit" class="st-action-btn btn-approve" title="Setujui">
                            <span class="material-icons">check_circle</span>
                          </button>
                        </form>
                        <form action="{{ route('pengurus.panen.reject', $panen) }}" method="POST" onsubmit="return confirm('Tolak laporan panen {{ $panen->no_nota }}?');">
                          @csrf
                          <button type="submit" class="st-action-btn btn-reject" title="Tolak">
                            <span class="material-icons">cancel</span>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 24px 0;">
                      Tidak ada laporan panen yang menunggu verifikasi saat ini.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="st-table-section" id="data-anggota">
          <div class="st-section-header">
            <h2 class="st-section-title">Data Anggota Poktan</h2>
            <p class="st-section-subtitle">Daftar petani terdaftar beserta rekapitulasi total setor panen yang telah disetujui.</p>
          </div>

          <div class="st-table-responsive">
            <table class="st-table">
              <thead>
                <tr>
                  <th>Nama Petani</th>
                  <th>Email</th>
                  <th>Total Laporan Panen</th>
                  <th>Total Setor Disetujui</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($anggotaPoktan as $petani)
                  <tr>
                    <td><strong>{{ $petani->name }}</strong></td>
                    <td class="text-mono">{{ $petani->email }}</td>
                    <td class="text-mono">{{ $petani->panens_count }}</td>
                    <td class="text-mono font-bold text-success">{{ number_format($petani->total_berat ?? 0, 0, ',', '.') }} Kg</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted" style="padding: 24px 0;">
                      Belum ada anggota petani yang terdaftar.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div class="st-table-section" id="distribusi-pasar">
          <div class="st-section-header">
            <h2 class="st-section-title">Distribusi Hasil Panen ke Pasar</h2>
            <p class="st-section-subtitle">Catat pengiriman hasil panen yang sudah disetujui ke pasar/pembeli tujuan beserta harga jualnya.</p>
          </div>

          <form action="{{ route('pengurus.distribusi.store') }}" method="POST" class="st-distribusi-form">
            @csrf
            <div class="st-distribusi-form__grid">
              <label class="st-form-field">
                <span>Laporan Panen</span>
                <select name="panen_id" required>
                  <option value="">— Pilih panen yang siap didistribusikan —</option>
                  @foreach ($siapDidistribusikan as $panen)
                    <option value="{{ $panen->id }}">
                      {{ $panen->no_nota }} — {{ $panen->user->name ?? 'Petani tidak ditemukan' }} · {{ $panen->komoditas }} · {{ number_format($panen->berat, 0, ',', '.') }} Kg
                    </option>
                  @endforeach
                </select>
              </label>

              <label class="st-form-field">
                <span>Nama Pasar / Pembeli Tujuan</span>
                <input type="text" name="nama_pasar" placeholder="mis. Pasar Induk Kramat Jati" required maxlength="150">
              </label>

              <label class="st-form-field">
                <span>Jumlah Dikirim (Kg)</span>
                <input type="number" name="jumlah_kg" min="1" required>
              </label>

              <label class="st-form-field">
                <span>Harga Jual per Kg (Rp)</span>
                <input type="number" name="harga_per_kg" min="0" required>
              </label>

              <label class="st-form-field">
                <span>Tanggal Kirim</span>
                <input type="date" name="tanggal_kirim" value="{{ now()->toDateString() }}" required>
              </label>

              <label class="st-form-field st-form-field--wide">
                <span>Catatan (opsional)</span>
                <input type="text" name="catatan" placeholder="mis. nomor kendaraan, kontak pembeli, dll." maxlength="500">
              </label>
            </div>

            <button type="submit" class="st-btn st-btn--solid">
              <span class="material-icons" style="font-size: 18px; vertical-align: -3px;">local_shipping</span>
              Catat Distribusi
            </button>
          </form>

          @if ($siapDidistribusikan->isEmpty())
            <p class="text-center text-muted" style="padding: 12px 0 4px;">
              Tidak ada laporan panen disetujui yang menunggu distribusi saat ini.
            </p>
          @endif

          <div class="st-table-responsive" style="margin-top: 24px;">
            <table class="st-table">
              <thead>
                <tr>
                  <th>No. Nota</th>
                  <th>Petani</th>
                  <th>Komoditas</th>
                  <th>Pasar Tujuan</th>
                  <th>Jumlah</th>
                  <th>Harga/Kg</th>
                  <th>Total Nilai</th>
                  <th>Tanggal Kirim</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($riwayatDistribusi as $distribusi)
                  <tr>
                    <td class="text-mono">{{ $distribusi->panen->no_nota ?? '-' }}</td>
                    <td><strong>{{ $distribusi->panen->user->name ?? 'Petani tidak ditemukan' }}</strong></td>
                    <td>{{ $distribusi->panen->komoditas ?? '-' }}</td>
                    <td>{{ $distribusi->nama_pasar }}</td>
                    <td class="text-mono">{{ number_format($distribusi->jumlah_kg, 0, ',', '.') }} Kg</td>
                    <td class="text-mono">Rp {{ number_format($distribusi->harga_per_kg, 0, ',', '.') }}</td>
                    <td class="text-mono font-bold text-success">Rp {{ number_format($distribusi->total_nilai, 0, ',', '.') }}</td>
                    <td>{{ $distribusi->tanggal_kirim->locale('id')->translatedFormat('d F Y') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 24px 0;">
                      Belum ada distribusi hasil panen yang tercatat.
                    </td>
                  </tr>
                @endforelse
              </tbody>
              @if ($riwayatDistribusi->isNotEmpty())
                <tfoot>
                  <tr>
                    <td colspan="6" style="text-align: right;"><strong>Total Nilai Distribusi</strong></td>
                    <td class="text-mono font-bold text-success" colspan="2">Rp {{ number_format($totalNilaiDistribusi, 0, ',', '.') }}</td>
                  </tr>
                </tfoot>
              @endif
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
