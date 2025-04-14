<?php

namespace App\Services\Vacancy\GetAll;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;

class GetAllVacanciesService
{
    public function get(): Collection
    {
        return Vacancy::all();
    }
}
