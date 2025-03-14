<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class GetVacanciesService
{
    public function __construct(private readonly Client $client)
    {
        //
    }
    public function getVacanciesFromHH(string $vacancyName, int $countGet): mixed
    {
        $response = $this->client->get(
            'https://api.hh.ru/vacancies',
            [
                'query' => [
                    'text' => $vacancyName,
                    'per_page' => $countGet,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
