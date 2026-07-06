@props(['role' => 'petani'])

@php
    $roleMap = [
        'admin'    => ['tag' => 'Panel Admin',    'idSuffix' => 'ADMIN',   'tagMod' => 'st-nav__tag--admin'],
        'pengurus' => ['tag' => 'Panel Pengurus', 'idSuffix' => 'PENGURUS','tagMod' => 'st-nav__tag--pengurus'],
        'petani'   => ['tag' => 'Panel Petani',   'idSuffix' => 'POKTAN',  'tagMod' => 'st-nav__tag--petani'],
    ];
    $meta = $roleMap[$role] ?? $roleMap['petani'];
    $userId = str_pad(Auth::id(), 4, '0', STR_PAD_LEFT);
@endphp

<aside class="st-sidebar" id="stSidebar">

    {{-- ============ HEAD (logo + brand + tag) ============ --}}
    <div class="st-sidebar__head">
        <img
            src="{{ asset('images/logo-sitani-256.png') }}"
            alt="Logo SiTani"
            class="st-sidebar__logo-img"
        >
        <div class="st-sidebar__brand">
            <span class="st-nav__mark">SiTani</span>
            <span class="st-nav__tag {{ $meta['tagMod'] }}">{{ $meta['tag'] }}</span>
        </div>
    </div>

    {{-- ============ USER CARD ============ --}}
    <div class="st-sidebar__user">
        <div class="st-user-avatar">
            <span class="material-icons">account_circle</span>
        </div>
        <div class="st-sidebar__user-info">
            <div class="st-user-name">{{ Auth::user()->name }}</div>
            <div class="st-user-meta">ID: {{ $userId }}/{{ $meta['idSuffix'] }}</div>
        </div>
    </div>

    {{-- ============ NAV ============ --}}
    <nav class="st-sidebar__nav">
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}#ringkasan" class="st-sidebar__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <span class="material-icons st-sidebar__icon">dashboard</span>
                <span class="st-sidebar__label">Ringkasan Sistem</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#kelola-pengguna" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">people</span>
                <span class="st-sidebar__label">Kelola Pengguna</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#data-panen" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">grass</span>
                <span class="st-sidebar__label">Data Panen Sistem</span>
            </a>
            <a href="{{ route('admin.panen.ekspor') }}" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">file_download</span>
                <span class="st-sidebar__label">Ekspor Data (CSV)</span>
            </a>

        @elseif($role === 'pengurus')
            <a href="{{ route('pengurus.dashboard') }}#ringkasan" class="st-sidebar__link is-active">
                <span class="material-icons st-sidebar__icon">dashboard</span>
                <span class="st-sidebar__label">Ringkasan Kelompok</span>
            </a>
            <a href="{{ route('pengurus.dashboard') }}#verifikasi-panen" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">fact_check</span>
                <span class="st-sidebar__label">Verifikasi Hasil Tani</span>
            </a>
            <a href="{{ route('pengurus.dashboard') }}#data-anggota" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">groups</span>
                <span class="st-sidebar__label">Data Anggota Poktan</span>
            </a>
            <a href="{{ route('pengurus.dashboard') }}#distribusi-pasar" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">local_shipping</span>
                <span class="st-sidebar__label">Distribusi ke Pasar</span>
            </a>

        @else
            <a href="#ringkasan" class="st-sidebar__link is-active">
                <span class="material-icons st-sidebar__icon">dashboard</span>
                <span class="st-sidebar__label">Ringkasan Tani</span>
            </a>
            <a href="#input-panen" class="st-sidebar__link" id="triggerFormPanen">
                <span class="material-icons st-sidebar__icon">grass</span>
                <span class="st-sidebar__label">Input Hasil Panen</span>
            </a>
            <a href="#riwayat" class="st-sidebar__link">
                <span class="material-icons st-sidebar__icon">history_edu</span>
                <span class="st-sidebar__label">Riwayat Verifikasi</span>
            </a>
        @endif
    </nav>

    {{-- ============ FOOT ============ --}}
    <div class="st-sidebar__foot">
        <a href="#" class="st-btn st-btn--outline st-logout-btn"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <span class="material-icons st-logout-btn__icon">logout</span>
            <span>Keluar Sistem</span>
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</aside>
