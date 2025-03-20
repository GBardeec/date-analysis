<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacancySalary extends Model
{
    protected $table = 'vacancy_salary';
    public $timestamps = false;

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
}
