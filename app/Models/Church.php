<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo',
        'address',
        'us_status_id',
        'country_id',
    ];
}
