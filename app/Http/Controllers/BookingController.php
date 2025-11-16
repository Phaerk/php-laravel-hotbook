<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Müşterinin rezervasyon talebini veritabanına kaydeder.
     */
    public function store(Request $request, Hotel $hotel)
    {
        // 1. VERİYİ DOĞRULA
        $validatedData = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'special_request' => 'nullable|string|max:1000',
        ]);

        // 2. FİYATI HESAPLA
        try {
            $checkIn = Carbon::parse($validatedData['check_in_date']);
            $checkOut = Carbon::parse($validatedData['check_out_date']);
            $numberOfNights = $checkIn->diffInDays($checkOut);
            if ($numberOfNights <= 0) {
                return back()->withErrors(['check_out_date' => __('Check-out date must be at least one day after check-in.')]);
            }
            $totalPrice = $numberOfNights * $hotel->price_per_night;
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => __('An error occurred while calculating the dates. Please try again.')]);
        }

        // 3. REZERVASYONU VERİTABANINA KAYDET
        Booking::create([
            'user_id' => Auth::id(),
            'hotel_id' => $hotel->id,

            'check_in_date' => $checkIn->format('Y-m-d'),
            'check_out_date' => $checkOut->format('Y-m-d'),
            'adults' => $validatedData['adults'],
            'children' => $validatedData['children'],
            'special_request' => $validatedData['special_request'] ?? null,

            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // 4. KULLANICIYI YÖNLENDİR
        // !!! DÜZELTME BURADA: Mesajı __('...') içine aldık !!!
        return redirect(route('my-bookings'))
            ->with('success', __('Your reservation request has been sent successfully! You will be notified once the hotel owner approves it.'));
    }

    // 'myBookings' fonksiyonu (Daha önce eklemiştik, burada da dursun)
    public function myBookings()
    {
        $bookings = Auth::user()
            ->bookings()
            ->with('hotel')
            ->latest()
            ->get();

        return view('my-bookings', [
            'bookings' => $bookings
        ]);
    }
}
