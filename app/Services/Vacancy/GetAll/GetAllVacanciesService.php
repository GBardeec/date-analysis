<?php

namespace App\Services\Vacancies\GetAll;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;

class GetAllVacanciesService
{
    public function get(): Collection
    {
        return Vacancy::all();
    }
}
