<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();

            // --- 1. OTEL SAHİBİ (BİZİM SİSTEMİMİZ) ---
            // Bu otelin bizim sistemimizdeki sahibini (User) belirler
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // --- 2. OTEL SAHİBİNİN GİRECEĞİ (API'DE OLMAYAN) VERİLER ---
            $table->text('description')->nullable();
            $table->integer('price_per_night')->nullable(); // 'Odasız' plan için gecelik başlangıç fiyatı

            // --- 3. GOOGLE API'DEN GELEN TÜM KULLANIŞLI VERİLER ---

            // Temel Kimlik ve İletişim
            $table->string('name'); // API'den: "name"
            $table->text('address'); // API'den: "formatted_address"
            $table->string('google_place_id')->unique()->nullable(); // API'den: "place_id"

            // Puanlama (Rating)
            $table->decimal('rating', 2, 1)->nullable(); // API'den: "rating" (örn: 3.5)
            $table->integer('user_ratings_total')->nullable(); // API'den: "user_ratings_total" (örn: 2263)

            // Konum (Harita için)
            $table->decimal('latitude', 10, 7)->nullable(); // API'den: "geometry[location][lat]"
            $table->decimal('longitude', 10, 7)->nullable(); // API'den: "geometry[location][lng]"

            // Durum (Status)
            $table->string('business_status')->nullable(); // API'den: "business_status" (örn: "OPERATIONAL")
            $table->boolean('open_now')->nullable(); // API'den: "opening_hours[open_now]" (true/false)

            // Medya (Fotoğraf)
            $table->json('google_photos')->nullable(); // API'den: "photos" dizisinin tamamı

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
