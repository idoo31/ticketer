<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'trx_code',
        'user_id',
        'subtotal',
        'service_fee',
        'tax',
        'grand_total',
        'payment_method',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'     => 'decimal:2',
            'service_fee'  => 'decimal:2',
            'tax'          => 'decimal:2',
            'grand_total'  => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
