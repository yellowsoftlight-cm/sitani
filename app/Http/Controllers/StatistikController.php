<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

/**
 * Menyediakan data agregat (bukan data pribadi) untuk grafik pada landing
 * page maupun dashboard. Semua angka dihitung langsung dari tabel panens
 * dan users — tidak ada data dummy/hardcode.
 *
 * Hasil di-cache singkat (60 detik) agar landing page publik tidak
 * membebani database saat banyak pengunjung membuka grafik bersamaan.
 */
class StatistikController extends Controller
{
    /**
     * Total volume panen (Kg) per musim, hanya panen yang sudah disetujui
     * pengurus — dipakai untuk chart bar "Produktivitas Panen per Musim".
     */
    public function panenPerMusim()
    {
        return response()->json(
            Cache::remember('statistik.panen-per-musim', 60, function () {
                $rows = Panen::where('status', 'disetujui')
                    ->selectRaw('musim, SUM(berat) as total_berat')
                    ->groupBy('musim')
                    ->orderBy('musim')
                    ->get();

                return [
                    'labels' => $rows->pluck('musim'),
                    'data' => $rows->pluck('total_berat')->map(fn ($v) => (int) $v),
                ];
            })
        );
    }

    /**
     * Pertumbuhan jumlah anggota Petani per bulan (kumulatif), dihitung dari
     * tanggal pendaftaran akun — dipakai untuk chart garis "Pertumbuhan Anggota".
     */
    public function pertumbuhanAnggota()
    {
        return response()->json(
            Cache::remember('statistik.pertumbuhan-anggota', 60, function () {
                $petani = User::where('role', 'Petani')
                    ->orderBy('created_at')
                    ->pluck('created_at');

                $perBulan = $petani
                    ->groupBy(fn ($tanggal) => $tanggal->format('Y-m'))
                    ->map->count();

                $labels = [];
                $data = [];
                $kumulatif = 0;

                foreach ($perBulan as $bulan => $jumlah) {
                    $kumulatif += $jumlah;
                    $labels[] = \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('M Y');
                    $data[] = $kumulatif;
                }

                return ['labels' => $labels, 'data' => $data];
            })
        );
    }

    /**
     * Komposisi komoditas berdasarkan total berat yang sudah disetujui —
     * dipakai untuk chart horizontal "Komposisi Komoditas Terdistribusi".
     */
    public function komposisiKomoditas()
    {
        return response()->json(
            Cache::remember('statistik.komposisi-komoditas', 60, function () {
                $rows = Panen::where('status', 'disetujui')
                    ->selectRaw('komoditas, SUM(berat) as total_berat')
                    ->groupBy('komoditas')
                    ->orderByDesc('total_berat')
                    ->limit(6)
                    ->get();

                $total = max($rows->sum('total_berat'), 1);

                return [
                    'labels' => $rows->pluck('komoditas'),
                    'data' => $rows->pluck('total_berat')->map(fn ($v) => (int) $v),
                    'persen' => $rows->pluck('total_berat')->map(fn ($v) => round(($v / $total) * 100, 1)),
                ];
            })
        );
    }

    /**
     * Ringkasan angka untuk kartu statistik kecil (opsional dipakai UI lain).
     */
    public function ringkasan()
    {
        return response()->json(
            Cache::remember('statistik.ringkasan', 60, function () {
                return [
                    'total_anggota' => User::where('role', 'Petani')->count(),
                    'total_volume_disetujui' => (int) Panen::where('status', 'disetujui')->sum('berat'),
                    'total_laporan_panen' => Panen::count(),
                    'menunggu_verifikasi' => Panen::where('status', 'menunggu')->count(),
                ];
            })
        );
    }
}
