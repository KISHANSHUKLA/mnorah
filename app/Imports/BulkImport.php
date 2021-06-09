<?php

namespace App\Imports;
use Illuminate\Support\Facades\Auth;
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
        dd($row);
        return new Invitecode([
            'invitecode'     => $row['0'],
            'church_id'     => $row['1'],
            'global'     => $row['2'],
            'user_id' => Auth::user()->id,
        ]);
       
    }
}
