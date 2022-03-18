<?php

namespace App\Models;

use App\Models\Product;
use App\Models\invoiceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class section extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product()
    {
        return $this->hasMany(Product::class, 'section_id', 'id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'section_id', 'id');
    }
    public function invoice_detail()
    {
        return $this->hasManyThrough(invoiceDetail::class, Invoice::class, 'section_id', 'invoice_id');
    }
    public function attach()
    {
        return $this->hasManyThrough(Invoice_attachment::class, Invoice::class, 'section_id', 'invoice_id');
    }
}
