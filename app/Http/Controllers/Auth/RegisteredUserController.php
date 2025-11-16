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
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_hotel_owner' => ['nullable', 'boolean'],

            // --- YENİ EKLENEN TELEFON KURALI ---
            // 'nullable' -> Zorunlu değil
            // 'string' -> Metin olmalı
            // 'max:20' -> Maksimum 20 karakter (örn: +90 555 ...)
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'role' => $request->has('is_hotel_owner') ? 'hotel_owner' : 'customer',

            // --- YENİ EKLENEN TELEFON KAYDI ---
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Rol'e göre yönlendirme (Bu kod zaten vardı)
        $redirectUrl = match($user->role) {
            'hotel_owner' => route('admin.dashboard'),
            'customer' => route('dashboard'),
            default => route('dashboard'),
        };

        return redirect()->intended($redirectUrl);
    }
}
