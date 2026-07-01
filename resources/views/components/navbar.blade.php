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
