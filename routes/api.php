<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsAggregatorController;
use App\Http\Controllers\Api\ArticleController;

Route::get('/news', [NewsAggregatorController::class, 'fetchAllNews']);
Route::get('/news/{source}', [NewsAggregatorController::class, 'fetchNewsBySource']);


Route::get('/articles/search', [ArticleController::class, 'search']);

Route::get('/articles/preferences', [ArticleController::class, 'fetchByPreferences'])
    ->middleware('auth:api');

Route::post('/preferences', [ArticleController::class, 'savePreferences'])
    ->middleware('auth:api');