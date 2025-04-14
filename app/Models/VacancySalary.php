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
        'до 50k' => 50000,
        '50k-100k' => 100000,
        '100k-150k' => 150000,
        '150k-200k' => 200000,
        '200k-300k' => 300000,
        '300k-500k' => 500000,
        '500k+' => PHP_INT_MAX
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
