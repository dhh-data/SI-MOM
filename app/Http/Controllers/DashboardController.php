<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Departemen;
use App\Models\Inventaris;
use App\Models\PeminjamanInventaris;
use App\Models\RapatAkbar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data bersama untuk semua role
        $rapatTerdekat = RapatAkbar::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'Dijadwalkan')
            ->orderBy('tanggal')
            ->first();

        $berkasTerbaru = Berkas::with('uploader')
            ->latest()
            ->take(5)
            ->get();

        if ($user->isAdmin()) {
            return $this->adminDashboard($rapatTerdekat, $berkasTerbaru);
        }

        if ($user->isKepalaDepartemen()) {
            return $this->kepalaDashboard($user, $rapatTerdekat, $berkasTerbaru);
        }

        return $this->anggotaDashboard($user, $rapatTerdekat, $berkasTerbaru);
    }

    // ─── Admin ────────────────────────────────────────────────────────────────

    private function adminDashboard($rapatTerdekat, $berkasTerbaru)
    {
        $stats = [
            'total_anggota'       => User::count(),
            'total_departemen'    => Departemen::count(),
            'total_inventaris'    => Inventaris::count(),
            'total_rapat'         => RapatAkbar::count(),
            'total_berkas'        => Berkas::count(),
            'peminjaman_pending'  => PeminjamanInventaris::where('status_pengajuan', 'Pending')->count(),
        ];

        // Eager-load relasi agar tidak terjadi N+1 query
        $departemens = Departemen::with(['programKerja', 'anggota'])->get();

        $peminjamanTerbaru = PeminjamanInventaris::with(['peminjam', 'departemen', 'inventaris'])
            ->latest()
            ->take(5)
            ->get();

        // 8 rapat terakhir beserta presensi-nya (untuk tabel rekap kehadiran)
        $rapatAkbar = RapatAkbar::with('presensis')
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'departemens',
            'rapatTerdekat',
            'berkasTerbaru',
            'peminjamanTerbaru',
            'rapatAkbar'
        ));
    }

    // ─── Kepala Departemen / Kepala Inventaris ────────────────────────────────

    private function kepalaDashboard($user, $rapatTerdekat, $berkasTerbaru)
    {
        // Guard: pastikan user memiliki departemen sebelum query relasi
        $departemen = $user->departemen;

        $stats = [
            'jumlah_anggota' => $departemen?->anggota()->count() ?? 0,
            'jumlah_proker'  => $departemen?->programKerja()->count() ?? 0,
            'proker_selesai' => $departemen?->programKerja()->where('status', 'Selesai')->count() ?? 0,
        ];

        $programKerja = $departemen
            ? $departemen->programKerja()->latest()->take(5)->get()
            : collect();

        $peminjamanSaya = PeminjamanInventaris::where('peminjam_id', $user->id)
            ->with('inventaris')
            ->latest()
            ->take(5)
            ->get();

        $progress = $departemen
            ? $departemen->getProgressProker()
            : ['selesai' => 0, 'total' => 0, 'persen' => 0];

        return view('dashboard.kepala', compact(
            'stats',
            'departemen',
            'programKerja',
            'rapatTerdekat',
            'berkasTerbaru',
            'peminjamanSaya',
            'progress'
        ));
    }

    // ─── Anggota / Staff ──────────────────────────────────────────────────────

    private function anggotaDashboard($user, $rapatTerdekat, $berkasTerbaru)
    {
        $inventarisTersedia = Inventaris::where('status', 'Tersedia')
            ->take(5)
            ->get();

        // Eager-load rapat agar tidak query N+1 di blade
        $presensiSaya = $user->presensis()
            ->with('rapat')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.anggota', compact(
            'rapatTerdekat',
            'berkasTerbaru',
            'inventarisTersedia',
            'presensiSaya'
        ));
    }
}