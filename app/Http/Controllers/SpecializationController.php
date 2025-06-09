<?php

namespace App\Http\Controllers;

use App\Models\Specializations;

class SpecializationController extends Controller
{
    public function getActiveSpecialization()
    {
        return Specializations::query()
            ->where('is_active', 1)
            ->first();
    }
}
