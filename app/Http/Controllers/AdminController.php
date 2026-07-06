<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\User;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * Dashboard utama Admin: ringkasan statistik seluruh sistem,
     * daftar pengguna, dan rekap seluruh laporan panen.
     * Semua data diambil langsung dari database (bukan dummy).
     */
    public function dashboard(Request $request)
    {
        $totalPengguna = User::count();
        $totalPetani = User::where('role', 'Petani')->count();
        $totalPengurus = User::where('role', 'Pengurus')->count();
        $totalAdmin = User::where('role', 'Admin')->count();

        $totalLaporanPanen = Panen::count();
        $menungguVerifikasi = Panen::where('status', 'menunggu')->count();
        $totalVolumeDisetujui = Panen::where('status', 'disetujui')->sum('berat');
        $totalBagiHasil = Panen::where('status', 'disetujui')->sum('estimasi_bagi_hasil');

        // Daftar pengguna untuk panel Kelola Pengguna.
        $daftarPengguna = User::withCount('panens')
            ->orderByRaw("CASE role WHEN 'Admin' THEN 0 WHEN 'Pengurus' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->get();

        // Rekap seluruh laporan panen di sistem, dengan filter status opsional.
        $statusFilter = $request->query('status');
        $panenQuery = Panen::with('user')->latest();
        if (in_array($statusFilter, ['menunggu', 'disetujui', 'ditolak'], true)) {
            $panenQuery->where('status', $statusFilter);
        }
        $seluruhPanen = $panenQuery->paginate(10)->withQueryString();

        // Komposisi komoditas yang paling banyak dilaporkan (untuk konteks admin).
        $komoditasTerbanyak = Panen::selectRaw('komoditas, COUNT(*) as jumlah, SUM(berat) as total_berat')
            ->groupBy('komoditas')
            ->orderByDesc('total_berat')
            ->limit(5)
            ->get();

        return view('admin', [
            'totalPengguna' => $totalPengguna,
            'totalPetani' => $totalPetani,
            'totalPengurus' => $totalPengurus,
            'totalAdmin' => $totalAdmin,
            'totalLaporanPanen' => $totalLaporanPanen,
            'menungguVerifikasi' => $menungguVerifikasi,
            'totalVolumeDisetujui' => $totalVolumeDisetujui,
            'totalBagiHasil' => $totalBagiHasil,
            'daftarPengguna' => $daftarPengguna,
            'seluruhPanen' => $seluruhPanen,
            'statusFilter' => $statusFilter,
            'komoditasTerbanyak' => $komoditasTerbanyak,
        ]);
    }

    /**
     * Ubah role seorang pengguna (mis. menaikkan Petani menjadi Pengurus).
     * Admin tidak diperbolehkan mengubah role akunnya sendiri agar tidak
     * tidak sengaja kehilangan akses admin.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:Petani,Pengurus,Admin',
        ]);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $user->update(['role' => $validated['role']]);

        NotifikasiService::kirim(
            $user->id,
            'role_diubah',
            'Role akun Anda diperbarui',
            "Role akun Anda telah diubah menjadi {$validated['role']} oleh admin.",
        );

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }

    /**
     * Hapus akun pengguna. Admin tidak dapat menghapus akunnya sendiri,
     * maupun menghapus admin terakhir yang tersisa di sistem.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'Admin' && User::where('role', 'Admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir yang tersisa di sistem.');
        }

        $nama = $user->name;
        $user->delete();

        return back()->with('success', "Akun {$nama} berhasil dihapus dari sistem.");
    }

    /**
     * Ekspor seluruh data panen ke file CSV agar admin dapat menyimpan
     * salinan/audit data di luar sistem.
     *
     * Catatan perbaikan format: file sebelumnya sering tampil berantakan saat
     * dibuka di Microsoft Excel karena (1) tidak ada BOM UTF-8 sehingga huruf
     * ber-aksen/simbol Rupiah rusak, dan (2) memakai delimiter koma padahal
     * Excel versi Indonesia/Eropa memakai titik koma sebagai pemisah kolom
     * default — akibatnya semua data numpuk ke satu kolom. Kedua hal ini
     * sudah diperbaiki di bawah.
     */
    public function exportPanenCsv(): StreamedResponse
    {
        $filename = 'rekap-panen-sitani-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 agar Excel membaca karakter khusus dengan benar,
            // dan delimiter titik koma agar kolom terpisah rapi di Excel ID/EU.
            fwrite($handle, "\xEF\xBB\xBF");
            $delimiter = ';';

            fputcsv($handle, ['No Nota', 'Nama Petani', 'Komoditas', 'Berat (Kg)', 'Musim', 'Status', 'Estimasi Bagi Hasil (Rp)', 'Tanggal Input'], $delimiter);

            Panen::with('user')->orderBy('created_at')->chunk(200, function ($rows) use ($handle, $delimiter) {
                foreach ($rows as $panen) {
                    fputcsv($handle, [
                        $panen->no_nota,
                        $panen->user->name ?? '-',
                        $panen->komoditas,
                        number_format($panen->berat, 0, ',', '.'),
                        $panen->musim,
                        ucfirst($panen->status),
                        number_format($panen->estimasi_bagi_hasil, 0, ',', '.'),
                        $panen->created_at->format('d/m/Y H:i'),
                    ], $delimiter);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
