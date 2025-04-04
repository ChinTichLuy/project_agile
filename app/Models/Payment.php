<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'payment_details',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_details' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    const PAYMENT_METHOD_VNPAY = 'vnpay';
    const PAYMENT_METHOD_MOMO = 'momo';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, ',', '.') . ' VNĐ';
    }

    public function getPaymentMethodTextAttribute()
    {
        return match($this->payment_method) {
            self::PAYMENT_METHOD_VNPAY => 'VNPay',
            self::PAYMENT_METHOD_MOMO => 'Momo',
            default => 'Unknown',
        };
    }
}
