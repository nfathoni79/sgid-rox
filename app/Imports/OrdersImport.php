<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Order([
            //
            'outlet_id' => $this->getOutletId($row['outlet_number']),
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date']),
            'total' => $row['total'],
        ]);
    }

    private function getOutletId($number)
    {
        return Outlet::where('number', $number)->first()->id;
    }
}
