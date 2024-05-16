<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Entries\SearchRepository;
use App\Http\Controllers\EntryController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/index-data', 'index-data')->name('index-data');
Route::post('/index-data', [EntryController::class, 'indexJson']);

Route::get('/dashboard', function (SearchRepository $searchRepository) {
    return view('dashboard', [
        'entries' => request()->has('q')
            ? $searchRepository->search(request('q'))
            : App\Models\Entry::all(),
    ]);
})->middleware(['auth'])->name('dashboard'); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
