<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $fillable = [
        'name',
        'description',
        'keyword',
        'publish',
    ];
    protected $table = 'widgets';


    protected $casts = [
        'item' => 'json',
        'setting' => 'json'
    ];

}
