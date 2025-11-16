<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Hotel;

// --- GEREKLİ TÜM CONTROLLER'LAR ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicHotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelImageController; // Güvenli fotoğraf için

/*
|--------------------------------------------------------------------------
| DİL DEĞİŞTİRME ROTASI (Bunu ellemeyin, çalışıyor)
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'tr', 'es'])) {
        abort(400);
    }
    Session::put('locale', $locale);
    return redirect()->back();
})->name('switch.language');

/*
|--------------------------------------------------------------------------
| 1. Herkese Açık "Hotelier" Rotaları
|--------------------------------------------------------------------------
*/

// !!! YENİ GÜVENLİK ROTASI !!!
// Google Fotoğraf Proxy Rotası (API Anahtarını gizler)
Route::get('/hotel-image/{reference}', [HotelImageController::class, 'show'])->name('hotel.image');

// Ana Sayfa (Öne Çıkan Otellerle)
Route::get('/', function () {
    $featuredHotels = Hotel::latest()->take(3)->get();
    return view('home', [
        'featuredHotels' => $featuredHotels
    ]);
});

// Statik Sayfalar
Route::get('/about', function () { return view('about'); });
Route::get('/for-hotel-owners', function () { return view('service'); });
Route::get('/contact', function () { return view('contact'); });

// Dinamik Müşteri Rotaları
Route::get('/hotels', [PublicHotelController::class, 'index'])->name('hotels.index');

// !!! DÜZELTME: Rota artık {place_id} (string) alıyor, {hotel} (model) değil !!!
Route::get('/hotel/{place_id}', [PublicHotelController::class, 'show'])->name('hotel.detail');


/*
|--------------------------------------------------------------------------
| 2. Korumalı Müşteri Rotaları
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Müşteri Dashboard'u
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // "Rezervasyonlarım" sayfası (Müşteri)
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');

    // Rezervasyon Yapma (POST)
    Route::post('/booking/store/{hotel}', [BookingController::class, 'store'])->name('booking.store');

    // Profil Düzenleme Rotaları
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| 3. Admin Panel (Otel Sahibi) Rotaları
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hotel_owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('hotels', HotelController::class);
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
});


/*
|--------------------------------------------------------------------------
| 4. Auth Dosyaları (En Altta Kalmalı)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
// 'profile.php' rotasını manuel eklediğimiz için burada require edilmemeli.
