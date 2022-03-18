<?php

namespace App\Models;

use App\Models\section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public function section()
    {
        return $this->belongsTo(section::class, 'section_id', 'id');
    }
}
