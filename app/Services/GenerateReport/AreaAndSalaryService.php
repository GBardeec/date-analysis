<?php

namespace App\Services\GenerateReport;

use App\Models\Vacancy;
use App\Services\SpecializationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaAndSalaryService implements GenerateInterface
{
    public function generate(Request $request): array
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        return Vacancy::query()
            ->where('specialization_id', $activeSpecializationId)
            ->whereHas('salaries', function($query) {
                $query->where('currency', 'RUR')
                    ->whereNotNull('to');
            })
            ->with(['areas', 'salaries' => function($query) {
                $query->where('currency', 'RUR')
                    ->whereNotNull('to');
            }])
            ->get()
            ->flatMap(function ($vacancy) {
                return $vacancy->areas->map(function ($area) use ($vacancy) {
                    $salary = $vacancy->salaries->first();
                    return $salary ? [
                        'name' => $area->name,
                        'salary' => $salary->to
                    ] : null;
                })->filter();
            })
            ->groupBy('name')
            ->map(function ($items) {
                return (int) $items->avg('salary');
            })
            ->filter(function ($avgSalary) {
                return $avgSalary > 0;
            })
            ->sortDesc()
            ->take(30)
            ->toArray();
    }
}
