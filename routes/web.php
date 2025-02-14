<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/data', [DataController::class, 'data_view'])->name('data');
Route::post('/data/store', [DataController::class, 'data_store'])->name('data.store');
Route::get('/data/edit/{id}', [DataController::class, 'data_edit'])->name('data.edit');
Route::post('/data/update/{id}', [DataController::class, 'data_update'])->name('data.update');
Route::get('/data/destroy/{id}', [DataController::class, 'data_destroy'])->name('data.destroy');
Route::get('/data/table', [DataController::class, 'data_table'])->name('data.table');

Route::get('/mail', [DataController::class, 'mail'])->name('mail');
Route::post('/mail/store', [DataController::class, 'mail_store'])->name('mail.store');
Route::get('/mail/edit/{id}', [DataController::class, 'mail_edit'])->name('mail.edit');
Route::post('/mail/update/{id}', [DataController::class, 'mail_update'])->name('mail.update');
Route::get('/mail/destroy/{id}', [DataController::class, 'mail_destroy'])->name('mail.destroy');
Route::get('/mail/table', [DataController::class, 'mail_table'])->name('mail.table');

Route::get('/sample-csv', [DataController::class, 'sample_csv'])->name('sample.csv');
Route::post('/import-csv', [DataController::class, 'import_csv'])->name('import.csv');



