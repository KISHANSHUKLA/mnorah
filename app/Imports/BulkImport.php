<?php

namespace App\Imports;

use App\models\Invitecode;
use Maatwebsite\Excel\Concerns\ToModel;

class BulkImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Invitecode([
            'invitecode'     => $row['0'],
        ]);
       
    }
}
