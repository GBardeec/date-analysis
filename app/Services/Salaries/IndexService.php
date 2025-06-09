<?php

namespace App\Services\Salaries;

use App\Models\VacancySalary;
use App\Services\SpecializationService;
use Illuminate\Http\Request;

class IndexService
{
    public function get(Request $request): array
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        $statisticSalary = [
            'from' => ['data' => [], 'average' => 0],
            'to' => ['data' => [], 'average' => 0],
            'average' => ['data' => [], 'average' => 0]
        ];

        VacancySalary::query()
            ->whereHas('vacancy', function($query) use ($activeSpecializationId) {
                $query->where('specialization_id', $activeSpecializationId);
            })
            ->where('currency', 'RUR')
            ->select(['from', 'to'])
            ->cursor()
            ->each(function ($salary) use (&$statisticSalary) {
                if ($salary->from !== null) {
                    $statisticSalary['from']['data'][] = $salary->from;
                }

                if ($salary->to !== null) {
                    $statisticSalary['to']['data'][] = $salary->to;
                }

                if ($salary->from !== null && $salary->to !== null) {
                    $statisticSalary['average']['data'][] = ($salary->from + $salary->to) / 2;
                }
            });

        foreach ($statisticSalary as &$data) {
            if (empty($data['data'])) {
                $data['average'] = 0;
                $data['data'] = array_fill_keys(array_keys(VacancySalary::SALARY_CATEGORIES), 0);
                continue;
            }

            $averageValue = array_sum($data['data']) / count($data['data']);
            $data['average'] = number_format($averageValue, 2, '.', '');

            $categoryCounts = array_fill_keys(array_keys(VacancySalary::SALARY_CATEGORIES), 0);

            foreach ($data['data'] as $value) {
                $category = $this->determineCategory($value);
                if ($category !== null) {
                    $categoryCounts[$category]++;
                }
            }

            $data['data'] = $categoryCounts;
        }

        return $statisticSalary;
    }

    private function determineCategory(float $salary): ?string
    {
        foreach (VacancySalary::SALARY_CATEGORIES as $category => $maxValue) {
            if ($salary <= $maxValue) {
                return $category;
            }
        }

        return null;
    }
}
