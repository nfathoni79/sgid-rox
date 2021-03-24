<?php

namespace App\Imports;

use App\Models\ProductOrder;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductOrdersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductOrder([
            //
            'outlet_id' => $row[0],
            'product_id' => $row[1],
            'quantity' => $row[2],
        ]);
    }
}
