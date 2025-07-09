<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Generate Sanctum token
            $user = Auth::user();
            $token = $user->createToken('website-app')->plainTextToken;

            // Sync login with software-app
            // Http::withToken($token)->post(config('services.software_app.url') . '/api/login-sync', [
            //     'token' => $token,
            // ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $token = $user->currentAccessToken()->token ?? null;

        // Logout from software-app
        if ($token) {
            Http::withToken($token)->post(config('services.software_app.url') . '/api/logout-sync');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

     public function register(Request $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

     public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }
}