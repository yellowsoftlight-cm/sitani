<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Panen;
use App\Models\User;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    /**
     * Tampilkan dashboard pengurus dengan data asli dari seluruh anggota poktan,
     * bukan data dummy statis.
     */
    public function dashboard()
    {
        $totalAnggota = User::where('role', 'Petani')->count();

        $antreanVerifikasi = Panen::with('user')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        $totalVolumeDisetujui = Panen::where('status', 'disetujui')->sum('berat');

        $anggotaPoktan = User::where('role', 'Petani')
            ->withCount('panens')
            ->withSum(['panens as total_berat' => function ($query) {
                $query->where('status', 'disetujui');
            }], 'berat')
            ->orderBy('name')
            ->get();

        // Panen yang sudah disetujui pengurus namun belum dicatat distribusinya
        // ke pasar mana pun — inilah antrean yang bisa didistribusikan.
        $siapDidistribusikan = Panen::with('user')
            ->where('status', 'disetujui')
            ->whereDoesntHave('distribusi')
            ->latest()
            ->get();

        // Riwayat distribusi yang sudah tercatat, terbaru dulu.
        $riwayatDistribusi = Distribusi::with(['panen.user'])
            ->latest()
            ->get();

        $totalNilaiDistribusi = Distribusi::sum('total_nilai');

        return view('pengurus', [
            'totalAnggota' => $totalAnggota,
            'antreanVerifikasi' => $antreanVerifikasi,
            'jumlahMenunggu' => $antreanVerifikasi->count(),
            'totalVolumeDisetujui' => $totalVolumeDisetujui,
            'anggotaPoktan' => $anggotaPoktan,
            'siapDidistribusikan' => $siapDidistribusikan,
            'riwayatDistribusi' => $riwayatDistribusi,
            'totalNilaiDistribusi' => $totalNilaiDistribusi,
        ]);
    }

    /**
     * Setujui laporan panen milik petani, sekaligus catat nominal bagi hasil.
     */
    public function approve(Request $request, Panen $panen)
    {
        $validated = $request->validate([
            'estimasi_bagi_hasil' => 'required|integer|min:0',
        ]);

        $panen->update([
            'status' => 'disetujui',
            'estimasi_bagi_hasil' => $validated['estimasi_bagi_hasil'],
        ]);

        NotifikasiService::kirim(
            $panen->user_id,
            'panen_disetujui',
            'Laporan panen disetujui',
            "Panen {$panen->komoditas} {$panen->berat} Kg ({$panen->no_nota}) telah disetujui. Estimasi bagi hasil: Rp " . number_format($validated['estimasi_bagi_hasil'], 0, ',', '.') . '.',
            ['panen_id' => $panen->id]
        );

        return back()->with('success', "Data panen {$panen->no_nota} berhasil disetujui.");
    }

    /**
     * Tolak laporan panen milik petani.
     */
    public function reject(Panen $panen)
    {
        $panen->update([
            'status' => 'ditolak',
            'estimasi_bagi_hasil' => 0,
        ]);

        NotifikasiService::kirim(
            $panen->user_id,
            'panen_ditolak',
            'Laporan panen ditolak',
            "Panen {$panen->komoditas} {$panen->berat} Kg ({$panen->no_nota}) ditolak oleh pengurus. Silakan periksa kembali data Anda.",
            ['panen_id' => $panen->id]
        );

        return back()->with('success', "Data panen {$panen->no_nota} ditolak.");
    }

    /**
     * Catat distribusi hasil panen yang sudah disetujui ke pasar tujuan.
     * Satu laporan panen hanya bisa didistribusikan sekali (constraint unique
     * di kolom panen_id pada tabel distribusis).
     */
    public function storeDistribusi(Request $request)
    {
        $validated = $request->validate([
            'panen_id' => 'required|exists:panens,id',
            'nama_pasar' => 'required|string|max:150',
            'jumlah_kg' => 'required|integer|min:1',
            'harga_per_kg' => 'required|integer|min:0',
            'tanggal_kirim' => 'required|date',
            'catatan' => 'nullable|string|max:500',
        ]);

        $panen = Panen::findOrFail($validated['panen_id']);

        if ($panen->status !== 'disetujui') {
            return back()->with('error', 'Hanya laporan panen berstatus disetujui yang dapat didistribusikan.');
        }

        if ($panen->distribusi()->exists()) {
            return back()->with('error', "Panen {$panen->no_nota} sudah pernah didistribusikan sebelumnya.");
        }

        if ($validated['jumlah_kg'] > $panen->berat) {
            return back()->with('error', 'Jumlah distribusi tidak boleh melebihi berat panen yang disetujui.');
        }

        $totalNilai = $validated['jumlah_kg'] * $validated['harga_per_kg'];

        $distribusi = Distribusi::create([
            'panen_id' => $panen->id,
            'pengurus_id' => auth()->id(),
            'nama_pasar' => $validated['nama_pasar'],
            'jumlah_kg' => $validated['jumlah_kg'],
            'harga_per_kg' => $validated['harga_per_kg'],
            'total_nilai' => $totalNilai,
            'tanggal_kirim' => $validated['tanggal_kirim'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        NotifikasiService::kirim(
            $panen->user_id,
            'panen_didistribusikan',
            'Hasil panen telah didistribusikan',
            "Panen {$panen->komoditas} {$panen->berat} Kg ({$panen->no_nota}) telah dikirim ke {$validated['nama_pasar']} sebanyak {$validated['jumlah_kg']} Kg senilai Rp " . number_format($totalNilai, 0, ',', '.') . '.',
            ['panen_id' => $panen->id, 'distribusi_id' => $distribusi->id]
        );

        return back()->with('success', "Distribusi panen {$panen->no_nota} ke {$validated['nama_pasar']} berhasil dicatat.");
    }
}
