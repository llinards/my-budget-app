<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DateController;

Route::get('date', [DateController::class, 'index']);
Route::post('date', [DateController::class, 'store']);
