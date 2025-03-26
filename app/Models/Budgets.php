<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budgets extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'church_id',
        'department_id',
        'type_id',
        'amount',
        'purpose',
    ];
}
