<?php

namespace App\Http\Controllers;

use App\Services\Salaries\IndexService;
use Illuminate\Http\JsonResponse;

class SalariesController extends Controller
{
    public function index(): JsonResponse
    {
		$IndexService = app()->make(IndexService::class);

		return response()->json($IndexService->get());
    }
}
