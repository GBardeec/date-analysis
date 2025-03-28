<?php

namespace App\Services\KeySkill;

use App\Models\Vacancy;
use App\Models\VacancyArea;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class IndexService
{
    public function get(): Collection
    {
        return Vacancy::query()
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
