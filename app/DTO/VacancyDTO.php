<?php

namespace App\DTO;

use Carbon\Carbon;

class VacancyDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $premium,
        public bool $has_test,
        public bool $response_letter_required,
        public ?array $snippet,
        public ?string $published_at,
        public ?string $created_at,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'premium' => $this->premium,
            'has_test' => $this->has_test,
            'response_letter_required' => $this->response_letter_required,
            'snippet' => json_encode($this->snippet),
            'published_at' => Carbon::parse($this->published_at)->toDateTimeString(),
            'created_at' => Carbon::parse($this->published_at)->toDateTimeString(),
        ];
    }
}
