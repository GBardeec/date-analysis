<?php

namespace App\Services\KeySkill;

use App\Models\Vacancy;
use App\Models\VacancyArea;
use App\Services\SpecializationService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class IndexService
{
    public function get(Request $request): Collection
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        return Vacancy::query()
            ->where('specialization_id', $activeSpecializationId)
            ->pluck('key_skills')
            ->flatMap(function ($skills) {
                return is_array($skills) ? Arr::flatten($skills) : [];
            })
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(30);
    }
}
