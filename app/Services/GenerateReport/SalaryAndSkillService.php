<?php

namespace App\Services\GenerateReport;

use App\Models\VacancySalary;
use Illuminate\Support\Facades\DB;

class SalaryAndSkillService implements GenerateInterface
{
    public function generate(): array
    {
        $vacancies = DB::table('vacancies')
            ->join('vacancy_salary', 'vacancies.id', '=', 'vacancy_salary.vacancy_id')
            ->select(
                'vacancies.key_skills',
                'vacancy_salary.from',
                'vacancy_salary.to'
            )
            ->where('vacancy_salary.currency', 'RUR')
            ->whereNotNull('vacancies.key_skills')
            ->get();

        $result = array_fill_keys(array_keys(VacancySalary::SALARY_CATEGORIES), [
            'top_skills' => [],
            'vacancy_count' => 0
        ]);

        foreach ($vacancies as $vacancy) {
            $avgSalary = $this->calculateAverageSalary($vacancy->from, $vacancy->to);
            if ($avgSalary === null) {
                continue;
            }

            $category = $this->determineSalaryCategory($avgSalary);
            if ($category === null) {
                continue;
            }

            $skills = json_decode($vacancy->key_skills, true) ?? [];
            $skillNames = array_column($skills, 'name');

            $result[$category]['vacancy_count']++;

            foreach ($skillNames as $skill) {
                if (!isset($result[$category]['skills'][$skill])) {
                    $result[$category]['skills'][$skill] = 0;
                }
                $result[$category]['skills'][$skill]++;
            }
        }

        foreach ($result as &$data) {
            if (empty($data['skills'])) {
                $data['top_skills'] = [];
                continue;
            }

            arsort($data['skills']);
            $topSkills = array_slice($data['skills'], 0, 5, true);
            $data['top_skills'] = array_map(function ($count, $skill) {
                return ['skill' => $skill, 'count' => $count];
            }, $topSkills, array_keys($topSkills));

            unset($data['skills']);
        }

        return $result;
    }

    private function calculateAverageSalary(?float $from, ?float $to): ?float
    {
        if ($from === null && $to === null) {
            return null;
        }

        if ($from === null) {
            return $to;
        }

        if ($to === null) {
            return $from;
        }

        return ($from + $to) / 2;
    }

    private function determineSalaryCategory(float $salary): ?string
    {
        foreach (VacancySalary::SALARY_CATEGORIES as $category => $maxValue) {
            if ($salary <= $maxValue) {
                return $category;
            }
        }

        return null;
    }
}
