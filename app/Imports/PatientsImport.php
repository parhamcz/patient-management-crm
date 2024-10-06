<?php

namespace App\Imports;

use App\Models\Patient;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class PatientsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return patient
     * @throws \Exception
     */
    public function model(array $row): void
    {
        //According to excel file's format
        if (($row[0] != null || $row[0] != '') && ($row[1] != null || $row[1] != '')) {
            $patient = Patient::create([
                'name' => $row[0] . ' ' . $row[1],
                'first_visit_at' => !$row[2] ? null : Verta::parse($row[2])->toCarbon()->format('Y-m-d'),
                'phone_number' => !$row[3] || $row[3] == '-' ? null : $row[3],
            ]);
            $patient->files()->create([]);
        } else {
            //
        }
    }
}
