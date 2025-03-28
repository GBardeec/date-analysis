<?php

namespace App\Http\Services\Vacancies\New;

use App\Factories\AreaDTOFactory;
use App\Factories\EmployerDTOFactory;
use App\Factories\SalaryDTOFactory;
use App\Factories\VacancyDTOFactory;
use App\Models\Vacancy;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ProcessingVacancies
{
    public function __construct(
        private readonly GetVacanciesService $getVacanciesService,
        private readonly SaveVacancies $saveVacancies,
    )
    {
        //
    }

    public function getNewVacancies(int $professionalRole, int $count): bool
    {
        Vacancy::query()->delete();
        $vacancies = $this->getVacanciesFromHHService($professionalRole, $count);
        return $this->saveVacancies($vacancies);
    }

    private function getVacanciesFromHHService(string $professionalRole, int $count): array
    {
        return $this->getVacanciesService->getVacanciesFromHH($professionalRole, $count);
    }

    private function saveVacancies(array $vacancies): bool
    {
        $vacanciesToSave = [];
        $employerToSave = [];
        $salaryToSave = [];
        $areaToSave = [];

        $vacancyFactory = app()->make(VacancyDTOFactory::class);
        $employerFactory = app()->make(EmployerDTOFactory::class);
        $salaryFactory = app()->make(SalaryDTOFactory::class);
        $areaFactory = app()->make(AreaDTOFactory::class);

        foreach ($vacancies as $vacancy) {
            if (empty($vacancy['employer']['id'])) {
                continue;
            }

            $vacancy['key_skills'] = $this->getKeySkills($vacancy['url']);
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

        return $this->saveVacancies->save($vacanciesToSave, $employerToSave, $salaryToSave, $areaToSave);
    }

    private function getKeySkills(string $url): array
    {
        $client = new Client();

        try {
            $response = $client->get($url);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['key_skills'] ?? [];
        } catch (GuzzleException $e) {
            Log::error('Ошибка при получении ключевых навыков: ' . $e->getMessage());
            return [];
        }
    }
}
