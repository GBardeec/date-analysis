<?php

namespace App\Console\Commands;

use App\Models\Specializations;
use App\Models\Vacancy;
use App\Services\Vacancy\New\ProcessingVacancies;
use Illuminate\Console\Command;

class GetNewVacancies extends Command
{
    protected $signature = 'app:get-new-vacancies';
    protected $description = 'Command description';

    public function handle()
    {
        Vacancy::query()->delete();

        $specializations = Specializations::all();

        foreach ($specializations as $specialization) {
            $processingVacancies = app()->make(ProcessingVacancies::class);
            $processingVacancies->getNewVacancies($specialization->id, 300);
        }

        echo 'done';
    }
}
