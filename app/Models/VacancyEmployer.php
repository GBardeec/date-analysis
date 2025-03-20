<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacancyEmployer extends Model
{
    protected $table = 'vacancy_employer';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'url',
        'accredited_it_employer',
        'trusted',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }
}
