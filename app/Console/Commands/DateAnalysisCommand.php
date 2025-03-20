<?php

namespace App\Console\Commands;

use App\DTO\VacancyDTO;
use App\Factories\AreaDTOFactory;
use App\Factories\EmployerDTOFactory;
use App\Factories\SalaryDTOFactory;
use App\Factories\VacancyDTOFactory;
use App\Http\Services\GetVacanciesService;
use App\Http\Services\SaveVacancies;
use App\Models\VacancyEmployer;
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
       return $this->getVacanciesService->getVacanciesFromHH('программист', 10);
    }

    private function saveVacancies(array $vacancies): void
    {
        $vacanciesToSave = [];
        $employerToSave = [];
        $salaryToSave = [];
        $areaToSave = [];

        $vacancyFactory = app()->make(VacancyDTOFactory::class);
        $employerFactory = app()->make(EmployerDTOFactory::class);
        $salaryFactory = app()->make(SalaryDTOFactory::class);
        $areaFactory = app()->make(AreaDTOFactory::class);

        $countVacanciesWithSalary = 0;

        foreach ($vacancies['items'] as $vacancy) {
            $vacancyDTO = $vacancyFactory->fromArray($vacancy);
            $vacancy['employer']['vacancy_id'] = $vacancyDTO->id;
            $vacancy['salary']['vacancy_id'] = $vacancyDTO->id;
            $vacancy['area']['vacancy_id'] = $vacancyDTO->id;

            $employerDTO = $employerFactory->fromArray($vacancy['employer']);
            $salaryDTO = $salaryFactory->fromArray($vacancy['salary']);
            $areaDTO = $areaFactory->fromArray($vacancy['area']);

            $vacanciesToSave[] = $vacancyDTO->toArray();
            $employerToSave[] = $employerDTO->toArray();
            $salaryToSave[] = $salaryDTO->toArray();
            $areaToSave[] = $areaDTO->toArray();
        }

        $this->saveVacancies->save($vacanciesToSave, $employerToSave, $salaryToSave, $areaToSave);
    }
}
