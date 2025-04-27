<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetailKiloan extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'price_list_kiloan_id',
        'quantity',
        'price',
        'sub_total',
    ];

    protected $table = 'transaction_details_kiloan';

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function price_list_kiloan(): BelongsTo
    {
        return $this->belongsTo(PriceListKiloan::class);
    }

    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted number of sub total
     *
     * @return string
     */
    public function getFormattedSubTotal(): string
    {
        return 'Rp ' . number_format($this->sub_total, 0, ',', '.');
    }
}
