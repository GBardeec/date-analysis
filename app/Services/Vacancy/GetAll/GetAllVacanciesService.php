<?php

namespace App\Services\Vacancy\GetAll;

use App\Models\Vacancy;
use App\Services\SpecializationService;
use Illuminate\Database\Eloquent\Collection;

class GetAllVacanciesService
{
    public function get($request): Collection
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        return Vacancy::query()
            ->where('specialization_id', $activeSpecializationId)
            ->get();
    }
}
