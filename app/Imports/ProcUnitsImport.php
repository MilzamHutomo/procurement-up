<?php

namespace App\Imports;

use App\Models\ProcUnit;
use Maatwebsite\Excel\Concerns\ToModel;

class ProcUnitsImport implements ToModel
{
    private $procurement;

    public function __construct(int $procurement) 
    {
        $this->procurement = $procurement;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (gettype($row[2]) != 'integer'){
            return NULL;
        }
        return new ProcUnit([
            'procurement' => $this->procurement,
            'name' => $row[0],
            'specs' => $row[1],
            'price' => $row[2],
            'qty' => $row[3]
        ]);
    }
}
