<?php

namespace App\Models;

use App\Models\invoiceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function section()
    {
        return $this->BelongsTo(section::class, 'section_id', 'id');
    }
    public function invoice_detail()
    {
        return $this->hasOne(invoiceDetail::class, 'invoice_id', 'id');
    }
    public function Attach()
    {
        return $this->hasOne(Invoice_attachment::class, 'invoice_id', 'id');
    }
}
