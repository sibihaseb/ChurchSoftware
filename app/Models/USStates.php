<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class USStates extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];
}
