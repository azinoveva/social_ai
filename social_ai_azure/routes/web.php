<?php

use Illuminate\Support\Facades\Route;
use App\Entries\SearchRepository;
use App\Http\Controllers\EntryController;

Route::get('/', function () {
    return redirect()->route('keyword-search');
});

Route::view('/index-data', 'index-data')->name('index-data');
Route::post('/index-data', [EntryController::class, 'indexJson']);

Route::get('/keyword-search', function (SearchRepository $searchRepository) {
    return view('dashboard', [
        'entries' => request()->has('q')
            ? $searchRepository->search(request('q'))
            : App\Models\Entry::all(),
    ]);
})->name('keyword-search'); 

Route::get('/semantic-search', function (SearchRepository $searchRepository) {
    return view('dashboard', [
        'entries' => request()->has('q')
            ? $searchRepository->search(request('q'))
            : App\Models\Entry::all(),
    ]);
})->name('semantic-search'); 