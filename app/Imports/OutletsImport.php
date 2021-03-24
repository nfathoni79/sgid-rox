<?php

namespace App\Imports;

use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\ToModel;

class OutletsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Outlet([
            //
            'number' => $row[0],
            'name' => $row[1],
            'owner' => $row[2],
        ]);
    }
}
