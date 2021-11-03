<?php

namespace App\Imports;

use App\Models\NewOrder;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class NewOrdersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            NewOrder::create([
                'date' => Date::excelToDateTimeObject($row['date']),
                'outlet_id' => $this->getOutletId($row['outlet_number']),
                'product_id' => $this->getProductId($row['product_number']),
                'quantity' => $row['quantity'],
                'price' => $row['price'],
            ]);
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
