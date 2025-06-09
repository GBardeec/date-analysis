<?php

namespace App\Services\Areas;

use App\Models\Vacancy;
use App\Models\VacancyArea;
use App\Services\SpecializationService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IndexService
{
    public function get(Request $request): Collection
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        return Vacancy::query()
            ->where('specialization_id', $activeSpecializationId)
            ->with('areas')
            ->get()
            ->flatMap(function ($vacancy) {
                return $vacancy->areas->pluck('name');
            })
            ->countBy()
            ->sortDesc()
            ->take(30);
    }
}
