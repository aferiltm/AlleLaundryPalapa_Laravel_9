<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryKiloan extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'categories_kiloan';

    /**
     * Price list relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function price_lists_kiloan(): HasMany
    {
        return $this->hasMany(PriceListKiloan::class);
    }
}
