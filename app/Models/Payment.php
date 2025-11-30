<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payment extends Model
{
    use HasUuids;

    protected $fillable = [
        'fine_id',
        'member_id',
        'order_id',
        'amount',
        'payment_type',
        'transaction_status',
        'transaction_id',
        'snap_token',
        'paid_at',
        'midtrans_response',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'midtrans_response' => 'array',
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function fine()
    {
        return $this->belongsTo(Fine::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('transaction_status', 'pending');
    }

    public function scopeSuccess($query)
    {
        return $query->where('transaction_status', 'settlement');
    }

    // Helper methods
    public function isPaid()
    {
        return $this->transaction_status === 'settlement';
    }

    public function isFailed()
    {
        return in_array($this->transaction_status, ['deny', 'cancel', 'expire']);
    }
}
