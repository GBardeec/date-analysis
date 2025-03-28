<?php

namespace App\Services\Vacancies\New;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GetVacanciesService
{
    private const MAX_PER_PAGE = 100;
    private const MAX_REQUESTS = 20;
    private const DELAY_MS = 500000;

    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function getVacanciesFromHH(int $professionalRole, int $count): array
    {
        $allItems = [];
        $remaining = $count;
        $page = 0;

        while ($remaining > 0 && $page < self::MAX_REQUESTS) {
            $perPage = min($remaining, self::MAX_PER_PAGE);

            $response = $this->client->get('https://api.hh.ru/vacancies', [
                'query' => [
                    'professional_role' => $professionalRole,
                    'currency' => 'RUR',
                    'per_page' => $perPage,
                    'page' => $page,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data['items'])) {
                break;
            }

            $allItems = array_merge($allItems, $data['items']);
            $remaining = $count - count($allItems);
            $page++;

            if ($remaining <= 0) {
                break;
            }

            usleep(self::DELAY_MS);
        }

        return array_slice($allItems, 0, $count);
    }
}
