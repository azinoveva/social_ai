<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntryController;

Route::get('/', function () {
    return redirect()->route('keyword-search');
});

Route::get('/keyword-search', [EntryController::class, 'keywordSearch'])->name('keyword-search');
Route::get('/semantic-search', [EntryController::class, 'azureSearch'])->name('semantic-search');