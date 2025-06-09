<?php

namespace App\Services\GenerateReport;

use App\Services\SpecializationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaAndSkillService implements GenerateInterface
{
    public function generate(Request $request): array
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        $vacancies = DB::table('vacancies')
            ->where('specialization_id', $activeSpecializationId)
            ->join('vacancy_area', 'vacancies.id', '=', 'vacancy_area.vacancy_id')
            ->select(
                'vacancy_area.name as city',
                'vacancies.key_skills'
            )
            ->whereNotNull('vacancies.key_skills')
            ->get();

        $result = collect();

        foreach ($vacancies as $vacancy) {
            $skills = json_decode($vacancy->key_skills, true) ?? [];

            foreach ($skills as $skill) {
                if (!isset($skill['name'])) {
                    continue;
                }

                $result->push([
                    'city' => $vacancy->city,
                    'skill' => $skill['name']
                ]);
            }
        }

        return $result
            ->groupBy('city')
            ->map(function ($citySkills) {
                return $citySkills
                    ->countBy('skill')
                    ->sortDesc()
                    ->take(3)
                    ->map(function ($count, $skill) {
                        return ['skill' => $skill, 'count' => $count];
                    })
                    ->values();
            })
            ->toArray();
    }
}
