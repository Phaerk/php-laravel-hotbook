<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // <-- API İsteği için bunu ekleyin
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Sadece o an giriş yapmış olan kullanıcının (otel sahibinin) otellerini al
        $hotels = Auth::user()->hotels;

        // 2. Bu otelleri 'admin.hotels.index' view'ına gönder
        return view('admin.hotels.index', [
            'hotels' => $hotels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Yeni otel ekleme formunu (Adım 1: Arama) veya
     * arama sonuçlarını (Adım 2: Listeleme) gösterir.
     */
    /**
     * Yeni otel ekleme formunu (Adım 1) veya
     * seçilen otelin detay doldurma formunu (Adım 3) gösterir.
     */
    public function create(Request $request)
    {
        $apiKey = config('services.google.api_key');
        if (!$apiKey) {
            return back()->withErrors(['api_key' => __('Google API Anahtarı bulunamadı.')]);
        }

        // --- ADIM 3: OTEL SEÇİLDİ (place_id ile gelindiyse) ---
        if ($request->has('place_id')) {

            $existingHotel = Hotel::where('google_place_id', $request->input('place_id'))
                ->where('user_id', Auth::id())
                ->first();
            if ($existingHotel) {
                return redirect(route('admin.hotels.index'))->withErrors(['api_key' => __('Bu otel zaten listenizde mevcut.')]);
            }

            // 'Place Details' API isteği (Tüm alanları çekiyoruz)
            $response = Http::withoutVerifying()->get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $request->input('place_id'),
                'key' => $apiKey,
                'language' => 'en', // Özetlerin İngilizce gelmesi için
                'fields' => 'name,formatted_address,place_id,rating,user_ratings_total,photos,geometry,business_status,opening_hours,reviews,formatted_phone_number,website,editorial_summary'
            ]);

            if ($response->successful() && $response->json()['status'] == 'OK') {
                $selectedHotel = $response->json()['result'];

                // --- !!! DÜZELTME BURADA !!! ---
                // API'den gelen 'editorial_summary' içindeki 'overview' metnini ayıkla
                $summaryText = '';
                if (isset($selectedHotel['editorial_summary']) && isset($selectedHotel['editorial_summary']['overview'])) {
                    $summaryText = $selectedHotel['editorial_summary']['overview'];
                }
                // --- BİTİŞ ---

                return view('admin.hotels.create', [
                    'selectedHotel' => $selectedHotel,
                    'summaryText' => $summaryText // <-- Ayıkladığımız metni View'a gönder
                ]);
            } else {
                return back()->withErrors(['api_key' => __('Google Place Details API\'den otel detayı alınamadı.')]);
            }
        }

        // --- ADIM 1: ARAMA FORMUNU GÖSTERME (varsayılan) ---
        return view('admin.hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * (Adım 3) Otel sahibi tarafından seçilen ve detayları doldurulan
     * yeni oteli veritabanına kaydeder.
     */
    public function store(Request $request)
    {
        // 1. VERİYİ DOĞRULA
        // Otel sahibinin girdiği alanların (açıklama ve fiyat) zorunlu olduğundan emin ol.
        // 1. VERİYİ DOĞRULA
        $validatedData = $request->validate([
            // Zorunlu alanlar
            // 'min:50' -> "required|string|min:50" olarak güncellendi.
            // Bu, kullanıcının API özetini silip boş göndermesini engeller.
            'description' => 'required|string|min:20', // Minimum 20 karakter zorunlu
            'price_per_night' => 'required|integer|min:1',

            // Gizli (hidden) inputlardan gelen API verisi
            'name' => 'required|string',
            'address' => 'required|string',
            // 'editorial_summary' artık 'store' için gerekli değil, siliyoruz.
            // ...
            'google_place_id' => 'required|string|unique:hotels,google_place_id,NULL,id,user_id,' . Auth::id(),
            'rating' => 'nullable|numeric',
            'user_ratings_total' => 'nullable|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'business_status' => 'nullable|string',
            'open_now' => 'nullable|boolean',
            'google_photos' => 'nullable|json',
            'google_reviews' => 'nullable|json',
            'formatted_phone_number' => 'nullable|string',
            'website' => 'nullable|string|url',
            // 'editorial_summary' KURALI BURADAN SİLİNDİ
        ]);

        // 2. OTELİ OLUŞTUR
        // 'user_id' (otel sahibinin ID'si) dışındaki tüm veriyi $validatedData'dan al
        // Auth::user()->hotels()->create(...) komutu, 'user_id'yi otomatik olarak
        // o an giriş yapmış olan kullanıcıya ayarlar.
        try {
            Auth::user()->hotels()->create($validatedData);

        } catch (\Exception $e) {
            // Veritabanı hatası olursa (örn: unique kuralı ihlali)
            Log::error('Otel kaydı başarısız: ' . $e->getMessage());
            return back()->withErrors(['db_error' => 'Otel kaydedilirken bir hata oluştu. Lütfen tekrar deneyin.']);
        }

        // 3. BAŞARIYLA YÖNLENDİR
        // Otel kaydedildikten sonra, otel sahibini otel listesine geri yönlendir
        // ve bir başarı mesajı göster.
        return redirect(route('admin.hotels.index'))
            ->with('success', 'Oteliniz başarıyla eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Belirtilen oteli düzenleme formunu gösterir.
     */
    public function edit(Hotel $hotel) // Laravel 'Hotel' modelini otomatik olarak bulur (Route Model Binding)
    {
        // Güvenlik: Otel sahibi, sadece kendi otelini düzenleyebilmeli
        if ($hotel->user_id !== Auth::id()) {
            abort(403); // Yasak (Bu otel size ait değil)
        }

        return view('admin.hotels.edit', [
            'hotel' => $hotel
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Belirtilen oteli veritabanında günceller.
     */
    public function update(Request $request, Hotel $hotel)
    {
        // 1. GÜVENLİK KONTROLÜ
        // Otel sahibi, sadece kendi otelini güncelleyebilmeli
        if ($hotel->user_id !== Auth::id()) {
            abort(403); // Yasak (Bu otel size ait değil)
        }

        // 2. VERİYİ DOĞRULA
        // Sadece otel sahibinin değiştirebildiği alanları doğrula
        $validatedData = $request->validate([
            'description' => 'required|string|min:50',
            'price_per_night' => 'required|integer|min:1',
        ]);

        // 3. MODELİ GÜNCELLE
        // 'update' metodu, $validatedData içindeki verilerle
        // $hotel modelini günceller ve veritabanına kaydeder.
        try {
            $hotel->update($validatedData);

        } catch (\Exception $e) {
            Log::error('Otel güncellemesi başarısız: ' . $e->getMessage());
            return back()->withErrors(['db_error' => 'Otel güncellenirken bir hata oluştu. Lütfen tekrar deneyin.']);
        }

        // 4. BAŞARIYLA YÖNLENDİR
        // Otel güncellendikten sonra, otel sahibini otel listesine geri yönlendir
        // ve bir başarı mesajı göster.
        return redirect(route('admin.hotels.index'))
            ->with('success', 'Otel bilgileri başarıyla güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Belirtilen oteli veritabanından siler.
     */
    public function destroy(Hotel $hotel)
    {
        // 1. GÜVENLİK KONTROLÜ
        // Otel sahibi, sadece kendi otelini silebilir
        if ($hotel->user_id !== Auth::id()) {
            abort(403); // Yasak (Bu otel size ait değil)
        }

        // 2. SİLME İŞLEMİ
        try {
            $hotel->delete();

        } catch (\Exception $e) {
            Log::error('Otel silinmesi başarısız: ' . $e->getMessage());
            return back()->withErrors(['db_error' => 'Otel silinirken bir hata oluştu. Lütfen tekrar deneyin.']);
        }

        // 3. BAŞARIYLA YÖNLENDİR
        // Otel silindikten sonra, otel listesine geri yönlendir
        return redirect(route('admin.hotels.index'))
            ->with('success', 'Otel başarıyla silindi.');
    }
}
