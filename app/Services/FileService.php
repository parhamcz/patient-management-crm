<?php

namespace App\Services;


use App\Models\File;

class FileService
{
    protected File|null $file;

    public function __construct()
    {
    }

    public function store(array $file_data): File
    {
        $this->file = File::create($file_data);
        $this->syncCongresses($file_data['congresses'])
            ->syncDoctors($file_data['doctors'])
            ->syncDiseases($file_data['diseases'])
            ->syncHospitals($file_data['hospitals']);
        return $this->file;
    }

    public function syncHospitals(array $hospital_ids): static
    {
        $this->file->hospitals()->sync($hospital_ids);
        $this->file->refresh();
        return $this;
    }

    public function syncDoctors(array $doctor_ids): static
    {
        $this->file->users()->sync($doctor_ids);
        $this->file->refresh();
        return $this;
    }

    public function syncCongresses(array $congress_ids): static
    {
        $this->file->congresses()->sync($congress_ids);
        $this->file->refresh();
        return $this;
    }

    public function syncDiseases(array $disease_ids): static
    {
        $this->file->diseases()->sync($disease_ids);
        $this->file->refresh();
        return $this;
    }

    public function update(File $file, array $file_data): File
    {
        $this->file = $file;
        $this->file->update($file_data);
        $this->syncCongresses($file_data['congresses'])
            ->syncDoctors($file_data['doctors'])
            ->syncDiseases($file_data['diseases'])
            ->syncHospitals($file_data['hospitals']);
        $this->file->refresh();
        return $this->file;
    }
}
