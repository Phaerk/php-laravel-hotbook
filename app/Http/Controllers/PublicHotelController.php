<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PublicHotelController extends Controller
{
    /**
     * Otel listeleme sayfasını (/hotels) gösterir.
     * HİBRİT ARAMA
     */
    /**
     * Otel listeleme sayfasını (/hotels) gösterir.
     * HİBRİT ARAMA ve HİBRİT SIRALAMA
     */
    public function index(Request $request)
    {
        $isApiSearch = false;
        $hotels = [];
        $old_input = $request->all(); // Arama ve sıralama değerlerini al
        $sortBy = $request->input('sort_by'); // Yeni 'sort_by' parametresi

        // 1. ARAMA VAR MI? (Google API Araması)
        if ($request->filled('location')) {

            $isApiSearch = true;
            $locationQuery = $request->input('location');

            if (stripos($locationQuery, 'hotel') === false) {
                $apiQuery = 'hotels in ' . $locationQuery;
            } else {
                $apiQuery = $locationQuery;
            }

            $apiKey = config('services.google.api_key');
            if (!$apiKey) { return back()->withErrors(['api_key' => 'Google API Anahtarı bulunamadı.']); }

            $response = Http::withoutVerifying()->get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => $apiQuery, 'key' => $apiKey, 'language' => 'en', 'type' => 'lodging'
            ]);

            if ($response->successful() && $response->json()['status'] == 'OK') {
                $hotels = $response->json()['results'];

                // --- !!! CV İÇİN ÖNEMLİ BÖLÜM (API SIRALAMA) !!! ---
                // Google'dan gelen DİZİ'yi (array) bir KOLEKSİYON'a (collection) çeviriyoruz
                // Bu, Laravel'in güçlü sıralama fonksiyonlarını kullanmamızı sağlar.
                $hotelsCollection = collect($hotels);

                if ($sortBy === 'rating_desc') {
                    // Puana göre (azalan) sırala
                    $hotels = $hotelsCollection->sortByDesc('rating')->all();
                } elseif ($sortBy === 'popularity_desc') {
                    // Yorum sayısına (azalan) sırala
                    $hotels = $hotelsCollection->sortByDesc('user_ratings_total')->all();
                }
                // (API aramasında FİYAT (price) sıralaması yapamayız, çünkü API fiyatı vermez)
                // --- SIRALAMA BİTTİ ---
            }

        }
        // 2. ARAMA YOK MU? (Bizim Veritabanı Aramamız)
        else {
            $isApiSearch = false;

            $queryBuilder = Hotel::query(); // Sorguyu başlat

            // Fiyat Filtresi (Sadece burada çalışır)
            if ($request->filled('max_price')) {
                $queryBuilder->where('price_per_night', '<=', $request->input('max_price'));
            }

            // --- !!! CV İÇİN ÖNEMLİ BÖLÜM (SQL SIRALAMA) !!! ---
            // SQL sorgusuna 'orderBy' ekliyoruz (bu, koleksiyondan daha performanslıdır)
            if ($sortBy === 'rating_desc') {
                $queryBuilder->orderBy('rating', 'desc');
            } elseif ($sortBy === 'popularity_desc') {
                $queryBuilder->orderBy('user_ratings_total', 'desc');
            } elseif ($sortBy === 'price_asc') {
                $queryBuilder->orderBy('price_per_night', 'asc');
            } else {
                // Varsayılan sıralama (en yeni)
                $queryBuilder->latest();
            }
            // --- SIRALAMA BİTTİ ---

            $hotels = $queryBuilder->get();
        }

        // 3. Veriyi View'a Gönder
        return view('room', [
            'hotels' => $hotels,
            'isApiSearch' => $isApiSearch,
            'old_input' => $old_input
        ]);
    }

    /**
     * Tek bir otelin detay sayfasını (/hotel/{place_id}) gösterir.
     * (Bu fonksiyonda değişiklik yok, hibrit mantığı zaten çalışıyor)
     */
    public function show(string $place_id)
    {
        // 1. KONTROL: Bizde kayıtlı mı?
        $partnerHotel = Hotel::where('google_place_id', $place_id)->first();

        // 2. SENARYO A (Partner Otel): Evet, kayıtlı.
        if ($partnerHotel) {
            return view('hotel-detail', [
                'hotel' => $partnerHotel
            ]);
        }

        // 3. SENARYO B (Halka Açık Otel): Hayır, kayıtlı değil.
        $apiKey = config('services.google.api_key');
        $response = Http::withoutVerifying()->get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $place_id,
            'key' => $apiKey,
            'language' => 'en',
            'fields' => 'name,formatted_address,photos,rating,user_ratings_total,reviews,formatted_phone_number,website'
        ]);

        if (!$response->successful() || $response->json()['status'] !== 'OK') {
            abort(404, 'Hotel details could not be found on Google.');
        }

        $googleHotelData = $response->json()['result'];

        return view('hotel-detail-public', [
            'hotelData' => $googleHotelData
        ]);
    }
}
