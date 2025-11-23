<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // Validasi minimum
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk mencegah fixation dan refresh token CSRF
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'pengunjung',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

        // FORM: Forgot Password
        public function forgotForm()
        {
            return view('auth.forgot');
        }

        // POST: Send Reset Link (dummy, no email, just redirect to reset form)
        public function sendResetLink(Request $request)
        {
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak ditemukan']);
            }
            // Simulasi token (sebenarnya harus email, tapi di sini langsung redirect)
            $token = base64_encode($user->email);
            return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email]);
        }

        // FORM: Reset Password
        public function resetForm(Request $request, $token)
        {
            $email = $request->email ?? base64_decode($token);
            return view('auth.reset', ['token' => $token, 'email' => $email]);
        }

        // POST: Update Password
        public function resetPassword(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'token' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak ditemukan']);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('login')->with('success', 'Password berhasil direset, silakan login.');
        }
}
