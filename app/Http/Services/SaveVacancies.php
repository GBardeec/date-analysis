<?php

namespace App\Http\Services;

use App\DTO\VacancyDTO;
use App\Models\Employer;
use App\Models\Vacancy;

class SaveVacancies
{
    public function save(array $vacancies, array $employers)
    {
        $vacancies = Vacancy::query()->insert($vacancies);
        $employers = Employer::query()->insert($employers);
    }
}
