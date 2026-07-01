<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
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
<x-sidebar />

    <!-- ============ KONTEN UTAMA ============ -->
    <main class="st-dash-main">
      
      <!-- Header Dashboard -->
      <header class="st-dash-header">
        <div>
          <h1 class="st-dash-title">Selamat Datang, Pak Ahmad</h1>
          <p class="st-dash-subtitle">Pantau lahan, laporkan hasil panen bumi, dan cek transparansi distribusi bagi hasil kelompok.</p>
        </div>
        <div class="st-status-badge st-status-badge--success">
          <span class="material-icons" style="font-size: 14px;">verified</span> Lahan Terverifikasi
        </div>
      </header>

      <!-- Grid Statistik Utama (Cards) -->
      <section class="st-dash-grid" id="ringkasan">
        
        <div class="st-dash-card">
          <div class="st-card-header">
            <span class="st-card-label">Total Setor Panen</span>
            <span class="material-icons st-card-icon st-icon--green">inventory_2</span>
          </div>
          <div class="st-card-value">3.450 <span class="st-card-unit">Kg</span></div>
          <div class="st-card-sub text-mono">Musim Tanam I & II</div>
        </div>

        <div class="st-dash-card">
          <div class="st-card-header">
            <span class="st-card-label">Estimasi Bagi Hasil</span>
            <span class="material-icons st-card-icon st-icon--amber">payments</span>
          </div>
          <div class="st-card-value"><span class="st-card-unit">Rp</span> 4.250.000</div>
          <div class="st-card-sub text-mono text-success">Terverifikasi Pengurus</div>
        </div>

        <div class="st-dash-card">
          <div class="st-card-header">
            <span class="st-card-label">Menunggu Verifikasi</span>
            <span class="material-icons st-card-icon st-icon--blue">pending_actions</span>
          </div>
          <div class="st-card-value">1.250 <span class="st-card-unit">Kg</span></div>
          <div class="st-card-sub text-mono text-muted">1 Berkas Nota</div>
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
          
          <form action="#" method="POST" class="st-minimal-form" onsubmit="event.preventDefault();">
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
                <input type="number" id="berat" name="berat" placeholder="Contoh: 1250" required>
              </div>
              <div class="st-form-group">
                <label for="musim">Periode Musim Tanam</label>
                <select id="musim" name="musim" required>
                  <option value="2026-1">Musim I — 2026</option>
                  <option value="2026-2">Musim II — 2026</option>
                </select>
              </div>
            </div>

            <button type="submit" class="st-btn st-btn--solid st-submit-dash">
              <span class="material-icons" style="font-size: 18px;">send</span> Kirim Data ke Pengurus
            </button>
          </form>
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
                <tr>
                  <td class="text-mono font-bold">#0042/PD</td>
                  <td>12 Juni 2026</td>
                  <td>Padi</td>
                  <td class="text-mono font-bold">1.250 Kg</td>
                  <td>Musim I</td>
                  <td>
                    <span class="st-badge st-badge--pending">
                      <span class="material-icons">hourglass_empty</span> Menunggu
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="text-mono font-bold">#0039/PD</td>
                  <td>14 April 2026</td>
                  <td>Padi</td>
                  <td class="text-mono font-bold">2.200 Kg</td>
                  <td>Musim I</td>
                  <td>
                    <span class="st-badge st-badge--success">
                      <span class="material-icons">check_circle</span> Disetujui
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="text-mono font-bold">#0012/JG</td>
                  <td>10 Jan 2026</td>
                  <td>Jagung</td>
                  <td class="text-mono font-bold">950 Kg</td>
                  <td>Musim II (2025)</td>
                  <td>
                    <span class="st-badge st-badge--danger">
                      <span class="material-icons">cancel</span> Ditolak
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </section>
    </main>

  </div>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>