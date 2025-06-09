<?php

namespace App\Console\Commands;

use App\Models\Specializations;
use App\Services\Vacancy\New\ProcessingVacancies;
use Illuminate\Console\Command;

class GetNewVacancies extends Command
{
    protected $signature = 'app:get-new-vacancies';
    protected $description = 'Command description';

    public function handle()
    {
        $specializations = Specializations::query()->get();
        $activeSpecialization = $specializations->where('is_active', 1)->first();

        if ($activeSpecialization) {
            $index = $specializations->search(function ($item) use ($activeSpecialization) {
                return $item->id === $activeSpecialization->id;
            });

            $currentSpecializations = $specializations->get($index + 1);

            $activeSpecialization->is_active = false;
            $activeSpecialization->save();
        } else {
            $currentSpecializations = Specializations::query()->first();
        }

        $processingVacancies = app()->make(ProcessingVacancies::class);
        $processingVacancies->getNewVacancies($currentSpecializations->id, 300);

        $currentSpecializations->is_active = true;
        $currentSpecializations->save();

        echo 'done';
    }
}
