<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $fillable = [
        'name',
        'description',
        'keyword',
        'image',
        'item',
        'setting',
        'short_code',
        'publish',
        'order',
    ];
    protected $table = 'slides';


    protected $casts = [
        'item' => 'json',
        'setting' => 'json'
    ];

}
