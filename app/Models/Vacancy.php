<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacancy extends Model
{
    protected $table = 'vacancies';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'url',
        'premium',
        'has_test',
        'response_letter_required',
        'snippet',
        'published_at',
        'created_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'snippet' => 'json',
        'premium' => 'boolean',
        'has_test' => 'boolean',
        'response_letter_required' => 'boolean',
        'published_at' => 'timestamp',
        'created_at' => 'timestamp',
    ];

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class);
    }
}
