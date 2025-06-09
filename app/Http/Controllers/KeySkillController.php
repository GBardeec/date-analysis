<?php

namespace App\Http\Controllers;

use App\Services\KeySkill\IndexService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeySkillController extends Controller
{
    public function index(Request $request): JsonResponse
    {
		$IndexService = app()->make(IndexService::class);

		return response()->json($IndexService->get($request));
    }
}
