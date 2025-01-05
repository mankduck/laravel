<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, QueryScopes, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'code',
        'description',
        'method',
        'discountInformation',
        'neverEndDate',
        'startDate',
        'endDate',
        'publish',
        'order',
        'maxDiscountValue',
        'discountValue',
        'discountType',
    ];
    protected $table = 'promotions';

    protected $casts = [
        'discountInformation' => 'json',
    ];

    public function products()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product_variant', 'promotion_id', 'product_id')
            ->withPivot(
                'variant_uuid',
                'model',
            )->withTimestamps();
    }
}
