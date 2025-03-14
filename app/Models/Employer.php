<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employer extends Model
{
    protected $table = 'employers';
    protected $fillable = [
        'id',
        'name',
        'url',
        'accredited_it_employer',
        'trusted',
    ];

    public $timestamps = false;

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }
}
