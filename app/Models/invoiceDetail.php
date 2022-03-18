<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
