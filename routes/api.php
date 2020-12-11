<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DateController;
use App\Http\Controllers\Api\SalariesController;

Route::get('date', [DateController::class, 'index']);
Route::post('date', [DateController::class, 'store']);

Route::get('salary', [SalariesController::class, 'index']);
Route::post('salary', [SalariesController::class, 'store']);