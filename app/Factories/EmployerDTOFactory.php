<?php

namespace App\Factories;

use App\DTO\EmployerDTO;

class EmployerDTOFactory extends BaseDTOFactory
{
    public static function fromArray(array $employer): EmployerDTO
    {
        return new EmployerDTO(
            id: $employer['id'],
            vacancy_id: $employer['vacancy_id'],
            name: $employer['name'],
            url: $employer['url'],
            accredited_it_employer: $employer['trusted'],
            trusted: $employer['trusted'],
        );
    }
}
