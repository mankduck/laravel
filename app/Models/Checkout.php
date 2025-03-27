<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'country',
        'phone',
        'address',
        'email',
        'description',
        'payment_method',
        'product',
        'status',
        'total'
    ];

    protected $casts = [
        'product' => 'array'
    ];
}
