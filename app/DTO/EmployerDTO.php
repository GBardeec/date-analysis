<?php

namespace App\DTO;

use Carbon\Carbon;

class EmployerDTO
{
    public function __construct(
        public int $id,
        public int $vacancy_id,
        public string $name,
        public string $url,
        public bool $accredited_it_employer,
        public bool $trusted,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'vacancy_id' => $this->vacancy_id,
            'name' => $this->name,
            'url' => $this->url,
            'accredited_it_employer' => $this->accredited_it_employer,
            'trusted' => $this->trusted,
        ];
    }
}
