<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Catat aktivitas login (khusus mahasiswa)
            $user = auth()->user();
            if ($user->role === 'mahasiswa' && $user->mahasiswa) {
                Aktivitas::create([
                    'mahasiswa_id' => $user->mahasiswa->id,
                    'aktivitas'    => 'Login ke sistem',
                    'waktu'        => now(),
                ]);
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        // Catat aktivitas logout
        if (auth()->check() && auth()->user()->role === 'mahasiswa' && auth()->user()->mahasiswa) {
            Aktivitas::create([
                'mahasiswa_id' => auth()->user()->mahasiswa->id,
                'aktivitas'    => 'Logout dari sistem',
                'waktu'        => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}