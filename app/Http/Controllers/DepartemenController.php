<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartemenController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $departemens = Departemen::with(['anggota', 'programKerja', 'kepalaDepartemen'])->get();
        } else {
            $departemens = Departemen::with(['anggota', 'programKerja', 'kepalaDepartemen'])
                ->where('id', $user->departemen_id)
                ->get();
        }

        return view('departemen.index', compact('departemens'));
    }

    public function anggota(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        $departemenFilter = $request->get('departemen');
        $jabatanFilter = $request->get('jabatan');

        $query = User::with('departemen');

        if (!$user->isAdmin()) {
            $query->where('departemen_id', $user->departemen_id);
        } elseif ($departemenFilter) {
            $query->where('departemen_id', $departemenFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('nim', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($jabatanFilter) {
            $query->where('jabatan', $jabatanFilter);
        }

        $anggota = $query->orderBy('name')->paginate(10)->withQueryString();
        $departemens = Departemen::all();

        return view('departemen.anggota', compact('anggota', 'departemens', 'search', 'departemenFilter', 'jabatanFilter'));
    }

    public function createAnggota()
    {
        $departemens = Departemen::all();
        return view('departemen.create-anggota', compact('departemens'));
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string',
            'angkatan' => 'required|string',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan' => 'required|in:Ketua Umum,Sekretaris,Kepala Departemen,Staff',
            'role' => 'required|in:admin,kepala_departemen,kepala_inventaris,anggota',
            'password' => 'required|min:8',
        ]);

        User::create([
            ...$request->only(['name', 'nim', 'email', 'no_hp', 'angkatan', 'departemen_id', 'jabatan', 'role']),
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('departemen.anggota')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function editAnggota(User $anggota)
    {
        $departemens = Departemen::all();
        return view('departemen.edit-anggota', compact('anggota', 'departemens'));
    }

    public function updateAnggota(Request $request, User $anggota)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim,' . $anggota->id,
            'email' => 'required|email|unique:users,email,' . $anggota->id,
            'no_hp' => 'nullable|string',
            'angkatan' => 'required|string',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan' => 'required|in:Ketua Umum,Sekretaris,Kepala Departemen,Staff',
            'role' => 'required|in:admin,kepala_departemen,kepala_inventaris,anggota',
        ]);

        $anggota->update($request->only([
            'name', 'nim', 'email', 'no_hp', 'angkatan',
            'departemen_id', 'jabatan', 'role',
        ]));

        if ($request->filled('password')) {
            $anggota->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('departemen.anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroyAnggota(User $anggota)
    {
        $anggota->delete();
        return redirect()->route('departemen.anggota')->with('success', 'Anggota berhasil dihapus!');
    }

    public function programKerja(Request $request)
    {
        $user = Auth::user();
        $departemenFilter = $request->get('departemen');
        $statusFilter = $request->get('status');

        $query = \App\Models\ProgramKerja::with('departemen');

        if (!$user->isAdmin()) {
            $query->where('departemen_id', $user->departemen_id);
        } elseif ($departemenFilter) {
            $query->where('departemen_id', $departemenFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $programKerja = $query->orderBy('tanggal_mulai')->paginate(10)->withQueryString();
        $departemens = Departemen::all();

        return view('departemen.proker', compact('programKerja', 'departemens', 'departemenFilter', 'statusFilter'));
    }

    public function storeProker(Request $request)
    {
        $request->validate([
            'nama_proker' => 'required|string',
            'departemen_id' => 'required|exists:departemens,id',
            'pic' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Perencanaan,Berjalan,Selesai',
            'progress' => 'required|integer|min:0|max:100',
        ]);

        \App\Models\ProgramKerja::create($request->all());

        return redirect()->route('departemen.proker')->with('success', 'Program kerja berhasil ditambahkan!');
    }

    public function updateProker(Request $request, \App\Models\ProgramKerja $proker)
    {
        $request->validate([
            'nama_proker' => 'required|string',
            'pic' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Perencanaan,Berjalan,Selesai',
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $proker->update($request->all());

        return redirect()->route('departemen.proker')->with('success', 'Program kerja berhasil diperbarui!');
    }

    public function destroyProker(\App\Models\ProgramKerja $proker)
    {
        $proker->delete();
        return redirect()->route('departemen.proker')->with('success', 'Program kerja berhasil dihapus!');
    }
}
