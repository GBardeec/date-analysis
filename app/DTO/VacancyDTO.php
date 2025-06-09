<?php

namespace App\DTO;

use Carbon\Carbon;

class VacancyDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public int $specialization_id,
        public string $url,
        public bool $premium,
        public bool $has_test,
        public bool $response_letter_required,
        public ?array $snippet,
        public ?array $key_skills,
        public ?string $published_at,
        public ?string $created_at,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'specialization_id' => $this->specialization_id,
            'url' => $this->url,
            'premium' => $this->premium,
            'has_test' => $this->has_test,
            'response_letter_required' => $this->response_letter_required,
            'snippet' => json_encode($this->snippet),
            'key_skills' => json_encode($this->key_skills),
            'published_at' => Carbon::parse($this->published_at)->toDateTimeString(),
            'created_at' => Carbon::parse($this->published_at)->toDateTimeString(),
        ];
    }
}
