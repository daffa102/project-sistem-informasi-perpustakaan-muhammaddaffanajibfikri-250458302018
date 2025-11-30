<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'borrowing_id', 'amount', 'paid'
    ];
      protected $casts = [
        'amount' => 'decimal:2',
        'paid' => 'boolean',
    ];

    const FINE_PER_DAY = 1000; // Rp 1000 per hari

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    // Calculate fine amount
    public static function calculateFine($daysLate)
    {
        return $daysLate * self::FINE_PER_DAY;
    }

    
}
