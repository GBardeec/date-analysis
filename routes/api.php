<?php

use App\Http\Controllers\VacanciesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vacancies'], function ($router) {
	Route::post('/new', [VacanciesController::class, 'getNewVacancies']);
	Route::get('/get', [VacanciesController::class, 'getAllVacancies']);
});
