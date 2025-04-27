<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceListKiloan extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_kiloan_id',
        'heavy',
        'price',
    ];

    protected $table = 'price_lists_kiloan';

    public function category_kiloan(): BelongsTo
    {
        return $this->belongsTo(CategoryKiloan::class);
    }

    public function transaction_details_Kiloan(): BelongsTo
    {
        return $this->belongsTo(TransactionDetailKiloan::class);
    }

    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
