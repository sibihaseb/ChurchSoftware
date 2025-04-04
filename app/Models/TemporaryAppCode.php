<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryAppCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'church_id',
        'user_id',
    ];
}
