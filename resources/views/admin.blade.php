<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('images/logo-sitani-256.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard Admin — SiTani</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengurus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="st-dashboard-body">

    <button class="st-dash-toggle" id="stDashToggle" aria-label="Toggle Sidebar">
        <span class="material-icons">menu</span>
    </button>

    <div class="st-dash-wrapper">

        <x-sidebar role="admin" />

        <main class="st-dash-main">

            <header class="st-dash-header">
                <div>
                    <h1 class="st-dash-title">Kontrol Sistem SiTani</h1>
                    <p class="st-dash-subtitle">Kelola pengguna, pantau seluruh laporan panen, dan ekspor data dari satu panel terpusat.</p>
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

            {{-- ================= RINGKASAN ================= --}}
            <section class="st-dash-grid" id="ringkasan">
                <div class="st-stat-card">
                    <div class="st-stat-icon card-icon-green"><span class="material-icons">groups</span></div>
                    <div class="st-stat-info">
                        <span class="st-stat-label">Total Pengguna Terdaftar</span>
                        <h2 class="st-stat-value">{{ $totalPengguna }} Akun</h2>
                    </div>
                </div>
                <div class="st-stat-card">
                    <div class="st-stat-icon card-icon-yellow"><span class="material-icons">pending_actions</span></div>
                    <div class="st-stat-info">
                        <span class="st-stat-label">Menunggu Verifikasi Pengurus</span>
                        <h2 class="st-stat-value">{{ $menungguVerifikasi }} Laporan</h2>
                    </div>
                </div>
                <div class="st-stat-card">
                    <div class="st-stat-icon card-icon-blue"><span class="material-icons">scale</span></div>
                    <div class="st-stat-info">
                        <span class="st-stat-label">Total Volume Panen Disetujui</span>
                        <h2 class="st-stat-value">{{ number_format($totalVolumeDisetujui, 0, ',', '.') }} Kg</h2>
                    </div>
                </div>
                <div class="st-stat-card">
                    <div class="st-stat-icon card-icon-purple"><span class="material-icons">payments</span></div>
                    <div class="st-stat-info">
                        <span class="st-stat-label">Total Estimasi Bagi Hasil</span>
                        <h2 class="st-stat-value">Rp {{ number_format($totalBagiHasil, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </section>

            <section class="st-two-col">
                <div class="st-table-section">
                    <div class="st-section-header">
                        <h2 class="st-section-title">Komposisi Peran Pengguna</h2>
                        <p class="st-section-subtitle">Distribusi akun aktif berdasarkan peran di sistem SiTani.</p>
                    </div>
                    <div class="st-mini-list">
                        <div class="st-mini-item">
                            <strong>Petani</strong>
                            <span>{{ $totalPetani }} akun</span>
                        </div>
                        <div class="st-mini-item">
                            <strong>Pengurus</strong>
                            <span>{{ $totalPengurus }} akun</span>
                        </div>
                        <div class="st-mini-item">
                            <strong>Admin</strong>
                            <span>{{ $totalAdmin }} akun</span>
                        </div>
                    </div>
                </div>

                <div class="st-table-section">
                    <div class="st-section-header">
                        <h2 class="st-section-title">Komoditas Terbanyak Dilaporkan</h2>
                        <p class="st-section-subtitle">Berdasarkan total berat seluruh laporan panen.</p>
                    </div>
                    <div class="st-mini-list">
                        @forelse ($komoditasTerbanyak as $komoditas)
                            <div class="st-mini-item">
                                <strong>{{ $komoditas->komoditas }}</strong>
                                <span>{{ number_format($komoditas->total_berat, 0, ',', '.') }} Kg &middot; {{ $komoditas->jumlah }} laporan</span>
                            </div>
                        @empty
                            <p class="text-muted" style="font-size: 14px;">Belum ada data panen yang tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- ================= KELOLA PENGGUNA ================= --}}
            <section class="st-table-section" id="kelola-pengguna" style="margin-bottom: 24px;">
                <div class="st-section-header">
                    <h2 class="st-section-title">Kelola Pengguna</h2>
                    <p class="st-section-subtitle">Ubah peran akun atau hapus pengguna dari sistem. Anda tidak dapat mengubah/menghapus akun Anda sendiri.</p>
                </div>

                <div class="st-table-responsive">
                    <table class="st-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Laporan Panen</th>
                                <th style="min-width: 260px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($daftarPengguna as $pengguna)
                                <tr>
                                    <td><strong>{{ $pengguna->name }}</strong></td>
                                    <td class="text-mono">{{ $pengguna->email }}</td>
                                    <td>
                                        <span class="st-badge-role st-badge-role--{{ strtolower($pengguna->role) }}">{{ $pengguna->role }}</span>
                                    </td>
                                    <td class="text-mono">{{ $pengguna->panens_count }}</td>
                                    <td>
                                        <div class="st-row-actions">
                                            @if ($pengguna->id !== Auth::id())
                                                <form action="{{ route('admin.pengguna.role', $pengguna) }}" method="POST" class="st-role-form">
                                                    @csrf
                                                    <select name="role" class="st-role-select">
                                                        <option value="Petani" @selected($pengguna->role === 'Petani')>Petani</option>
                                                        <option value="Pengurus" @selected($pengguna->role === 'Pengurus')>Pengurus</option>
                                                        <option value="Admin" @selected($pengguna->role === 'Admin')>Admin</option>
                                                    </select>
                                                    <button type="submit" class="st-icon-btn st-icon-btn--save" title="Simpan peran">
                                                        <span class="material-icons" style="font-size: 18px;">save</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pengguna.hapus', $pengguna) }}" method="POST"
                                                      onsubmit="return confirm('Hapus akun {{ $pengguna->name }} secara permanen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="st-icon-btn st-icon-btn--danger" title="Hapus akun">
                                                        <span class="material-icons" style="font-size: 18px;">delete</span>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted" style="font-size: 13px;">Akun Anda saat ini</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted" style="padding: 24px 0;">Belum ada pengguna terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- ================= DATA PANEN SELURUH SISTEM ================= --}}
            <section class="st-table-section" id="data-panen">
                <div class="st-section-header">
                    <h2 class="st-section-title">Data Panen Seluruh Sistem</h2>
                    <p class="st-section-subtitle">Rekap seluruh laporan panen dari semua kelompok tani, lintas status verifikasi.</p>
                </div>

                <div class="st-filter-bar">
                    <div class="st-filter-tabs">
                        <a href="{{ route('admin.dashboard') }}#data-panen" class="st-filter-tab {{ !$statusFilter ? 'is-active' : '' }}">Semua</a>
                        <a href="{{ route('admin.dashboard', ['status' => 'menunggu']) }}#data-panen" class="st-filter-tab {{ $statusFilter === 'menunggu' ? 'is-active' : '' }}">Menunggu</a>
                        <a href="{{ route('admin.dashboard', ['status' => 'disetujui']) }}#data-panen" class="st-filter-tab {{ $statusFilter === 'disetujui' ? 'is-active' : '' }}">Disetujui</a>
                        <a href="{{ route('admin.dashboard', ['status' => 'ditolak']) }}#data-panen" class="st-filter-tab {{ $statusFilter === 'ditolak' ? 'is-active' : '' }}">Ditolak</a>
                    </div>
                    <a href="{{ route('admin.panen.ekspor') }}" class="st-btn st-btn--outline st-export-btn">
                        <span class="material-icons" style="font-size: 18px;">file_download</span> Ekspor CSV
                    </a>
                </div>

                <div class="st-table-responsive">
                    <table class="st-table">
                        <thead>
                            <tr>
                                <th>No. Nota</th>
                                <th>Petani</th>
                                <th>Komoditas</th>
                                <th>Berat</th>
                                <th>Musim</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($seluruhPanen as $panen)
                                <tr>
                                    <td class="text-mono">{{ $panen->no_nota }}</td>
                                    <td><strong>{{ $panen->user->name ?? 'Tidak ditemukan' }}</strong></td>
                                    <td>{{ $panen->komoditas }}</td>
                                    <td class="text-mono font-bold text-success">{{ number_format($panen->berat, 0, ',', '.') }} Kg</td>
                                    <td>{{ $panen->musim }}</td>
                                    <td>
                                        @if ($panen->status === 'menunggu')
                                            <span class="st-badge st-badge--pending">Menunggu</span>
                                        @elseif ($panen->status === 'disetujui')
                                            <span class="st-badge st-badge--success">Disetujui</span>
                                        @else
                                            <span class="st-badge st-badge--danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $panen->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted" style="padding: 24px 0;">Tidak ada data panen untuk filter ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $seluruhPanen->links() }}
            </section>

        </main>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    <x-realtime-scripts />
</body>
</html>
