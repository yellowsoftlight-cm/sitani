<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Petani - SiTani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f7f5f0; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .sidebar { background: linear-gradient(135deg, #054a19, #0c5e23); min-height: 100vh; color: #f4f1ea; border-right: 4px solid #e2dbcd; position: sticky; top: 0; }
        .nav-link-custom { color: #d0ded2; display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 10px; text-decoration: none; transition: all 0.3s ease; margin-bottom: 8px; font-weight: 500; }
        .nav-link-custom:hover, .nav-link-custom.active { background-color: #ffffff; color: #054a19; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .profile-card { background-color: rgba(255, 255, 255, 0.1); border-radius: 14px; padding: 16px; margin-bottom: 30px; border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px); }
        .main-content { padding: 40px; }
        .stats-card { border: none; border-radius: 16px; background: white; box-shadow: 0 8px 24px rgba(5,74,25,0.04); border-bottom: 4px solid #054a19; }
        .data-card { border: none; border-radius: 16px; background: white; box-shadow: 0 8px 24px rgba(0,0,0,0.02); }
        .btn-logout { background: none; border: none; width: 100%; text-align: left; }
        .step-list { list-style: none; padding-left: 0; }
        .step-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px dashed #e2dbcd; }
        .step-item:last-child { border-bottom: none; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR PETANI -->
        <div class="col-md-3 col-lg-2 sidebar p-4 d-flex flex-column justify-content-between">
            <div>
                <div class="mb-4">
                    <h3 class="fw-bold mb-0 text-white">SiTani</h3>
                    <span class="badge bg-white text-success px-2 py-1 mt-1" style="font-size: 0.7rem; letter-spacing: 1px;">ANGGOTA AKTIF</span>
                </div>

                <div class="profile-card d-flex align-items-center gap-3">
                    <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="bi bi-person-bounding-box fs-5" style="color: #054a19;"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold text-white text-truncate">{{ Auth::user()->name }}</h6>
                        <small style="color: #c2e2cc; font-size: 0.75rem;"><i class="bi bi-patch-check"></i> {{ Auth::user()->role }}</small>
                    </div>
                </div>

                <nav>
                    <a href="#" class="nav-link-custom active"><i class="bi bi-house-heart"></i> Ringkasan Tani</a>
                    <a href="#" class="nav-link-custom"><i class="bi bi-plus-circle-dashed"></i> Catat Hasil Panen</a>
                    <a href="#" class="nav-link-custom"><i class="bi bi-truck"></i> Distribusi Pasar</a>
                </nav>
            </div>

            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link-custom btn-logout text-danger-light" style="color: #ffb3b3;">
                        <i class="bi bi-power"></i> Keluar Aplikasi
                    </button>
                </form>
            </div>
        </div>

        <!-- MAIN CONTENT PETANI -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-bold text-dark">Halo, Pak/Bu {{ Auth::user()->name }} 👋</h2>
                    <p class="text-secondary mb-0">Pantau produktivitas lahan, verifikasi berjenjang, dan pengiriman hasil pertanian Anda.</p>
                </div>
            </div>

            <!-- Ringkasan Statistik Utama -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card stats-card p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fw-medium" style="font-size: 0.8rem;">INPUT PANEN MUSIM INI</p>
                                <h2 class="fw-bold text-dark mb-0">1.250 <span style="font-size: 1.2rem; font-weight: 500;">Kg</span></h2>
                            </div>
                            <div class="p-3 rounded-3" style="background-color: #e8f5e9; color: #2e7d32;">
                                <i class="bi bi-flower1 fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card p-4" style="border-bottom-color: #2196f3;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fw-medium" style="font-size: 0.8rem;">LAPIS VERIFIKASI AKTIF</p>
                                <h2 class="fw-bold text-dark mb-0">2<span style="font-size: 1.2rem; font-weight: 500;">x Lapis</span></h2>
                            </div>
                            <div class="p-3 rounded-3" style="background-color: #e3f2fd; color: #1e88e5;">
                                <i class="bi bi-shield-check fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card p-4" style="border-bottom-color: #ff9800;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fw-medium" style="font-size: 0.8rem;">EKSPOR REKAPITULASI</p>
                                <h2 class="fw-bold text-dark mb-0">PDF / XLS</h2>
                            </div>
                            <div class="p-3 rounded-3" style="background-color: #fff3cd; color: #856404;">
                                <i class="bi bi-file-earmark-spreadsheet fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Konten Detail -->
            <div class="row g-4">
                <!-- SISI KIRI: KARTU ALUR KERJA (Dari data landing page asli) -->
                <div class="col-lg-6">
                    <div class="card data-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">Kartu Alur Kerja Buku Tani Digital</h5>
                            <span class="badge bg-light text-secondary border">No. 0042/POKTAN</span>
                        </div>
                        <p class="text-muted small mb-4">Pelacakan proses pencatatan komoditas berjenjang secara transparan.</p>
                        
                        <ul class="step-list">
                            <li class="step-item">
                                <div><span class="fw-semibold text-success me-2">01</span> Pendaftaran Anggota Petani</div>
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Selesai</span>
                            </li>
                            <li class="step-item">
                                <div><span class="fw-semibold text-success me-2">02</span> Verifikasi oleh Pengurus</div>
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span>
                            </li>
                            <li class="step-item">
                                <div><span class="fw-semibold text-success me-2">03</span> Input Panen — Padi, 1.250 Kg</div>
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Sukses</span>
                            </li>
                            <li class="step-item">
                                <div><span class="fw-semibold text-success me-2">04</span> Distribusi ke Pembeli/Pasar</div>
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Terkirim</span>
                            </li>
                            <li class="step-item">
                                <div><span class="fw-semibold text-success me-2">05</span> Bagi Hasil Proporsional Kelompok</div>
                                <span class="text-warning fw-medium"><i class="bi bi-hourglass-split"></i> Menunggu...</span>
                            </li>
                        </ul>
                        
                        <div class="mt-4 pt-2 border-top d-flex justify-content-between text-muted small">
                            <span>Musim I · 2026</span>
                            <span class="text-success fw-semibold">Kelompok Tani Terverifikasi</span>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: FORMULIR INPUT CEPAT / AKTIVITAS TERAKHIR -->
                <div class="col-lg-6">
                    <div class="card data-card p-4 h-100">
                        <h5 class="fw-bold text-dark mb-3">Aksi Cepat Input Laporan</h5>
                        <p class="text-muted small mb-4">Gunakan pintasan di bawah untuk mengirim data langsung ke pengurus kelompok.</p>
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 border rounded-3 text-center bg-light h-100" style="cursor: pointer;">
                                    <i class="bi bi-clipboard-plus text-success fs-2 d-block mb-2"></i>
                                    <h6 class="fw-bold mb-1 text-dark">Catat Hasil</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">Input berat panen komoditas</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border rounded-3 text-center bg-light h-100" style="cursor: pointer;">
                                    <i class="bi bi-cart-plus text-success fs-2 d-block mb-2"></i>
                                    <h6 class="fw-bold mb-1 text-dark">Distribusi</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">Catat penjualan ke pembeli</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 rounded-3" style="background-color: #f1f8e9; border: 1px solid #dcedc8;">
                            <h6 class="fw-bold text-success mb-1" style="font-size: 0.85rem;"><i class="bi bi-info-circle-fill"></i> Catatan Sistem Informasi</h6>
                            <p class="mb-0 text-secondary" style="font-size: 0.8rem;">Setiap data panen yang Anda kirimkan memerlukan verifikasi berjenjang oleh staf pengurus sebelum masuk laporan produktivitas utama.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>