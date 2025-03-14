<?php

namespace App\Console\Commands;

use App\DTO\VacancyDTO;
use App\Factories\EmployerDTOFactory;
use App\Factories\VacancyDTOFactory;
use App\Http\Services\GetUserFromHHService;
use App\Http\Services\GetVacanciesService;
use App\Http\Services\SaveVacancies;
use App\Models\Employer;
use App\Models\Vacancy;
use Illuminate\Console\Command;

class DateAnalysisCommand extends Command
{
    protected $signature = 'date';

    protected $description = 'Command description';

    public function __construct(
        private readonly GetVacanciesService $getVacanciesService,
        private readonly SaveVacancies $saveVacancies,
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        Vacancy::query()->delete();
        $vacancies = $this->getVacanciesFromHHService();
        $this->saveVacancies($vacancies);
    }

    private function getVacanciesFromHHService()
    {
       return $this->getVacanciesService->getVacanciesFromHH('аналитик', 10);
    }

    private function saveVacancies(array $vacancies): void
    {
        $vacanciesToSave = [];
        $employerToSave = [];

        $vacancyFactory = app()->make(VacancyDTOFactory::class);
        $employerFactory = app()->make(EmployerDTOFactory::class);

        foreach ($vacancies['items'] as $vacancy) {
            $vacancyDTO = $vacancyFactory->fromArray($vacancy);
            $vacancy['employer']['vacancy_id'] = $vacancyDTO->id;
            $employerDTO = $employerFactory->fromArray($vacancy['employer']);

            $vacanciesToSave[] = $vacancyDTO->toArray();
            $employerToSave[] = $employerDTO->toArray();
        }

        $this->saveVacancies->save($vacanciesToSave, $employerToSave);
    }
}
