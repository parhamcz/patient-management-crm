<?php

namespace App\Services;

use App\Models\Disease;

class DiseaseService
{
    public function store(array $disease_data): Disease
    {
        return Disease::create($disease_data);
    }

    public function update(Disease $disease, array $disease_data): Disease
    {
        $disease->update($disease_data);
        $disease->refresh();
        return $disease;
    }
}
