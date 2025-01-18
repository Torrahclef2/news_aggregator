<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsAggregatorController;

Route::get('/', [NewsAggregatorController::class, 'showNews']);
// Route::get('/', [NewsController::class, 'showNews']);
// Route::get('/', [NewsAggregatorController::class, 'showNews']);