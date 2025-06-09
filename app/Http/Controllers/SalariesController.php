<?php

namespace App\Http\Controllers;

use App\Services\GenerateReport\SalaryAndSkillService;
use App\Services\Salaries\IndexService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalariesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $service = app()->make(IndexService::class);

		return response()->json($service->get($request));
    }

    public function getSalaryBySkills(Request $request)
    {
        $service = app()->make(SalaryAndSkillService::class);

        return response()->json($service->generate($request));
    }
}
