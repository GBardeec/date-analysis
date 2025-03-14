<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $table = 'vacancies';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
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

}
