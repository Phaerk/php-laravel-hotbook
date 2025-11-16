<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'google_place_id',
        'rating',
        'user_ratings_total',
        // 'photo_reference' SİLİNDİ
        'google_photos', // <-- YENİ EKLENDİ
        'business_status',
        'latitude',
        'longitude',
        'open_now',
        'description',
        'price_per_night',
        'google_reviews',
        'formatted_phone_number',
        'website',
        // 'editorial_summary' (description'a birleştirdiğimiz için) burada olmamalı
    ];

    protected $casts = [
        'google_reviews' => 'array',
        'open_now' => 'boolean',
        // 'editorial_summary' (artık kullanmıyoruz)
        'google_photos' => 'array', // <-- YENİ EKLENDİ (JSON'ı diziye çevir)
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
