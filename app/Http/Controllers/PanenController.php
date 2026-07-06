<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanenController extends Controller
{
    /**
     * Tampilkan dashboard petani dengan data asli milik user yang login.
     * User baru (belum pernah input panen) akan melihat data kosong,
     * bukan data dummy.
     */
    public function dashboard()
    {
        $petani = Auth::user();

        // Ambil riwayat panen milik petani ini saja, terbaru dulu.
        $riwayatPanen = $petani->panens()->latest()->get();

        $totalSetorPanen = $riwayatPanen->sum('berat');
        $estimasiBagiHasil = $riwayatPanen->where('status', 'disetujui')->sum('estimasi_bagi_hasil');
        $menungguVerifikasi = $riwayatPanen->where('status', 'menunggu');
        $totalMenungguKg = $menungguVerifikasi->sum('berat');
        $jumlahBerkasMenunggu = $menungguVerifikasi->count();

        return view('petani', [
            'riwayatPanen' => $riwayatPanen,
            'totalSetorPanen' => $totalSetorPanen,
            'estimasiBagiHasil' => $estimasiBagiHasil,
            'totalMenungguKg' => $totalMenungguKg,
            'jumlahBerkasMenunggu' => $jumlahBerkasMenunggu,
        ]);
    }

    /**
     * Simpan laporan hasil panen baru yang diisi oleh petani.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'komoditas' => 'required|string|max:100',
            'berat' => 'required|integer|min:1',
            'musim' => 'required|string|max:50',
        ]);

        $labelKomoditas = [
            'padi' => 'PD',
            'jagung' => 'JG',
            'kedelai' => 'KD',
        ];
        $kode = $labelKomoditas[$validated['komoditas']] ?? 'UM';

        $panen = Panen::create([
            'user_id' => Auth::id(),
            'no_nota' => '#' . str_pad((string) (Panen::max('id') + 1), 4, '0', STR_PAD_LEFT) . '/' . $kode,
            'komoditas' => ucfirst($validated['komoditas']),
            'berat' => $validated['berat'],
            'musim' => $validated['musim'],
            'status' => 'menunggu',
        ]);

        NotifikasiService::kirimKeRole(
            'Pengurus',
            'panen_masuk',
            'Laporan panen baru menunggu verifikasi',
            Auth::user()->name . " melaporkan panen {$panen->komoditas} {$panen->berat} Kg ({$panen->no_nota}).",
            ['panen_id' => $panen->id]
        );

        return redirect()->route('petani.dashboard')->with('success', 'Data panen berhasil dikirim ke pengurus.');
    }
}
