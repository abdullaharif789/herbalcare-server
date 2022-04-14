<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'variant_id',
        'customer',
        'store',
    ];
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

}
