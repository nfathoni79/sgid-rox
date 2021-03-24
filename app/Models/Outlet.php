<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\ProductOrder;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'owner',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }
}
