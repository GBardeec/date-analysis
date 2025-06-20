<?php

namespace App\Services\Vacancy\New;

use App\Models\Vacancy;
use App\Models\VacancyArea;
use App\Models\VacancyEmployer;
use App\Models\VacancySalary;
use Illuminate\Support\Facades\DB;

class SaveVacancies
{
    public function save(array $vacancies, array $employers, array $salaries, array $areas): bool
    {
        DB::transaction(function () use ($vacancies, $employers, $salaries, $areas) {
            try {
                DB::beginTransaction();

                $vacancies = Vacancy::query()->insert($vacancies);
                $employers = VacancyEmployer::query()->insert($employers);
                $salary = VacancySalary::query()->insert($salaries);
                $areas = VacancyArea::query()->insert($areas);

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                return false;
            }
        });

        return true;
    }
}
