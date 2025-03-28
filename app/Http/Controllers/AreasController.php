<?php

namespace App\Http\Controllers;

use App\Services\Areas\IndexService;
use Illuminate\Http\JsonResponse;

class AreasController extends Controller
{
    public function index(): JsonResponse
    {
		$IndexService = app()->make(IndexService::class);

		return response()->json($IndexService->get());
    }
}
