<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name',
        'description',
        'model_id',
        'short_code',
        'model',
        'album',
        'keyword',
        'publish',
    ];
    protected $table = 'promotion';
}
