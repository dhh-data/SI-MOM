<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Departemen;
use App\Models\Inventaris;
use App\Models\PeminjamanInventaris;
use App\Models\ProgramKerja;
use App\Models\RapatAkbar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data umum untuk semua role
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
        } elseif ($user->isKepalaDepartemen()) {
            return $this->kepalaDashboard($user, $rapatTerdekat, $berkasTerbaru);
        } else {
            return $this->anggotaDashboard($user, $rapatTerdekat, $berkasTerbaru);
        }
    }

    private function adminDashboard($rapatTerdekat, $berkasTerbaru)
    {
        $stats = [
            'total_anggota' => User::count(),
            'total_departemen' => Departemen::count(),
            'total_inventaris' => Inventaris::count(),
            'total_rapat' => RapatAkbar::count(),
            'total_berkas' => Berkas::count(),
            'peminjaman_pending' => PeminjamanInventaris::where('status_pengajuan', 'Pending')->count(),
        ];

        $departemens = Departemen::with(['programKerja', 'anggota'])->get();

        $peminjamanTerbaru = PeminjamanInventaris::with(['peminjam', 'departemen', 'inventaris'])
            ->latest()
            ->take(5)
            ->get();

        // Grafik keaktifan - presensi per bulan terakhir 6 bulan
        $rapatAkbar = RapatAkbar::with(['presensis'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard.admin', compact(
            'stats', 'departemens', 'rapatTerdekat',
            'berkasTerbaru', 'peminjamanTerbaru', 'rapatAkbar'
        ));
    }

    private function kepalaDashboard($user, $rapatTerdekat, $berkasTerbaru)
    {
        $departemen = $user->departemen;
        $stats = [
            'jumlah_anggota' => $departemen ? $departemen->anggota()->count() : 0,
            'jumlah_proker' => $departemen ? $departemen->programKerja()->count() : 0,
            'proker_selesai' => $departemen ? $departemen->programKerja()->where('status', 'Selesai')->count() : 0,
        ];

        $programKerja = $departemen ? $departemen->programKerja()->latest()->take(5)->get() : collect();

        $peminjamanSaya = PeminjamanInventaris::where('peminjam_id', $user->id)
            ->with(['inventaris'])
            ->latest()
            ->take(5)
            ->get();

        $progress = $departemen ? $departemen->getProgressProker() : ['selesai' => 0, 'total' => 0, 'persen' => 0];

        return view('dashboard.kepala', compact(
            'stats', 'departemen', 'programKerja',
            'rapatTerdekat', 'berkasTerbaru', 'peminjamanSaya', 'progress'
        ));
    }

    private function anggotaDashboard($user, $rapatTerdekat, $berkasTerbaru)
    {
        $inventarisTersedia = Inventaris::where('status', 'Tersedia')->take(5)->get();

        $presensiSaya = $user->presensis()
            ->with('rapat')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.anggota', compact(
            'rapatTerdekat', 'berkasTerbaru',
            'inventarisTersedia', 'presensiSaya'
        ));
    }
}
