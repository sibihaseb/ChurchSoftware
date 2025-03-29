<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_invoice_id',
        'product_id',
        'description',
        'qty',
        'rate',
        'amount'
    ];

    public function salesReceipt()
    {
        return $this->belongsTo(ServiceInvoice::class, 'service_invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
