<?php

namespace App\Http\Services;

use App\DTO\VacancyDTO;
use App\Models\Vacancy;

class SaveVacancies
{
    public function save(array $vacancies)
    {
        return Vacancy::query()->insert($vacancies);
    }
}
