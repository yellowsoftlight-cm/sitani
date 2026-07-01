<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiTani — Sistem Manajemen Kelompok Tani</title>
  <meta name="description" content="SiTani membantu kelompok tani mencatat pendaftaran anggota, hasil panen, distribusi, dan bagi hasil dalam satu sistem terverifikasi.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/template.css') }}">
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>

  <!-- ============ NAVBAR ============ -->
  <header class="st-nav">
    <div class="st-container st-nav__inner">
      <a href="{{ url('/') }}" class="st-nav__brand">
        <span class="st-nav__mark">SiTani</span>
        <span class="st-nav__tag">Sistem Tani</span>
      </a>

      <nav class="st-nav__links" id="stNavLinks">
        <a href="#alur">Alur Kerja</a>
        <a href="#peran">Peran</a>
        <a href="#fitur">Fitur</a>
      </nav>

      <div class="st-nav__actions">
        <a href="{{ route('login') ?? '#' }}" class="st-btn st-btn--ghost">Masuk</a>
        <a href="{{ route('register') ?? '#' }}" class="st-btn st-btn--solid">Daftar Kelompok</a>
      </div>

      <button class="st-nav__toggle" id="stNavToggle" aria-label="Buka menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <main>
    <!-- ============ HERO ============ -->
    <section class="st-hero">
      <div class="st-container st-hero__grid">

        <div class="st-hero__copy" data-reveal>
          <p class="st-eyebrow">Sistem Manajemen Kelompok Tani</p>
          <h1 class="st-hero__title">
            Satu buku tani digital untuk Petani, Pengurus, dan Admin.
          </h1>
          <p class="st-hero__desc">
            Dari pendaftaran anggota, input hasil panen per musim, verifikasi berjenjang,
            sampai distribusi dan bagi hasil — semua tercatat rapi, tidak lagi tercecer di kertas.
          </p>

          <div class="st-hero__cta">
            <a href="{{ route('register') ?? '#' }}" class="st-btn st-btn--solid st-btn--lg">Mulai Sekarang</a>
            <a href="#alur" class="st-btn st-btn--outline st-btn--lg">Lihat Alur Kerja</a>
          </div>

          <div class="st-hero__stats">
            <div class="st-hero__stat">
              <span class="st-hero__stat-num">3</span>
              <span class="st-hero__stat-label">peran pengguna</span>
            </div>
            <div class="st-hero__stat">
              <span class="st-hero__stat-num">2×</span>
              <span class="st-hero__stat-label">lapis verifikasi</span>
            </div>
            <div class="st-hero__stat">
              <span class="st-hero__stat-num">PDF/XLS</span>
              <span class="st-hero__stat-label">ekspor laporan</span>
            </div>
          </div>
        </div>

        <!-- Signature element: kartu ledger bergaya nota tani -->
        <div class="st-ledger" data-reveal>
          <div class="st-ledger__head">
            <span>KARTU ALUR · SITANI</span>
            <span>No. 0042/POKTAN</span>
          </div>

          <ul class="st-ledger__rows">
            <li><span class="st-ledger__idx">01</span><span>Pendaftaran anggota petani</span><span class="st-ledger__ok">✓</span></li>
            <li><span class="st-ledger__idx">02</span><span>Verifikasi oleh pengurus</span><span class="st-ledger__ok">✓</span></li>
            <li><span class="st-ledger__idx">03</span><span>Input panen — Padi, 1.250 kg</span><span class="st-ledger__ok">✓</span></li>
            <li><span class="st-ledger__idx">04</span><span>Distribusi ke pembeli</span><span class="st-ledger__ok">✓</span></li>
            <li><span class="st-ledger__idx">05</span><span>Bagi hasil proporsional</span><span class="st-ledger__pending">…</span></li>
          </ul>

          <div class="st-ledger__foot">
            <span>Musim I · 2026</span>
            <span>Kelompok Tani Sumber Makmur</span>
          </div>

          <div class="st-stamp">
            <span>TERVERIFIKASI</span>
          </div>
        </div>

      </div>
    </section>

    <!-- ============ PERAN ============ -->
    <section class="st-roles" id="peran" data-nav-class="st-nav--khaki">
      <div class="st-container">
        <p class="st-eyebrow">Peran Pengguna</p>
        <h2 class="st-section-title">Setiap peran punya jalurnya sendiri</h2>

        <div class="st-roles__grid">

          <article class="st-role-card" data-reveal>
            <span class="st-role-card__badge">Petani</span>
            <h3>Anggota Kelompok Tani</h3>
            <ul>
              <li>Daftar sebagai anggota dengan data diri, lahan, dan dokumen pendukung</li>
              <li>Input hasil panen per musim — komoditas, jumlah, dan musim tanam</li>
              <li>Pantau status verifikasi dan notifikasi bagi hasil</li>
            </ul>
          </article>

          <article class="st-role-card" data-reveal>
            <span class="st-role-card__badge">Pengurus</span>
            <h3>Pengurus Kelompok Tani</h3>
            <ul>
              <li>Verifikasi pendaftaran anggota baru dan data hasil panen</li>
              <li>Kelola distribusi hasil ke pasar atau pembeli</li>
              <li>Hitung bagi hasil dan terbitkan laporan produktivitas</li>
            </ul>
          </article>

          <article class="st-role-card" data-reveal>
            <span class="st-role-card__badge">Admin</span>
            <h3>Admin Sistem</h3>
            <ul>
              <li>Kelola master data komoditas, musim tanam, dan lahan</li>
              <li>Atur hak akses pengguna untuk tiap peran</li>
              <li>Backup dan pemeliharaan data sistem secara berkala</li>
            </ul>
          </article>

        </div>
      </div>
    </section>

    <!-- ============ ALUR KERJA ============ -->
    <section class="st-flow" id="alur" data-nav-class="st-nav--dark">
      <div class="st-container">
        <p class="st-eyebrow st-eyebrow--light">Alur Kerja</p>
        <h2 class="st-section-title st-section-title--light">Dari pendaftaran sampai laporan akhir</h2>

        <ol class="st-flow__list">
          <li class="st-flow__item" data-reveal>
            <span class="st-flow__num">01</span>
            <div>
              <h4>Pendaftaran &amp; login</h4>
              <p>Petani mendaftar dengan data diri dan lahan, lalu masuk sesuai perannya.</p>
            </div>
          </li>
          <li class="st-flow__item" data-reveal>
            <span class="st-flow__num">02</span>
            <div>
              <h4>Verifikasi pengurus</h4>
              <p>Pengurus menyetujui atau menolak pendaftaran, lengkap dengan alasan.</p>
            </div>
          </li>
          <li class="st-flow__item" data-reveal>
            <span class="st-flow__num">03</span>
            <div>
              <h4>Input hasil panen</h4>
              <p>Petani mencatat komoditas, jumlah, dan musim panen untuk diverifikasi.</p>
            </div>
          </li>
          <li class="st-flow__item" data-reveal>
            <span class="st-flow__num">04</span>
            <div>
              <h4>Update stok kelompok</h4>
              <p>Data panen yang disetujui otomatis memperbarui stok hasil kelompok.</p>
            </div>
          </li>
          <li class="st-flow__item" data-reveal>
            <span class="st-flow__num">05</span>
            <div>
              <h4>Distribusi &amp; transaksi</h4>
              <p>Pengurus mengelola distribusi ke pembeli dan mencatat harga jual.</p>
            </div>
          </li>
          <li class="st-flow__item" data-reveal>
            <span class="st-flow__num">06</span>
            <div>
              <h4>Bagi hasil &amp; laporan</h4>
              <p>Hasil dibagi proporsional ke anggota, laporan siap diekspor ke PDF/Excel.</p>
            </div>
          </li>
        </ol>
      </div>
    </section>

    <!-- ============ FITUR ============ -->
    <section class="st-features" id="fitur">
      <div class="st-container">
        <p class="st-eyebrow">Fitur</p>
        <h2 class="st-section-title">Dibangun mengikuti alur kerja kelompok tani</h2>

        <div class="st-features__grid">
          <div class="st-feature-card" data-reveal>
            <h3>Verifikasi berlapis</h3>
            <p>Setiap pendaftaran dan laporan panen melewati persetujuan pengurus sebelum tercatat resmi.</p>
          </div>
          <div class="st-feature-card" data-reveal>
            <h3>Bagi hasil proporsional</h3>
            <p>Perhitungan otomatis berdasarkan kontribusi panen tiap anggota, bukan tebak-tebakan manual.</p>
          </div>
          <div class="st-feature-card" data-reveal>
            <h3>Laporan &amp; grafik tren</h3>
            <p>Produktivitas per anggota, komoditas, dan musim, siap diekspor ke PDF atau Excel.</p>
          </div>
          <div class="st-feature-card" data-reveal>
            <h3>Notifikasi status</h3>
            <p>Petani mendapat kabar setiap kali pendaftaran, panen, atau bagi hasil diproses.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="st-cta">
      <div class="st-container st-cta__inner">
        <h2>Mulai catat hasil panen kelompok Anda hari ini.</h2>
        <p>Gratis untuk kelompok tani yang baru mendaftar.</p>
        <a href="{{ route('register') ?? '#' }}" class="st-btn st-btn--solid st-btn--lg">Daftarkan Kelompok Tani</a>
      </div>
    </section>
  </main>

  <!-- ============ FOOTER ============ -->
  <footer class="st-footer">
    <div class="st-container st-footer__inner">
      <div>
        <span class="st-nav__mark st-nav__mark--light">SiTani</span>
        <p>Sistem manajemen kelompok tani — pendaftaran, panen, distribusi, dan bagi hasil dalam satu tempat.</p>
      </div>
      <div class="st-footer__cols">
        <div>
          <h5>Navigasi</h5>
          <a href="#peran">Peran Pengguna</a>
          <a href="#alur">Alur Kerja</a>
          <a href="#fitur">Fitur</a>
        </div>
        <div>
          <h5>Akun</h5>
          <a href="{{ route('login') ?? '#' }}">Masuk</a>
          <a href="{{ route('register') ?? '#' }}">Daftar Kelompok</a>
        </div>
      </div>
    </div>
    <div class="st-container st-footer__bottom">
      <span>© {{ date('Y') }} SiTani. Seluruh hak cipta dilindungi.</span>
    </div>
  </footer>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>