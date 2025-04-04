<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if ($request->has('redirect_to') && $request->redirect_to === 'subscription') {
            session(['redirect_to_subscription' => true]);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Kiểm tra nếu đang từ trang đăng ký gói VIP
            if (session('redirect_to_subscription')) {
                session()->forget('redirect_to_subscription');
                return redirect()->route('subscription.plans');
            }

            // Kiểm tra quyền admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('movies.index'));
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng'
        ])->onlyInput('email');
    }

    public function showRegisterForm(Request $request)
    {
        if ($request->has('redirect_to') && $request->redirect_to === 'subscription') {
            session(['redirect_to_subscription' => true]);
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        // Kiểm tra nếu đang từ trang đăng ký gói VIP
        if (session('redirect_to_subscription')) {
            session()->forget('redirect_to_subscription');
            return redirect()->route('subscription.plans');
        }

        return redirect()->route('movies.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
