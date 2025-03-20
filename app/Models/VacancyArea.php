<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
