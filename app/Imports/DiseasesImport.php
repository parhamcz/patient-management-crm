<?php

namespace App\Imports;

use App\Models\Disease;
use App\Models\Patient;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class DiseasesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return patient
     * @throws \Exception
     */
    public function model(array $row): Patient
    {
        //According to excel file's format
        if ($row[0] != null) {
            return Disease::create([
                'name' => $row[0],
            ]);
        } else {
            //
        }
    }
}
