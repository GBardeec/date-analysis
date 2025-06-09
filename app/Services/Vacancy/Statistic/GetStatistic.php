<?php

namespace App\Services\Vacancy\Statistic;

use App\Models\Vacancy;
use App\Services\SpecializationService;
use Illuminate\Http\Request;

class GetStatistic
{
    public function get(Request $request): array
    {
        $specializationService = app()->make(SpecializationService::class);
        $activeSpecializationId = $specializationService->getActiveSpecializationId($request);

        $stats = Vacancy::query()
            ->where('specialization_id', $activeSpecializationId)
            ->selectRaw('
                COUNT(name) as total_count,
                COUNT(DISTINCT name) as unique_names,
                SUM(premium = 1) as premium_count,
                SUM(has_test = 1) as test_count,
                SUM(response_letter_required = 1) as letter_required_count
            ')->first();

        return [
            'total_count' => $stats->total_count,
            'unique_names' => $stats->unique_names,
            'premium_count' => $stats->premium_count,
            'test_count' => $stats->test_count,
            'letter_required_count' => $stats->letter_required_count
        ];
    }
}
