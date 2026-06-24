<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');

        $query = Berkas::with('uploader');

        if ($search) {
            $query->where('judul_berkas', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $berkas = $query->latest()->paginate(12)->withQueryString();

        return view('berkas.index', compact('berkas', 'search', 'kategori'));
    }

    public function create()
    {
        return view('berkas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_berkas' => 'required|string|max:255',
            'kategori' => 'required|in:Proposal,LPJ,Notulen,Surat,Dokumentasi',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|max:20480',
        ]);

        $file = $request->file('file');
        $path = $file->store('berkas', 'public');

        Berkas::create([
            'judul_berkas' => $request->judul_berkas,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
            'nama_file' => $file->getClientOriginalName(),
            'ukuran_file' => $this->formatBytes($file->getSize()),
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('berkas.index')->with('success', 'Berkas berhasil diunggah!');
    }

    public function show(Berkas $berkas)
    {
        return view('berkas.show', compact('berkas'));
    }

    public function download(Berkas $berkas)
    {
        return Storage::disk('public')->download($berkas->file_path, $berkas->nama_file);
    }

    public function destroy(Berkas $berkas)
    {
        Storage::disk('public')->delete($berkas->file_path);
        $berkas->delete();
        return redirect()->route('berkas.index')->with('success', 'Berkas berhasil dihapus!');
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}
