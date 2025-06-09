<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSpecializationRequest;
use App\Services\SpecializationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function __construct(
        private SpecializationService $service
    ) {}

    public function save(SaveSpecializationRequest $request): JsonResponse
    {
        $specializationId = $request->specialization_id;
        $specialization = $this->service->saveActiveSpecialization($specializationId);

        return response()->json(
            $specialization
        )->withCookie($specialization);
    }

    public function getActive(Request $request): JsonResponse
    {
        $specializationId = $this->service->getActiveSpecialization($request);

        return response()->json($specializationId);
    }
}
