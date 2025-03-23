<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory, Billable;

    protected $fillable = [
        'first_name',
        'last_name',
        'member_type_id',
        'address',
        'email',
        'phone',
        'check_in',
        'check_out',
        'church_id',
    ];
}
