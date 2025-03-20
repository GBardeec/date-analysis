<?php

namespace App\DTO;

use Carbon\Carbon;

class SalaryDTO
{
    public function __construct(
        public int $vacancy_id,
        public ?int $from,
        public ?int $to,
        public ?string $currency,
        public ?bool $gross,
    ) {}

    public function toArray(): array
    {
        return [
            'vacancy_id' => $this->vacancy_id,
            'from' => $this->from,
            'to' => $this->to,
            'currency' => $this->currency,
            'gross' => $this->gross,
        ];
    }
}
