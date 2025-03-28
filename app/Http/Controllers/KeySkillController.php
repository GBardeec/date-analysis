<?php

namespace App\Http\Controllers;

use App\Services\KeySkill\IndexService;
use Illuminate\Http\JsonResponse;

class KeySkillController extends Controller
{
    public function index(): JsonResponse
    {
		$IndexService = app()->make(IndexService::class);

		return response()->json($IndexService->get());
    }
}
