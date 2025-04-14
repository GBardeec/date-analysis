<?php

namespace App\Http\Controllers;

use App\Services\Areas\IndexService;
use App\Services\GenerateReport\AreaAndSalaryService;
use App\Services\GenerateReport\AreaAndSkillService;
use Illuminate\Http\JsonResponse;

class AreasController extends Controller
{
    public function index(): JsonResponse
    {
		$IndexService = app()->make(IndexService::class);

		return response()->json($IndexService->get());
    }

    public function getSkillByAreas(): JsonResponse
    {
        $service = app()->make(AreaAndSkillService::class);

        return response()->json($service->generate());
    }

    public function getSalaryByAreas(): JsonResponse
    {
        $service = app()->make(AreaAndSalaryService::class);

        return response()->json($service->generate());
    }
}
