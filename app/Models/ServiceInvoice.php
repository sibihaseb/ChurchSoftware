<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'billing_address',
        'sales_receipt_date',
        'tags',
        'payment_method',
        'deposit_to',
        'church_id'
    ];

    public function items()
    {
        return $this->hasMany(ServiceInvoiceItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
