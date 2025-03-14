<?php

namespace App\Console\Commands;

use App\DTO\VacancyDTO;
use App\Factories\VacancyDTOFactory;
use App\Http\Services\GetUserFromHHService;
use App\Http\Services\GetVacanciesService;
use App\Http\Services\SaveVacancies;
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
        $vacancyFactory = app()->make(VacancyDTOFactory::class);

        foreach ($vacancies['items'] as $vacancy) {
            $vacancyDTO = $vacancyFactory->fromArray($vacancy);
            $vacanciesToSave[] = $vacancyDTO->toArray();
        }

        $this->saveVacancies->save($vacanciesToSave);
    }
}
