<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin (Otel Sahibi) dashboard'ını gösterir ve
     * istatistik kartları için verileri hesaplar.
     */
    public function index()
    {
        // 1. O an giriş yapmış olan otel sahibinin otellerinin ID'lerini al
        $ownerHotelIds = Auth::user()->hotels()->pluck('id');

        // 2. İstatistikleri Hesapla

        // Toplam Otel Sayısı
        $totalHotels = $ownerHotelIds->count();

        // Bekleyen Rezervasyon Sayısı
        $pendingBookingsCount = Booking::whereIn('hotel_id', $ownerHotelIds)
            ->where('status', 'pending')
            ->count();

        // Toplam Kazanç (Sadece 'onaylanmış' rezervasyonlardan)
        $totalEarnings = Booking::whereIn('hotel_id', $ownerHotelIds)
            ->where('status', 'approved')
            ->sum('total_price'); // 'total_price' sütununu topla

        // 3. Veriyi 'admin.dashboard' view'ına gönder
        return view('admin.dashboard', [
            'totalHotels' => $totalHotels,
            'pendingBookingsCount' => $pendingBookingsCount,
            'totalEarnings' => $totalEarnings,
        ]);
    }
}
