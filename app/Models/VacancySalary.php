<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class VacancySalary extends Model
{
    protected $table = 'vacancy_salary';
    public $timestamps = false;

    public const SALARY_CATEGORIES = [
        'до 50 тыс. руб.' => 50000,
        '50 тыс. руб. - 100 тыс. руб.' => 100000,
        '100 тыс. руб. - 150 тыс. руб.' => 150000,
        '150 тыс. руб. - 200 тыс. руб.' => 200000,
        '200 тыс. руб. - 300 тыс. руб.' => 300000,
        '300 тыс. руб. - 500 тыс. руб.' => 500000,
        'более 500 тыс. руб.' => PHP_INT_MAX
    ];

    protected $fillable = [
        'from',
        'to',
        'currency',
        'gross',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function area(): HasOneThrough
    {
        return $this->hasOneThrough(
            VacancyArea::class,
            Vacancy::class,
            'id',
            'vacancy_id',
            'vacancy_id',
            'id'
        );
    }
}
