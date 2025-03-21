<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory; protected $fillable = [
        'member_type_id',
        'family_type_id',
        'parent_id',
        'address',
        'email',
        'phone',
        'check_in',
        'check_out',
        'church_id',
    ];
}
