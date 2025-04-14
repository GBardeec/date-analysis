<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class VacancyArea extends Model
{
    protected $table = 'vacancy_area';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'url',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function salaries()
    {
        return $this->hasManyThrough(
            VacancySalary::class,
            Vacancy::class,
            'id',
            'vacancy_id',
            'vacancy_id',
            'id'
        );
    }
}
