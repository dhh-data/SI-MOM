<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Inventaris;
use App\Models\PeminjamanInventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $status = $request->get('status');

        $query = Inventaris::query();

        if ($search) {
            $query->where('nama_barang', 'like', "%$search%");
        }
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $inventaris = $query->orderBy('nama_barang')->paginate(10)->withQueryString();

        return view('inventaris.index', compact('inventaris', 'search', 'kategori', 'status'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|in:Elektronik,Perlengkapan,Dokumentasi,ATK,Lainnya',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'required|string',
            'status' => 'required|in:Tersedia,Dipinjam,Maintenance',
            'keterangan' => 'nullable|string',
        ]);

        Inventaris::create($request->all());
        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil ditambahkan!');
    }

    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required',
            'lokasi_penyimpanan' => 'required|string',
            'status' => 'required',
        ]);

        $inventaris->update($request->all());
        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui!');
    }

    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();
        return redirect()->route('inventaris.index')->with('success', 'Barang berhasil dihapus!');
    }

    // Peminjaman
    public function peminjaman(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->get('status');

        $query = PeminjamanInventaris::with(['peminjam', 'departemen', 'inventaris', 'approvedBy']);

        if (!$user->canApproveInventaris()) {
            $query->where('peminjam_id', $user->id);
        }

        if ($statusFilter) {
            $query->where('status_pengajuan', $statusFilter);
        }

        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        return view('inventaris.peminjaman', compact('peminjaman', 'statusFilter'));
    }

    public function ajukanPeminjaman()
    {
        $inventarisTersedia = Inventaris::where('status', 'Tersedia')->orderBy('nama_barang')->get();
        $user = Auth::user();
        $departemen = $user->departemen;
        return view('inventaris.ajukan', compact('inventarisTersedia', 'departemen'));
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'inventaris_id' => 'required|exists:inventaris,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan' => 'required|string',
        ]);

        $user = Auth::user();

        PeminjamanInventaris::create([
            'peminjam_id' => $user->id,
            'departemen_id' => $user->departemen_id,
            'inventaris_id' => $request->inventaris_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'alasan' => $request->alasan,
            'status_pengajuan' => 'Pending',
        ]);

        return redirect()->route('inventaris.peminjaman')->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    public function approvalPeminjaman(Request $request, PeminjamanInventaris $peminjaman)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'catatan' => 'nullable|string',
        ]);

        $status = $request->action === 'approve' ? 'Approved' : 'Rejected';

        $peminjaman->update([
            'status_pengajuan' => $status,
            'approved_by' => Auth::id(),
            'catatan_approval' => $request->catatan,
            'approved_at' => now(),
        ]);

        // Update status inventaris jika disetujui
        if ($status === 'Approved') {
            $peminjaman->inventaris->update(['status' => 'Dipinjam']);
        }

        $msg = $status === 'Approved' ? 'Pengajuan disetujui!' : 'Pengajuan ditolak!';
        return back()->with('success', $msg);
    }
}
