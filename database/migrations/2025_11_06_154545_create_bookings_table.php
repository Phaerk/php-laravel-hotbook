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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // Rezervasyon ID'si

            // --- İLİŞKİLER ---

            // Rezervasyonu yapan MÜŞTERİ (User)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Rezerve edilen OTEL (Hotel)
            // (Artık 'room_id' değil, 'hotel_id' kullanıyoruz)
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();

            // --- REZERVASYON DETAYLARI ---

            $table->date('check_in_date'); // Giriş tarihi
            $table->date('check_out_date'); // Çıkış tarihi
            $table->integer('total_price')->nullable(); // Hesaplanan toplam fiyat
            $table->integer('adults')->default(1); // Yetişkin sayısı
            $table->integer('children')->default(0); // Çocuk sayısı

            // --- REZERVASYON DURUMU (EN ÖNEMLİSİ) ---
            // Otel sahibinin onayı için
            $table->string('status')->default('pending'); // pending (beklemede), approved (onaylandı), rejected (reddedildi)

            // Otel sahibi reddederse açıklama yazabilmesi için
            $table->text('rejection_reason')->nullable();

            $table->timestamps(); // (created_at ve updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
