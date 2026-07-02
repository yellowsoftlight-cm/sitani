<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Kendali Eksekutif - SiTani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #0f172a; font-family: 'Inter', system-ui, sans-serif; color: #e2e8f0; }
        .sidebar-admin { background-color: #1e293b; min-height: 100vh; border-right: 1px solid #334155; }
        .nav-admin-link { color: #94a3b8; display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 8px; text-decoration: none; transition: 0.2s; margin-bottom: 6px; font-size: 0.95rem; }
        .nav-admin-link:hover, .nav-admin-link.active { background-color: #059669; color: #ffffff; }
        .admin-profile-box { background-color: #0f172a; border-radius: 10px; padding: 12px; border: 1px solid #334155; }
        .admin-main-content { padding: 40px; }
        .admin-card { background-color: #1e293b; border: 1px solid #334155; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .table-custom { color: #e2e8f0; }
        .table-custom th { background-color: #0f172a !important; color: #94a3b8 !important; border-color: #334155 !important; }
        .table-custom td { background-color: #1e293b !important; border-color: #334155 !important; vertical-align: middle; }
        .btn-admin-logout { background: none; border: none; width: 100%; text-align: left; }
        .activity-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR ADMIN -->
        <div class="col-md-3 col-lg-2 sidebar-admin p-3 d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex align-items-center gap-2 mb-4 px-2">
                    <div class="bg-emerald-600 rounded p-1" style="background-color: #059669;">
                        <i class="bi bi-cpu text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white" style="letter-spacing: 0.5px;">SITANI</h4>
                        <small class="text-uppercase text-muted" style="font-size: 0.65rem; color: #64748b; font-weight: 700;">HQ Control Console</small>
                    </div>
                </div>

                <div class="admin-profile-box d-flex align-items-center gap-3 mb-4">
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #334155;">
                        <i class="bi bi-shield-lock-fill text-warning"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-semibold text-white text-truncate" style="font-size: 0.85rem;">{{ Auth::user()->name }}</h6>
                        <span class="text-success" style="font-size: 0.7rem; font-weight: 600;"><i class="bi bi-dot"></i> Super Admin</span>
                    </div>
                </div>

                <nav>
                    <small class="text-uppercase text-muted px-2 d-block mb-2" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 1px;">Menu Utama</small>
                    <a href="#" class="nav-admin-link active"><i class="bi bi-speedometer"></i> Dashboard Utama</a>
                    <a href="#" class="nav-admin-link"><i class="bi bi-people-fill"></i> Manajemen Anggota</a>
                    <a href="#" class="nav-admin-link"><i class="bi bi-journal-check"></i> Validasi Panen</a>
                    <a href="#" class="nav-admin-link"><i class="bi bi-cart-fill"></i> Distribusi Pasar</a>
                    <a href="#" class="nav-admin-link"><i class="bi bi-bar-chart-line-fill"></i> Laporan Produktivitas</a>
                    
                    <small class="text-uppercase text-muted px-2 d-block mt-4 mb-2" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 1px;">Sistem</small>
                    <a href="#" class="nav-admin-link"><i class="bi bi-gear-fill"></i> Konfigurasi Aplikasi</a>
                    <a href="#" class="nav-admin-link"><i class="bi bi-shield-shaded"></i> Log Keamanan</a>
                </nav>
            </div>

            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-admin-link btn-admin-logout" style="color: #f87171;">
                        <i class="bi bi-terminal-x"></i> Hentikan Sesi
                    </button>
                </form>
            </div>
        </div>

        <!-- MAIN CONTENT ADMIN -->
        <div class="col-md-9 col-lg-10 admin-main-content">
            <!-- Header Atas -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: #334155 !important;">
                <div>
                    <h3 class="fw-bold text-white m-0">Konsol Eksekutif</h3>
                    <p class="text-muted mb-0" style="color: #94a3b8 !important;">Selamat bertugas kembali, <span class="text-emerald-400 fw-semibold" style="color: #34d399;">{{ Auth::user()->name }}</span>.</p>
                </div>
                <div class="d-flex gap-3">
                    <div class="badge bg-dark border p-2.5 px-3 text-secondary d-flex align-items-center gap-2" style="border-color: #334155 !important; border-radius: 8px;">
                        <span class="activity-dot bg-success"></span> Database: Terhubung
                    </div>
                    <div class="badge bg-dark border p-2.5 px-3 text-secondary d-flex align-items-center gap-2" style="border-color: #334155 !important; border-radius: 8px;">
                        <i class="bi bi-calendar3 text-info"></i> Sesi Aktif: {{ date('d M Y') }}
                    </div>
                </div>
            </div>

            <!-- Baris Statistik Utama -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card admin-card p-3 d-flex flex-row align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem; font-weight: 600;">TOTAL PENGGUNA</p>
                            <h3 class="fw-bold text-white mb-0">142 User</h3>
                            <small class="text-success" style="font-size: 0.75rem;"><i class="bi bi-caret-up-fill"></i> +8 Baru</small>
                        </div>
                        <div class="fs-2 text-primary p-2 opacity-50"><i class="bi bi-people"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card admin-card p-3 d-flex flex-row align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem; font-weight: 600;">TOTAL HASIL PANEN</p>
                            <h3 class="fw-bold text-white mb-0">12.840 Kg</h3>
                            <small class="text-muted" style="font-size: 0.75rem;">Semua Komoditas</small>
                        </div>
                        <div class="fs-2 text-success p-2 opacity-50"><i class="bi bi-cone-striped"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card admin-card p-3 d-flex flex-row align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem; font-weight: 600;">PENDISTRIBUSIAN</p>
                            <h3 class="fw-bold text-white mb-0">42 Mitra</h3>
                            <small class="text-info" style="font-size: 0.75rem;">Pasar & Pengepul</small>
                        </div>
                        <div class="fs-2 text-info p-2 opacity-50"><i class="bi bi-truck"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card admin-card p-3 d-flex flex-row align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem; font-weight: 600;">BUTUH VALIDASI</p>
                            <h3 class="fw-bold text-warning mb-0">7 Berkas</h3>
                            <small class="text-warning" style="font-size: 0.75rem;"><i class="bi bi-exclamation-circle-fill"></i> Segera Periksa</small>
                        </div>
                        <div class="fs-2 text-warning p-2 opacity-50"><i class="bi bi-file-earmark-diff"></i></div>
                    </div>
                </div>
            </div>

            <!-- Baris Konten Utama (Tabel dan Log Aktivitas) -->
            <div class="row g-4">
                <!-- Kolom Kiri: Tabel Manajemen Anggota Terbaru -->
                <div class="col-lg-8">
                    <div class="card admin-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-white mb-0"><i class="bi bi-person-lines-fill text-success"></i> Anggota Poktan Terdaftar Terbaru</h5>
                            <button class="btn btn-sm btn-outline-light" style="font-size: 0.8rem;">Lihat Semua</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Anggota</th>
                                        <th>Email</th>
                                        <th>Grup Hak Akses</th>
                                        <th>Status Registrasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold text-white">Suryadi Kelana</td>
                                        <td>suryadi@gmail.com</td>
                                        <td><span class="badge bg-success-subtle text-success px-2 py-1">Petani</span></td>
                                        <td><span class="text-success" style="font-size: 0.85rem;"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-white">Nenden Herlina</td>
                                        <td>nenden.h@gmail.com</td>
                                        <td><span class="badge bg-warning-subtle text-warning px-2 py-1">Pengurus</span></td>
                                        <td><span class="text-success" style="font-size: 0.85rem;"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-white">Eko Prasetyo</td>
                                        <td>ekopras@gmail.com</td>
                                        <td><span class="badge bg-success-subtle text-success px-2 py-1">Petani</span></td>
                                        <td><span class="text-warning" style="font-size: 0.85rem;"><i class="bi bi-hourglass-split"></i> Menunggu</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Log Aktivitas Sistem Terkini -->
                <div class="col-lg-4">
                    <div class="card admin-card p-4">
                        <h5 class="fw-bold text-white mb-3"><i class="bi bi-terminal text-info"></i> Log Aktivitas Sistem</h5>
                        
                        <div class="d-flex flex-column gap-3">
                            <div class="border-start border-2 ps-3" style="border-color: #059669 !important;">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">10 Menit Lalu</small>
                                <span class="d-block text-white" style="font-size: 0.85rem;"><strong>Suryadi</strong> menambahkan entri panen Padi (450 Kg)</span>
                            </div>

                            <div class="border-start border-2 ps-3" style="border-color: #3b82f6 !important;">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">1 Jam Lalu</small>
                                <span class="d-block text-white" style="font-size: 0.85rem;"><strong>Pengurus (Nenden)</strong> memvalidasi data pengiriman Cabai</span>
                            </div>

                            <div class="border-start border-2 ps-3" style="border-color: #f59e0b !important;">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">3 Jam Lalu</small>
                                <span class="d-block text-white" style="font-size: 0.85rem;">User Baru <strong>Eko Prasetyo</strong> mendaftar ke sistem</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>