<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
        'district',
        'street',
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
