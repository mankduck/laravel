<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'country',
        'phone',
        'address',
        'email',
        'description',
        'payment_method',
        'product',
        'status'
    ];

    protected $casts = [
        'product' => 'array'
    ];
}
