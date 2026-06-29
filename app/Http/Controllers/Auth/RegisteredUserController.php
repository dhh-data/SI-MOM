<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
{
    $departemens = \App\Models\Departemen::all();
    return view('auth.register', compact('departemens'));
}

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name'         => ['required', 'string', 'max:255'],
        'nim'          => ['required', 'string', 'unique:users,nim'],
        'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'no_hp'        => ['nullable', 'string', 'max:20'],
        'angkatan'     => ['required', 'string'],
        'departemen_id'=> ['required', 'exists:departemens,id'],
        'jabatan'      => ['required', 'in:Ketua Umum,Sekretaris,Kepala Departemen,Staff'],
        'role'         => ['required', 'in:admin,kepala_departemen,kepala_inventaris,anggota'],
        'password'     => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name'          => $request->name,
        'nim'           => $request->nim,
        'email'         => $request->email,
        'no_hp'         => $request->no_hp,
        'angkatan'      => $request->angkatan,
        'departemen_id' => $request->departemen_id,
        'jabatan'       => $request->jabatan,
        'role'          => $request->role,
        'password'      => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}
