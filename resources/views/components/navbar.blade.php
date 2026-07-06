<header class="st-nav">
    <div class="st-container st-nav__inner">

      <a href="{{ url('/') }}" class="st-nav__brand">
        <span class="st-nav__icon">
          <img src="{{ asset('images/logo-sitani.png') }}" alt="Logo SiTani" class="st-nav__logo-img">
        </span>
        <span class="st-nav__brand-text">
          <span class="st-nav__mark">SiTani</span>
          <span class="st-nav__tag">Sistem Tani</span>
        </span>
      </a>

      <nav class="st-nav__links" id="stNavLinks">
        <a href="#alur"><span>Alur Kerja</span></a>
        <a href="#peran"><span>Peran</span></a>
        <a href="#fitur"><span>Fitur</span></a>
        <a href="#edukasi"><span>Edukasi</span></a>
        <a href="#ulasan"><span>Ulasan</span></a>
        <a href="#faq"><span>FAQ</span></a>
      </nav>

      <div class="st-nav__actions">

        <div class="st-nav__util" id="stNotifUtil">
          <button type="button" class="st-nav__iconbtn" id="stNotifToggle" aria-label="Buka notifikasi" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none"><path d="M6 8a6 6 0 1 1 12 0c0 4 1.5 5.5 2 6H4c.5-.5 2-2 2-6Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9.5 19a2.5 2.5 0 0 0 5 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            <span class="st-nav__dot" id="stNotifDot" hidden></span>
          </button>

          <div class="st-notif-panel" id="stNotifPanel" hidden>
            <div class="st-notif-panel__head">
              <span>Notifikasi</span>
              <span class="st-notif-panel__live"><i></i>Real-time</span>
            </div>
            <ul class="st-notif-panel__list" id="stNotifList">
              <li class="st-notif-item" data-seed>
                <span class="st-notif-item__ic">✓</span>
                <div>
                  <p>Verifikasi pendaftaran anggota berhasil disetujui pengurus.</p>
                  <time>Baru saja</time>
                </div>
              </li>
              <li class="st-notif-item" data-seed>
                <span class="st-notif-item__ic">🌾</span>
                <div>
                  <p>Input hasil panen Padi 1.250 kg menunggu verifikasi.</p>
                  <time>12 menit lalu</time>
                </div>
              </li>
            </ul>
          </div>
        </div>

        <button type="button" class="st-nav__iconbtn st-nav__theme" id="stThemeToggle" aria-label="Ganti tema gelap/terang">
          <svg class="st-icon-sun" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4.2" stroke="currentColor" stroke-width="1.6"/><path d="M12 2.5v2.4M12 19.1v2.4M4.2 4.2l1.7 1.7M18.1 18.1l1.7 1.7M2.5 12h2.4M19.1 12h2.4M4.2 19.8l1.7-1.7M18.1 5.9l1.7-1.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
          <svg class="st-icon-moon" viewBox="0 0 24 24" fill="none"><path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a6.8 6.8 0 0 0 10.5 10.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </button>

        <span class="st-nav__sep"></span>

        @guest
          <a href="{{ route('login') }}" class="st-btn st-btn--ghost">Masuk</a>
          <a href="{{ route('register') }}" class="st-btn st-btn--solid">Daftar Kelompok</a>
        @endguest

        @auth
          @if(Auth::user()->role === 'Admin')
            <a href="{{ route('admin.dashboard') }}" class="st-btn st-btn--ghost">Dashboard</a>
          @elseif(Auth::user()->role === 'Pengurus')
            <a href="{{ route('pengurus.dashboard') }}" class="st-btn st-btn--ghost">Dashboard</a>
          @else
            <a href="{{ route('petani.dashboard') }}" class="st-btn st-btn--ghost">Dashboard</a>
          @endif

          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="st-btn st-btn--solid" style="border: none; cursor: pointer;">Keluar</button>
          </form>
        @endauth
      </div>

      <div class="st-nav__mobile-utils">
        <button type="button" class="st-nav__iconbtn st-nav__theme" id="stThemeToggleMobile" aria-label="Ganti tema gelap/terang">
          <svg class="st-icon-sun" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4.2" stroke="currentColor" stroke-width="1.6"/><path d="M12 2.5v2.4M12 19.1v2.4M4.2 4.2l1.7 1.7M18.1 18.1l1.7 1.7M2.5 12h2.4M19.1 12h2.4M4.2 19.8l1.7-1.7M18.1 5.9l1.7-1.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
          <svg class="st-icon-moon" viewBox="0 0 24 24" fill="none"><path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a6.8 6.8 0 0 0 10.5 10.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </button>
        <button class="st-nav__toggle" id="stNavToggle" aria-label="Buka menu" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
</header>
