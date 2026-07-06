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

  <script>
    // Terapkan tema tersimpan sedini mungkin agar tidak "flash" saat halaman dimuat
    (function () {
      var saved = localStorage.getItem('sitani-theme');
      if (saved === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    })();
  </script>
</head>
<body>

  <!-- ============ NAVBAR ============ -->
<x-navbar />
  <main>
    <!-- ============ HERO ============ -->
    <section class="st-hero">
      <div class="st-container st-hero__grid">

        <div class="st-hero__copy" data-reveal>
          <p class="st-eyebrow">Sistem Manajemen Kelompok Tani</p>
          <h1 class="st-hero__title">
            Satu buku tani digital untuk <em>Petani, Pengurus, dan Admin.</em>
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
              <span class="st-hero__stat-ic">👥</span>
              <span class="st-hero__stat-text">
                <span class="st-hero__stat-num">3</span>
                <span class="st-hero__stat-label">peran pengguna</span>
              </span>
            </div>
            <div class="st-hero__stat">
              <span class="st-hero__stat-ic">🔒</span>
              <span class="st-hero__stat-text">
                <span class="st-hero__stat-num">2×</span>
                <span class="st-hero__stat-label">lapis verifikasi</span>
              </span>
            </div>
            <div class="st-hero__stat">
              <span class="st-hero__stat-ic">📄</span>
              <span class="st-hero__stat-text">
                <span class="st-hero__stat-num">PDF/XLS</span>
                <span class="st-hero__stat-label">ekspor laporan</span>
              </span>
            </div>
          </div>
        </div>

        <!-- Signature element: kartu ledger bergaya nota tani + kartu insight grafik mini -->
        <div class="st-ledger-wrap" data-reveal>
          <div class="st-ledger">
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

          <div class="st-hero-insight">
            <div class="st-hero-insight__label">Tren Panen</div>
            <div class="st-hero-insight__num">+18%</div>
            <canvas id="chartHeroMini"></canvas>
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
            <span class="st-feature-card__ic">🛡️</span>
            <h3>Verifikasi berlapis</h3>
            <p>Setiap pendaftaran dan laporan panen melewati persetujuan pengurus sebelum tercatat resmi.</p>
          </div>
          <div class="st-feature-card" data-reveal>
            <span class="st-feature-card__ic">🤝</span>
            <h3>Bagi hasil proporsional</h3>
            <p>Perhitungan otomatis berdasarkan kontribusi panen tiap anggota, bukan tebak-tebakan manual.</p>
          </div>
          <div class="st-feature-card" data-reveal>
            <span class="st-feature-card__ic">📈</span>
            <h3>Laporan &amp; grafik tren</h3>
            <p>Produktivitas per anggota, komoditas, dan musim, siap diekspor ke PDF atau Excel.</p>
          </div>
          <div class="st-feature-card" data-reveal>
            <span class="st-feature-card__ic">🔔</span>
            <h3>Notifikasi status</h3>
            <p>Petani mendapat kabar setiap kali pendaftaran, panen, atau bagi hasil diproses.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ GRAFIK / STATISTIK ============ -->
    <section class="st-stats" id="grafik" data-nav-class="st-nav--khaki">
      <div class="st-container">
        <p class="st-eyebrow">Grafik &amp; Statistik</p>
        <h2 class="st-section-title">Perkembangan kelompok tani, terlihat jelas dalam angka</h2>

        <div class="st-stats__grid">
          <div class="st-stats__card" data-reveal>
            <div class="st-stats__card-head">
              <h3>Produktivitas Panen per Musim</h3>
              <span class="st-badge st-badge--success">+18% musim ini</span>
            </div>
            <canvas id="chartPanen" height="220"></canvas>
          </div>

          <div class="st-stats__card" data-reveal>
            <div class="st-stats__card-head">
              <h3>Pertumbuhan Anggota</h3>
              <span class="st-badge st-badge--success">42 anggota aktif</span>
            </div>
            <canvas id="chartAnggota" height="220"></canvas>
          </div>

          <div class="st-stats__card st-stats__card--wide" data-reveal>
            <div class="st-stats__card-head">
              <h3>Komposisi Komoditas Terdistribusi</h3>
              <span class="st-badge st-badge--pending">Musim I · 2026</span>
            </div>
            <canvas id="chartKomoditas" height="140"></canvas>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ EDUKASI / ARTIKEL PETANI ============ -->
    <section class="st-edu" id="edukasi">
      <div class="st-container">
        <p class="st-eyebrow">Edukasi Petani</p>
        <h2 class="st-section-title">Artikel dan tips seputar budidaya &amp; hasil panen</h2>

        <div class="st-edu__grid">
          <article class="st-edu-card" data-reveal>
            <div class="st-edu-card__banner st-edu-card__banner--a">
              <span>🌾</span>
            </div>
            <div class="st-edu-card__body">
              <span class="st-edu-card__tag">Budidaya</span>
              <h3>5 Cara Meningkatkan Hasil Panen Padi</h3>
              <p>Pengaturan jarak tanam, pemupukan berimbang, dan pengelolaan air yang tepat terbukti menaikkan produktivitas lahan.</p>
              <a href="https://pertanian.jatimprov.go.id/klinik-tani/cara-menanam-padi-yang-baik-dan-benar/" class="st-edu-card__link" target="_blank" rel="noopener noreferrer">
                Baca selengkapnya → <span class="st-edu-card__src">pertanian.jatimprov.go.id</span>
              </a>
            </div>
          </article>

          <article class="st-edu-card" data-reveal>
            <div class="st-edu-card__banner st-edu-card__banner--b">
              <span>🐛</span>
            </div>
            <div class="st-edu-card__body">
              <span class="st-edu-card__tag">Hama &amp; Penyakit</span>
              <h3>Mengenali Hama Wereng Sejak Dini</h3>
              <p>Deteksi dini dan penanganan hama wereng bisa mencegah gagal panen. Kenali tanda-tanda serangan pada daun dan batang.</p>
              <a href="https://blog.agriagent.co.id/hama-wereng-cokelat-cara-mengenali-mencegah-dan-membasminya-sebelum-terlambat/" class="st-edu-card__link" target="_blank" rel="noopener noreferrer">
                Baca selengkapnya → <span class="st-edu-card__src">blog.agriagent.co.id</span>
              </a>
            </div>
          </article>

          <article class="st-edu-card" data-reveal>
            <div class="st-edu-card__banner st-edu-card__banner--c">
              <span>💰</span>
            </div>
            <div class="st-edu-card__body">
              <span class="st-edu-card__tag">Bagi Hasil</span>
              <h3>Memahami Skema Bagi Hasil Proporsional</h3>
              <p>Kajian tentang bagaimana kontribusi hasil panen tiap pihak dihitung secara adil dan transparan dalam usaha tani bersama.</p>
              <a href="https://media.neliti.com/media/publications/289944-sistem-bagi-hasil-pertanian-pada-masyara-8641722b.pdf" class="st-edu-card__link" target="_blank" rel="noopener noreferrer">
                Baca selengkapnya → <span class="st-edu-card__src">media.neliti.com</span>
              </a>
            </div>
          </article>

          <article class="st-edu-card" data-reveal>
            <div class="st-edu-card__banner st-edu-card__banner--d">
              <span>🚜</span>
            </div>
            <div class="st-edu-card__body">
              <span class="st-edu-card__tag">Teknologi Tani</span>
              <h3>Mencatat Panen Digital, Kenapa Penting?</h3>
              <p>Pencatatan digital mengurangi selisih data, mempercepat verifikasi, dan membuat laporan lebih mudah diaudit.</p>
              <a href="https://taniin.id/8-keunggulan-pertanian-digital-yang-perlu-anda-ketahui/" class="st-edu-card__link" target="_blank" rel="noopener noreferrer">
                Baca selengkapnya → <span class="st-edu-card__src">taniin.id</span>
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ============ ULASAN ============ -->
    <section class="st-reviews" id="ulasan" data-nav-class="st-nav--dark">
      <div class="st-container">
        <p class="st-eyebrow st-eyebrow--light">Ulasan</p>
        <h2 class="st-section-title st-section-title--light">Kata mereka yang sudah pakai SiTani</h2>

        <div class="st-reviews__grid">
          <article class="st-review-card" data-reveal>
            <div class="st-review-card__stars">★★★★★</div>
            <p>“Sejak pakai SiTani, catatan panen kelompok kami rapi. Bagi hasil juga jadi lebih transparan ke semua anggota.”</p>
            <div class="st-review-card__who">
              <span class="st-review-card__avatar">SP</span>
              <div>
                <strong>Sutar Pranoto</strong>
                <span>Petani — Poktan Sumber Makmur</span>
              </div>
            </div>
          </article>

          <article class="st-review-card" data-reveal>
            <div class="st-review-card__stars">★★★★★</div>
            <p>“Proses verifikasi anggota baru dan hasil panen jauh lebih cepat. Tidak perlu lagi rekap manual pakai buku.”</p>
            <div class="st-review-card__who">
              <span class="st-review-card__avatar">RW</span>
              <div>
                <strong>Ratna Wulandari</strong>
                <span>Pengurus — Poktan Tani Jaya</span>
              </div>
            </div>
          </article>

          <article class="st-review-card" data-reveal>
            <div class="st-review-card__stars">★★★★☆</div>
            <p>“Laporan grafik produktivitas sangat membantu saat presentasi ke dinas pertanian. Ekspor PDF-nya juga rapi.”</p>
            <div class="st-review-card__who">
              <span class="st-review-card__avatar">AH</span>
              <div>
                <strong>Agus Hidayat</strong>
                <span>Admin — Poktan Subur Abadi</span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="st-faq" id="faq">
      <div class="st-container st-faq__inner">
        <div>
          <p class="st-eyebrow">FAQ</p>
          <h2 class="st-section-title">Pertanyaan yang sering diajukan</h2>
          <p class="st-faq__desc">Tidak menemukan jawabannya? Gunakan fitur chat untuk bertanya langsung ke pengurus atau petani lain.</p>
        </div>

        <div class="st-faq__list">
          <div class="st-faq-item is-open">
            <button class="st-faq-item__q" type="button">
              <span>Bagaimana cara mendaftar sebagai anggota kelompok tani?</span>
              <span class="st-faq-item__icon">＋</span>
            </button>
            <div class="st-faq-item__a">
              <p>Klik tombol "Daftar Kelompok" di navbar, isi data diri dan data lahan, lalu tunggu verifikasi dari pengurus kelompok tani Anda.</p>
            </div>
          </div>

          <div class="st-faq-item">
            <button class="st-faq-item__q" type="button">
              <span>Berapa lama proses verifikasi hasil panen?</span>
              <span class="st-faq-item__icon">＋</span>
            </button>
            <div class="st-faq-item__a">
              <p>Verifikasi dilakukan oleh pengurus setelah data panen diinput. Umumnya diproses dalam 1–2 hari kerja tergantung aktivitas pengurus kelompok.</p>
            </div>
          </div>

          <div class="st-faq-item">
            <button class="st-faq-item__q" type="button">
              <span>Apakah bagi hasil dihitung otomatis oleh sistem?</span>
              <span class="st-faq-item__icon">＋</span>
            </button>
            <div class="st-faq-item__a">
              <p>Ya, bagi hasil dihitung secara proporsional berdasarkan kontribusi hasil panen tiap anggota yang sudah disetujui pengurus.</p>
            </div>
          </div>

          <div class="st-faq-item">
            <button class="st-faq-item__q" type="button">
              <span>Bisakah laporan diekspor ke PDF atau Excel?</span>
              <span class="st-faq-item__icon">＋</span>
            </button>
            <div class="st-faq-item__a">
              <p>Bisa. Admin dan pengurus dapat mengekspor laporan produktivitas dan distribusi ke format PDF maupun Excel kapan saja.</p>
            </div>
          </div>

          <div class="st-faq-item">
            <button class="st-faq-item__q" type="button">
              <span>Bagaimana cara menghubungi petani atau pengurus lain?</span>
              <span class="st-faq-item__icon">＋</span>
            </button>
            <div class="st-faq-item__a">
              <p>Gunakan ikon chat pada navbar atau tombol chat mengambang di pojok kanan bawah halaman untuk mengirim pesan langsung.</p>
            </div>
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
<x-footer />

  <!-- ============ CHAT WIDGET (Chat ke Petani/Pengurus) ============ -->
  <div class="st-chat" id="stChatWidget">
    <button class="st-chat__fab" id="stChatFab" aria-label="Buka chat petani">
      <svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v11H8l-4 4V5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
      <span class="st-chat__fab-dot"></span>
    </button>

    <div class="st-chat__panel" id="stChatPanel" hidden>
      <div class="st-chat__head">
        <div>
          <strong>Chat Petani &amp; Pengurus</strong>
          <span><i></i>Online — biasanya balas cepat</span>
        </div>
        <button class="st-chat__close" id="stChatClose" aria-label="Tutup chat">✕</button>
      </div>

      <div class="st-chat__body" id="stChatBody">
        <div class="st-chat__msg st-chat__msg--in">
          Halo! 👋 Selamat datang di SiTani. Ada yang bisa dibantu seputar pendaftaran, panen, atau bagi hasil?
        </div>
      </div>

      <form class="st-chat__input" id="stChatForm">
        <input type="text" id="stChatInput" placeholder="Tulis pesan..." autocomplete="off">
        <button type="submit" aria-label="Kirim pesan">
          <svg viewBox="0 0 24 24" fill="none"><path d="M4 12 20 4l-6 16-2.5-7L4 12Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </button>
      </form>
    </div>
  </div>

  <script>
    window.SITANI_CSRF_TOKEN = "{{ csrf_token() }}";
    window.SITANI_PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
    window.SITANI_PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
    @auth
    window.SITANI_USER = { id: {{ auth()->id() }}, name: @json(auth()->user()->name), role: @json(auth()->user()->role) };
    @endauth
  </script>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
  <script src="{{ asset('js/realtime.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>