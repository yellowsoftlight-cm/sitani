<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kelompok - SiTani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background-color: #f4f1ea; } .btn-sitani { background-color: #054a19; color: white; } </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4 text-center" style="color: #054a19;">Daftar Anggota SiTani</h4>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Daftar Sebagai</label>
                            <select name="role" class="form-select" required>
                                <option value="Petani">Petani</option>
                                <option value="Pengurus">Pengurus</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sitani w-100">Daftar</button>
                    </form>
                    <p class="mt-3 text-center">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>