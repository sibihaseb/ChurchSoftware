<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'email', 'billing_address', 'sales_receipt_date', 'tags', 'payment_method', 'deposit_to'];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
