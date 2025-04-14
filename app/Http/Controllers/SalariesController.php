<?php

namespace App\Http\Controllers;

use App\Services\GenerateReport\SalaryAndSkillService;
use App\Services\Salaries\IndexService;
use Illuminate\Http\JsonResponse;

class SalariesController extends Controller
{
    public function index(): JsonResponse
    {
        $service = app()->make(IndexService::class);

		return response()->json($service->get());
    }

    public function getSalaryBySkills()
    {
        $service = app()->make(SalaryAndSkillService::class);

        return response()->json($service->generate());
    }
}
