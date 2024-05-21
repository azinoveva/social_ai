<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntryController;
use App\Http\Middleware\ForceHttp;

Route::get('/', function () {
    return redirect()->route('keyword-search');
});

Route::get('/keyword-search', [EntryController::class, 'keywordSearch'])
    ->middleware(ForceHttp::class)
    ->name('keyword-search');

Route::get('/semantic-search', [EntryController::class, 'azureSearch'])
    ->middleware(ForceHttp::class)
    ->name('semantic-search');