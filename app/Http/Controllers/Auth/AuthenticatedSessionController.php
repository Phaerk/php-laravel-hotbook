<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- YÖNLENDİRME MANTIĞI BURADA BAŞLIYOR ---

        // O an giriş yapan kullanıcıyı al
        $user = Auth::user();

        // Kullanıcının rolüne göre nereye gideceğine karar ver
        // 'match' ifadesi, 'if/else' bloğunun modern bir alternatifidir
        $redirectUrl = match($user->role) {
            'hotel_owner' => route('admin.dashboard'), // Rol 'hotel_owner' ise admin paneline
            'customer' => route('dashboard'),      // Rol 'customer' ise müşteri paneline
            default => route('dashboard'),         // Başka bir rol varsa (veya rol yoksa) müşteri paneline
        };

        // Kullanıcıyı, gitmek istediği yere (veya rolüne uygun panele) yönlendir
        // intended() -> Kullanıcı /admin/hotels gibi korumalı bir sayfaya gitmeye çalıştıysa,
        //               giriş yaptıktan sonra onu oraya geri yollar.
        return redirect()->intended($redirectUrl);

        // --- YÖNLENDİRME MANTIĞI BURADA BİTİYOR ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
