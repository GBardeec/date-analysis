<?php

namespace App\Http\Controllers;

use App\Services\Areas\IndexService;
use App\Services\GenerateReport\AreaAndSalaryService;
use App\Services\GenerateReport\AreaAndSkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function index(Request $request): JsonResponse
    {
		$IndexService = app()->make(IndexService::class);

		return response()->json($IndexService->get($request));
    }

    public function getSkillByAreas(Request $request): JsonResponse
    {
        $service = app()->make(AreaAndSkillService::class);

        return response()->json($service->generate($request));
    }

    public function getSalaryByAreas(Request $request): JsonResponse
    {
        $service = app()->make(AreaAndSalaryService::class);

        return response()->json($service->generate($request));
    }
}
