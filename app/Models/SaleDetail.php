<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class SaleDetail extends Model
{
    use HasFactory;
    public function sail() {
        return $this->belongsTo(Sale::class);
    }
}
