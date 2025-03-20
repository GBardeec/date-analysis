<?php

namespace App\Factories;

use App\DTO\AreaDTO;

class AreaDTOFactory extends BaseDTOFactory
{
    public static function fromArray(array $area): AreaDTO
    {
        return new AreaDTO(
            id: $area['id'],
            vacancy_id: $area['vacancy_id'],
            name: $area['name'],
            url: $area['url'],
        );
    }
}
