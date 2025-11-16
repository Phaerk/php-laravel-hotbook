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
        Schema::table('hotels', function (Blueprint $table) {
            // 'google_reviews' sütunundan sonra bu 3 yeni sütunu ekle
            $table->string('formatted_phone_number')->nullable()->after('google_reviews');
            $table->string('website')->nullable()->after('formatted_phone_number');

            // Google'ın özeti bir nesne (text/language) olarak gelebilir, JSON en güvenlisidir.
            $table->json('editorial_summary')->nullable()->after('website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            // Eklediğimiz 3 sütunu da sil
            $table->dropColumn(['formatted_phone_number', 'website', 'editorial_summary']);
        });
    }
};
