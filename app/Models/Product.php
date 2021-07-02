<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outlet;
use App\Models\ProductOrder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
    ];

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function outlets()
    {
        return $this->belongsToMany(Outlet::class, 'product_orders')
            ->withPivot('quantity')->withTimestamps();
    }
}
