<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Request;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'email',
        'city',
        'name',
        'password',
        'phone',
        'account_type',
        'status',
        'role',
        'church_id',
        'address',
        'state_id',
        'postal_code',
        'check_in',
        'check_out',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    public function invoices()
    {
        return $this->hasMany(ServiceInvoice::class, 'member_id');
    }

    public function getStatusAttribute($value)
    {
        // Get the current request instance
        $request = Request::instance();
        // Check if the current request is for the create or edit form
        if ($request->route()->getName() == 'adminuser.index' || $request->route()->getName() == 'doners.index') {
            if ($value == 1) {
                return '<i id="' . $this->id . '" data-status="0" class="status_active ri-check-double-fill ri-lg text-success"></i>';
            } else {
                return '<i id="' . $this->id . '" data-status="1" class="status_active ri-close-circle-fill ri-lg text-danger"></i> ';
            }
        } else {
            return $value ? 1 : 0;
        }
    }
}
