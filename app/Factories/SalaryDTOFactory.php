<?php

namespace App\Factories;

use App\DTO\SalaryDTO;

class SalaryDTOFactory extends BaseDTOFactory
{
    public static function fromArray(array $salary): SalaryDTO
    {
        return new SalaryDTO(
            vacancy_id: $salary['vacancy_id'],
            from: $salary['from'] ?? null,
            to: $salary['to'] ?? null,
            currency: $salary['currency'] ?? null,
            gross: $salary['gross'] ?? null,
        );
    }
}
