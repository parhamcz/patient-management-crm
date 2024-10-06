<?php

namespace App\Services;

use App\Models\Hospital;

class HospitalService
{
    public function store(array $hospital_data): Hospital
    {
        return Hospital::create($hospital_data);
    }

    public function update(Hospital $hospital, array $hospital_data): Hospital
    {
        $hospital->update($hospital_data);
        $hospital->refresh();
        return $hospital;
    }
}
