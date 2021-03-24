<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outlet;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'date',
        'total',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
