@props(['role' => 'petani']) {{-- Menetapkan default role sebagai petani jika tidak didefinisikan --}}

<aside class="st-sidebar" id="stSidebar">
    <div class="st-sidebar__head">
      <img src="{{ asset('images/logo-sitani-256.png') }}" alt="Logo SiTani" class="st-sidebar__logo-img">
      <span class="st-nav__mark">SiTani</span>
      <span class="st-nav__tag">
        {{ $role === 'admin' ? 'Panel Admin' : 'Panel Petani' }}
      </span>
    </div>
    
    <div class="st-sidebar__user">
      <div class="st-user-avatar">
        <span class="material-icons">account_circle</span>
      </div>
      <div>
        @if($role === 'admin')
          <div class="st-user-name">{{ Auth::user()->name }}</div>
          <div class="st-user-meta">ID: ADM-{{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</div>
        @else
          <div class="st-user-name">{{ Auth::user()->name }}</div>
          <div class="st-user-meta">ID: {{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}/POKTAN</div>
        @endif
      </div>
    </div>

    <nav class="st-sidebar__nav">
      @if($role === 'admin')
        <a href="{{ route('admin.dashboard') }}#ringkasan" class="st-sidebar__link is-active">
          <span class="material-icons st-sidebar__icon">dashboard</span> Ringkasan Sistem
        </a>
        <a href="{{ route('admin.dashboard') }}#kelola-pengguna" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">people</span> Kelola Pengguna
        </a>
        <a href="{{ route('admin.dashboard') }}#data-panen" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">grass</span> Data Panen Sistem
        </a>
        <a href="{{ route('admin.panen.ekspor') }}" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">file_download</span> Ekspor Data (CSV)
        </a>

      @else
        <a href="#ringkasan" class="st-sidebar__link is-active">
          <span class="material-icons st-sidebar__icon">dashboard</span> Ringkasan Tani
        </a>
        <a href="#input-panen" class="st-sidebar__link" id="triggerFormPanen">
          <span class="material-icons st-sidebar__icon">grass</span> Input Hasil Panen
        </a>
        <a href="#riwayat" class="st-sidebar__link">
          <span class="material-icons st-sidebar__icon">history_edu</span> Riwayat Verifikasi
        </a>
      @endif
    </nav>

    <div class="st-sidebar__foot">
      <a href="#" class="st-btn st-btn--outline st-logout-btn"
         onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
        <span class="material-icons" style="font-size: 16px;">logout</span> Keluar Sistem
      </a>
      <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
      </form>
    </div>
</aside>