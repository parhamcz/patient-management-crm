<?php

namespace App\Services;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function __construct()
    {

    }

    /**
     * Executes a search on patients and their files.
     * @param array $search_data
     * @return Builder[]|Collection
     */
    public function search(array $search_data)
    {
        $query = Patient::query()->with('files');
        if (isset($search_data['patient']['age'])) {
            $start_age = Carbon::now()->endOfYear()->subYears($search_data['patient']['age']['start'])->format('Y-m-d');
            $end_age = Carbon::now()->startOfYear()->subYears($search_data['patient']['age']['end'])->format('Y-m-d');
            $query->whereDate('birthdate', '>=', $end_age)
                ->whereDate('birthdate', '<=', $start_age);
        }
        if (isset($search_data['patient']['first_visit_at'])) {
            $query->whereDate('first_visit_at', '>=', $search_data['patient']['first_visit_at']['start'])
                ->whereDate('first_visit_at', '<=', $search_data['patient']['first_visit_at']['end']);
        }
        if (isset($search_data['patient']['gender'])) {
            $query->where('gender', $search_data['patient']['gender']);
        }
        if (isset($search_data['patient']['occupation'])) {
            $query->where('occupation', $search_data['patient']['occupation']);
        }
        if (isset($search_data['patient']['children_count'])) {
            $query->where('children_count', $search_data['patient']['children_count']);
        }
        if (isset($search_data['patient']['marital_status'])) {
            $query->where('marital_status', $search_data['patient']['marital_status']);
        }
        if (isset($search_data['patient']['education_degree'])) {
            $query->where('education_degree', $search_data['patient']['education_degree']);
        }
        if (isset($search_data['patient']['entry'])) {
            $query->where(function ($query) use ($search_data) {
                $query->where('name', 'LIKE', '%' . $search_data['patient']['entry'] . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $search_data['patient']['entry'] . '%')
                    ->orWhere('national_id', 'LIKE', '%' . $search_data['patient']['entry'] . '%');
            });
        }
        if (isset($search_data['file'])) {
            $query->whereHas('files', function (Builder $q1) use ($search_data) {
                if (isset($search_data['file']['special_case'])) {
                    $q1->where('special_case', $search_data['file']['special_case']);
                }
                if (isset($search_data['file']['case_number'])) {
                    $q1->where('case_number', 'LIKE', '%' . $search_data['file']['case_number'] . '%');
                }
                if (isset($search_data['file']['patient_accompany'])) {
                    $q1->where('patient_accompany', 'LIKE', '%' . $search_data['file']['patient_accompany'] . '%');
                }
                if (isset($search_data['file']['diseases'])) {
                    $q1->whereHas('diseases', function (Builder $q2) use ($search_data) {
                        $q2->whereIn('diseases.id', $search_data['file']['diseases']);
                    });
                }
                if (isset($search_data['file']['hospitals'])) {
                    $q1->whereHas('hospitals', function (Builder $q3) use ($search_data) {
                        $q3->whereIn('hospitals.id', $search_data['file']['hospitals']);
                    });
                }
                if (isset($search_data['file']['congresses'])) {
                    $q1->whereHas('congresses', function (Builder $q4) use ($search_data) {
                        $q4->whereIn('congresses.id', $search_data['file']['congresses']);
                    });
                }
            });
        }
        return $query
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
