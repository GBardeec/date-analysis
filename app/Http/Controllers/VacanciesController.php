<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewVacanciesRequest;
use App\Services\Vacancy\GetAll\GetAllVacanciesService;
use App\Services\Vacancy\New\ProcessingVacancies;
use App\Services\Vacancy\Statistic\GetStatistic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{
    public function getNewVacancies(NewVacanciesRequest $request): bool
    {
       $processingVacancies = app()->make(ProcessingVacancies::class);

	   return $processingVacancies->getNewVacancies($request->professional_role, $request->count);
    }

    public function getAllVacancies(): JsonResponse
    {
		$getAllService = app()->make(GetAllVacanciesService::class);

		return response()->json($getAllService->get());
    }

    public function getStatistic(Request $request): JsonResponse
    {
        $getStatistic = app()->make(GetStatistic::class);

        return response()->json($getStatistic->get($request));
    }
}
