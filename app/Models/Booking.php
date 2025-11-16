<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * Toplu atamaya izin verilen alanlar (Mass Assignment).
     */
    protected $fillable = [
        'user_id',
        'hotel_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'adults',
        'children',
        'status',
        'rejection_reason',
        'special_request',
    ];

    /**
     * Bu rezervasyonu yapan Müşteriyi (User) döndüren ilişki.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Bu rezervasyonun yapıldığı Oteli (Hotel) döndüren ilişki.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
