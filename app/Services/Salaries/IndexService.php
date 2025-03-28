<?php

namespace App\Services\Salaries;

use App\Models\VacancySalary;

class IndexService
{
    private const SALARY_CATEGORIES = [
        'до 50k' => 50000,
        '50k-100k' => 100000,
        '100k-150k' => 150000,
        '150k-200k' => 200000,
        '200k-300k' => 300000,
        '300k-500k' => 500000,
        '500k+' => PHP_INT_MAX
    ];

    public function get(): array
    {
        $statisticSalary = [
            'from' => ['data' => [], 'average' => 0],
            'to' => ['data' => [], 'average' => 0],
            'average' => ['data' => [], 'average' => 0]
        ];

        VacancySalary::query()
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
                $data['data'] = array_fill_keys(array_keys(self::SALARY_CATEGORIES), 0);
                continue;
            }

            $averageValue = array_sum($data['data']) / count($data['data']);
            $data['average'] = number_format($averageValue, 2, '.', '');

            $categoryCounts = array_fill_keys(array_keys(self::SALARY_CATEGORIES), 0);

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
        foreach (self::SALARY_CATEGORIES as $category => $maxValue) {
            if ($salary <= $maxValue) {
                return $category;
            }
        }

        return null;
    }
}
