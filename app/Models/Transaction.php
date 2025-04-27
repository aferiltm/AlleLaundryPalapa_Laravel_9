<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'status_id',
        'admin_id',
        'member_id',
        'discount',
        'total',
        'service_type_id',
        'service_cost',
        'payment_amount',
    ];

    /**
     * Member relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Admin relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Status relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Transaction detail relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction_details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function service_type(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class , 'service_type_id');
    }

    public function price_list()
    {
        return $this->belongsTo(PriceList::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function transaction_details_kiloan(): HasMany
    {
        return $this->hasMany(TransactionDetailKiloan::class);
    }
    public function price_list_kiloan()
{
    return $this->belongsTo(PriceListKiloan::class);
}
    public function category_kiloan()
    {
        return $this->belongsTo(Category::class , 'category_kiloan_id');
    }


    /**
     * Get formatted number of total
     *
     * @return string
     */
    public function getFormattedTotal(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get formatted number of payment amount
     *
     * @return string
     */
    public function getFormattedPaymentAmount(): string
    {
        return 'Rp ' . number_format($this->payment_amount, 0, ',', '.');
    }

    /**
     * Get formatted number of service cost
     *
     * @return string
     */
    public function getFormattedServiceCost(): string
    {
        return 'Rp ' . number_format($this->service_cost, 0, ',', '.');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ComplaintSuggestion::class, 'transaction_id');
    }

    public function hasReview(): bool
    {
        return $this->reviews()->exists(); // Mengecek apakah transaksi sudah memiliki ulasan
    }

}
