<?php

namespace App\Services;

use App\Models\Specializations;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class SpecializationService
{
    const DEFAULT_SPECIALIZATION = 165;
    const COOKIE_NAME = 'active_specialization';
    const COOKIE_LIFETIME = 30 * 24 * 60; // 30 дней в минутах

    public function getActiveSpecialization(Request $request)
    {
        $specializationId = (int)$request->cookie(self::COOKIE_NAME, self::DEFAULT_SPECIALIZATION);

        if (!Specializations::where('id', $specializationId)->exists()) {
            return [
                'specialization_id' => self::DEFAULT_SPECIALIZATION,
                'specialization_name' => $this->getActiveSpecializationName(self::DEFAULT_SPECIALIZATION),
            ];
        }

        return [
            'specialization_id' => $specializationId,
            'specialization_name' => $this->getActiveSpecializationName($specializationId),
        ];
    }

    public function saveActiveSpecialization(int $specializationId): Cookie
    {
        return cookie(
            self::COOKIE_NAME,
            $specializationId,
            self::COOKIE_LIFETIME,
            '/',
            null,
            false,
            false
        );
    }

    public function getActiveSpecializationName(int $specializationId)
    {
        return Specializations::query()
            ->where('id', $specializationId)
            ->pluck('name')
            ->first();
    }

    public function getActiveSpecializationId(Request $request): int
    {
        $specializationId = (int)$request->cookie(self::COOKIE_NAME, self::DEFAULT_SPECIALIZATION);

        if (!Specializations::where('id', $specializationId)->exists()) {
           return self::DEFAULT_SPECIALIZATION;
        }

        return $specializationId;
    }
}
