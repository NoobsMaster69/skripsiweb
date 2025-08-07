<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProses(Request $request)
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required|min:8',
        ], [
            'email.required'    => 'Email Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min' => 'Password Minimal 8 Karakter',
        ]);

        $data = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 🔁 Redirect sesuai jabatan user
            switch ($user->jabatan) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
                case 'rektorat':
                    return redirect()->route('rektorat.dashboard')->with('success', 'Selamat datang Rektorat!');
                case 'fakultas':
                    return redirect()->route('fakultas.dashboard')->with('success', 'Selamat datang Fakultas!');
                case 'prodi':
                    return redirect()->route('prodi.dashboard')->with('success', 'Selamat datang Prodi!');
                case 'dosen':
                    return redirect()->route('cpl-dosen')->with('success', 'Selamat datang Dosen!');
                default:
                    return redirect()->route('dashboard')->with('success', 'Selamat datang!');
            }
        }

        return redirect()->back()->with('error', 'Email atau Password Salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success','Anda Berhasil Logout');
    }
}
