<?php

namespace App\Services;

use App\Models\Congress;

class CongressService
{
    public function store(array $congress_data): Congress
    {
        return Congress::create($congress_data);
    }

    public function update(Congress $congress, array $congress_data): Congress
    {
        $congress->update($congress_data);
        $congress->refresh();
        return $congress;
    }
}
