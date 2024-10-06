<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\FileResource;
use App\Http\Resources\PatientResource;
use App\Services\SearchService;
use App\Traits\HasResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use HasResponse;

    protected SearchService $searchService;

    public function __construct()
    {
        $this->searchService = new SearchService();
    }

    public function search(SearchRequest $request)
    {
        $search_data = $request->all();
//        $end_age = Carbon::now()->startOfYear()->subYears($search_data['patient']['age']['end'])->format('Y-m-d');
        return PatientResource::collection($this->searchService->search($request->all()));
    }
}
