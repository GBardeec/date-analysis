<?php

namespace App\Factories;

use App\DTO\VacancyDTO;

class VacancyDTOFactory extends BaseDTOFactory
{
    public static function fromArray(array $vacancy): VacancyDTO
    {
        return new VacancyDTO(
            id: $vacancy['id'],
            name: $vacancy['name'],
            url: $vacancy['url'],
            premium: $vacancy['premium'],
            has_test: $vacancy['has_test'],
            response_letter_required: $vacancy['response_letter_required'],
            snippet: $vacancy['snippet'],
            key_skills: $vacancy['key_skills'],
            published_at: $vacancy['published_at'],
            created_at: $vacancy['created_at'],
        );
    }
}
