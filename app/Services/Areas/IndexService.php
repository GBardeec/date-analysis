<?php

namespace App\Services\Areas;

use App\Models\VacancyArea;
use Illuminate\Support\Collection;

class IndexService
{
    public function get(): Collection
    {
        return VacancyArea::all()
            ->pluck('name')
            ->countBy()
            ->sortDesc()
            ->take(30);
    }
}
