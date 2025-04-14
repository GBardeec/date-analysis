<?php

namespace App\Services\GenerateReport;

use Illuminate\Support\Facades\DB;

class AreaAndSalaryService implements GenerateInterface
{
    public function generate(): array
    {
        return DB::table('vacancy_area')
            ->select(
                'vacancy_area.name',
                DB::raw('AVG(vacancy_salary.from) as average_salary')
            )
            ->join('vacancy_salary', function ($join) {
                $join->on('vacancy_area.vacancy_id', '=', 'vacancy_salary.vacancy_id')
                    ->where('vacancy_salary.currency', '=', 'RUR')
                    ->whereNotNull('vacancy_salary.from');
            })
            ->groupBy('vacancy_area.name')
            ->having('average_salary', '>', 0)
            ->orderByDesc('average_salary')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->name => (int) $item->average_salary];
            })
            ->toArray();
    }
}
