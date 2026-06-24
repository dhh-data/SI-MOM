<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\RapatAkbar;
use App\Models\NotulensiRapat;
use App\Models\DokumentasiRapat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RapatAkbarController extends Controller
{
    public function index()
    {
        $rapats = RapatAkbar::withCount('presensis')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('rapat.index', compact('rapats'));
    }

    public function create()
    {
        return view('rapat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rapat' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string',
            'agenda' => 'required|string',
            'status' => 'required|in:Dijadwalkan,Berlangsung,Selesai,Dibatalkan',
        ]);

        $rapat = RapatAkbar::create($request->all());

        // Auto-buat presensi untuk semua anggota
        $users = User::all();
        foreach ($users as $user) {
            Presensi::create([
                'rapat_akbar_id' => $rapat->id,
                'user_id' => $user->id,
                'status' => 'Tidak Hadir',
            ]);
        }

        return redirect()->route('rapat.show', $rapat)->with('success', 'Rapat akbar berhasil dibuat!');
    }

    public function show(RapatAkbar $rapat)
    {
        $rapat->load(['presensis.user.departemen', 'notulensi.penulis', 'dokumentasi']);
        $presensiStats = [
            'hadir' => $rapat->getJumlahHadir(),
            'izin' => $rapat->getJumlahIzin(),
            'tidak_hadir' => $rapat->getJumlahTidakHadir(),
            'total' => $rapat->presensis->count(),
        ];
        $userPresensi = $rapat->presensis->where('user_id', Auth::id())->first();
        return view('rapat.show', compact('rapat', 'presensiStats', 'userPresensi'));
    }

    public function edit(RapatAkbar $rapat)
    {
        return view('rapat.edit', compact('rapat'));
    }

    public function update(Request $request, RapatAkbar $rapat)
    {
        $request->validate([
            'nama_rapat' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string',
            'agenda' => 'required|string',
            'status' => 'required|in:Dijadwalkan,Berlangsung,Selesai,Dibatalkan',
        ]);

        $rapat->update($request->all());
        return redirect()->route('rapat.show', $rapat)->with('success', 'Rapat berhasil diperbarui!');
    }

    public function destroy(RapatAkbar $rapat)
    {
        $rapat->delete();
        return redirect()->route('rapat.index')->with('success', 'Rapat berhasil dihapus!');
    }

    // Presensi
    public function presensi(RapatAkbar $rapat)
    {
        $user = Auth::user();
        $presensis = $rapat->presensis()->with('user.departemen')->orderBy('status')->get();
        $userPresensi = $presensis->where('user_id', $user->id)->first();
        return view('rapat.presensi', compact('rapat', 'presensis', 'userPresensi'));
    }

    public function isiPresensi(Request $request, RapatAkbar $rapat)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
            'keterangan' => 'nullable|string',
        ]);

        Presensi::updateOrCreate(
            ['rapat_akbar_id' => $rapat->id, 'user_id' => Auth::id()],
            ['status' => $request->status, 'keterangan' => $request->keterangan]
        );

        return redirect()->route('rapat.presensi', $rapat)->with('success', 'Presensi berhasil diisi!');
    }

    public function updatePresensiAdmin(Request $request, RapatAkbar $rapat, Presensi $presensi)
    {
        $request->validate(['status' => 'required|in:Hadir,Izin,Tidak Hadir']);
        $presensi->update(['status' => $request->status]);
        return back()->with('success', 'Status presensi diperbarui!');
    }

    // Notulensi
    public function notulensi(RapatAkbar $rapat)
    {
        $notulensi = $rapat->notulensi()->with('penulis')->first();
        return view('rapat.notulensi', compact('rapat', 'notulensi'));
    }

    public function storeNotulensi(Request $request, RapatAkbar $rapat)
    {
        $request->validate([
            'judul_notulensi' => 'required|string',
            'isi_notulensi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        NotulensiRapat::updateOrCreate(
            ['rapat_akbar_id' => $rapat->id],
            [
                'judul_notulensi' => $request->judul_notulensi,
                'isi_notulensi' => $request->isi_notulensi,
                'penulis_id' => Auth::id(),
                'tanggal' => $request->tanggal,
            ]
        );

        return redirect()->route('rapat.notulensi', $rapat)->with('success', 'Notulensi berhasil disimpan!');
    }

    // Dokumentasi
    public function storeDokumentasi(Request $request, RapatAkbar $rapat)
    {
        $request->validate([
            'jenis' => 'required|in:foto,lampiran,hasil',
            'file' => 'required|file|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $path = $file->store('dokumentasi/' . $rapat->id, 'public');

        DokumentasiRapat::create([
            'rapat_akbar_id' => $rapat->id,
            'jenis' => $request->jenis,
            'file_path' => $path,
            'nama_file' => $file->getClientOriginalName(),
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Dokumentasi berhasil diunggah!');
    }
}
