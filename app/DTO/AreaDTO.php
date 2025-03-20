<?php

namespace App\DTO;

class AreaDTO
{
    public function __construct(
        public int $id,
        public int $vacancy_id,
        public string $name,
        public string $url,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'vacancy_id' => $this->vacancy_id,
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}
