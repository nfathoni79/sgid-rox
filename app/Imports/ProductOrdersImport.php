<?php

namespace App\Imports;

use App\Models\Outlet;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductOrdersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $outlet_id = $this->getOutletId($row['outlet_number']);
            $product_id = $this->getProductId($row['product_number']);
            $quantity = $row['quantity'];

            $outlet = Outlet::find($outlet_id);
            $products = $outlet->products();
            $products->syncWithoutDetaching([$product_id]);
            $products->find($product_id)->pivot->increment('quantity', $quantity);
        }
    }

    private function getOutletId($number)
    {
        return Outlet::where('number', $number)->first()->id;
    }

    private function getProductId($number)
    {
        return Product::where('number', $number)->first()->id;
    }
}
