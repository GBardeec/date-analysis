<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewVacanciesRequest;
use App\Http\Services\Vacancies\GetAll\GetAllVacanciesService;
use App\Http\Services\Vacancies\New\ProcessingVacancies;

class VacanciesController extends Controller
{
    public function getNewVacancies(NewVacanciesRequest $request): bool
    {
       $processingVacancies = app()->make(ProcessingVacancies::class);

	   return $processingVacancies->getNewVacancies($request->professional_role, $request->count);
    }

    public function getAllVacancies()
    {
		$getAllService = app()->make(GetAllVacanciesService::class);
		return response()->json($getAllService->get());
    }
}
