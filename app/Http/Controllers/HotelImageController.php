<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HotelImageController extends Controller
{
    /**
     * Google'dan bir fotoğraf referansını alır, API isteğini sunucu tarafında yapar
     * ve sonucu tarayıcıya bir resim olarak geri döndürür.
     */
    public function show($reference)
    {
        $apiKey = config('services.google.api_key');

        if (!$apiKey) {
            Log::error('Google API Anahtarı bulunamadı (HotelImageController).');
            abort(500, 'API Key not configured');
        }

        try {
            // Google'ın fotoğraf API'sine sunucu taraflı istek
            $response = Http::withoutVerifying()->get('https://maps.googleapis.com/maps/api/place/photo', [
                'maxwidth' => 800, // Resimlerin genişliğini standart hale getirelim
                'photoreference' => $reference,
                'key' => $apiKey,
            ]);

            if ($response->failed()) {
                Log::warning("Google Photo API isteği başarısız oldu. Referans: $reference");
                abort(404, 'Image not found');
            }

            // Google'dan gelen resmi, doğru 'Content-Type' (image/jpeg vb.)
            // başlığıyla tarayıcıya geri gönder.
            return response($response->body())
                ->header('Content-Type', $response->header('Content-Type'))
                ->header('Cache-Control', 'public, max-age=86400'); // Resmi 1 gün cache'le

        } catch (\Exception $e) {
            Log::error("Fotoğraf proxy hatası: " . $e->getMessage());
            abort(500, 'Error processing image.');
        }
    }
}
