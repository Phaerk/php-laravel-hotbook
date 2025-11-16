<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Auth (Kimlik) sınıfını kullanacağımızı belirtiyoruz
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Gelen isteği işle.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role (Beklediğimiz rol, örn: 'hotel_owner')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Kullanıcı giriş yapmış mı? VE
        // 2. Giriş yapan kullanıcının rolü, bizim beklediğimiz $role ile aynı mı?
        if (!Auth::check() || Auth::user()->role !== $role) {

            // Eğer değilse, kullanıcıyı ana sayfaya geri yönlendir.
            return redirect('/');
        }

        // Eğer tüm kontrollerden geçtiyse (yani rolü 'hotel_owner' ise),
        // isteğin devam etmesine izin ver (yani admin paneline girmesine).
        return $next($request);
    }
}
