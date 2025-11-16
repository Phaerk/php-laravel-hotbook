<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    /**
     * Otel sahibinin otellerine ait rezervasyonları listeler.
     */
    public function index()
    {
        // 1. O an giriş yapmış olan otel sahibinin 'hotel' ID'lerini al
        $ownerHotelIds = Auth::user()->hotels()->pluck('id');

        // 2. Sadece bu otellere ait olan rezervasyonları ('bookings') çek
        $bookings = Booking::whereIn('hotel_id', $ownerHotelIds)
            ->with('customer', 'hotel')
            ->orderBy('status', 'asc') // 'pending' olanlar en üstte görünsün
            ->orderBy('created_at', 'desc') // Yeni gelenler en üstte
            ->get();

        // 3. Veriyi 'admin.bookings.index' view'ına gönder
        return view('admin.bookings.index', [
            'bookings' => $bookings
        ]);
    }

    // --- YENİ EKLENEN FONKSİYONLAR ---

    /**
     * Bekleyen bir rezervasyonu onaylar ('approved').
     */
    public function approve(Booking $booking)
    {
        // 1. Güvenlik Kontrolü: Bu otel sahibi, bu rezervasyonu yönetebilir mi?
        // (Rezervasyonun ait olduğu otelin sahibinin ID'si, giriş yapanın ID'si ile eşleşmeli)
        if ($booking->hotel->user_id !== Auth::id()) {
            abort(403, 'Bu işlem için yetkiniz yok.');
        }

        // 2. Sadece 'beklemede' olanı onayla
        if ($booking->status === 'pending') {
            $booking->status = 'approved';
            $booking->rejection_reason = null; // Reddetme nedeni varsa temizle
            $booking->save();

            // TODO: İleride müşteriye "Rezervasyonunuz Onaylandı" e-postası gönderilebilir.

            return redirect(route('admin.bookings.index'))
                ->with('success', 'Rezervasyon başarıyla onaylandı.');
        }

        return redirect(route('admin.bookings.index'))
            ->withErrors(['error' => 'Bu rezervasyon üzerinde işlem yapılamaz.']);
    }

    /**
     * Bekleyen bir rezervasyonu reddeder ('rejected').
     */
    public function reject(Request $request, Booking $booking)
    {
        // 1. Güvenlik Kontrolü
        if ($booking->hotel->user_id !== Auth::id()) {
            abort(403, 'Bu işlem için yetkiniz yok.');
        }

        // 2. Sadece 'beklemede' olanı reddet
        if ($booking->status === 'pending') {

            // --- GÜNCELLEME: Formdan gelen nedeni doğrula ---
            // Popup'taki 'rejection_reason' textarea'sından gelen veriyi doğrula
            $request->validate([
                'rejection_reason' => 'required|string|min:10|max:500' // Neden girmek zorunlu
            ]);

            $booking->status = 'rejected';
            $booking->rejection_reason = $request->input('rejection_reason'); // Doğrulanmış nedeni kaydet
            $booking->save();

            return redirect(route('admin.bookings.index'))
                ->with('success', 'Rezervasyon başarıyla reddedildi.');
        }

        return redirect(route('admin.bookings.index'))
            ->withErrors(['error' => 'Bu rezervasyon üzerinde işlem yapılamaz.']);
    }
}
