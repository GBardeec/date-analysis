<?php

use App\Http\Controllers\AreasController;
use App\Http\Controllers\KeySkillController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\VacanciesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vacancies'], function () {
    Route::get('/', [VacanciesController::class, 'getAllVacancies']);
    Route::post('/new', [VacanciesController::class, 'getNewVacancies']);
    Route::get('/statistic', [VacanciesController::class, 'getStatistic']);

    Route::group(['prefix' => 'key-skill'], function () {
        Route::get('/statistic', [KeySkillController::class, 'index']);
    });
    Route::group(['prefix' => 'areas'], function () {
        Route::get('/statistic', [AreasController::class, 'index']);
    });

    Route::group(['prefix' => 'salaries'], function () {
        Route::get('/statistic', [SalariesController::class, 'index']);
    });
});
