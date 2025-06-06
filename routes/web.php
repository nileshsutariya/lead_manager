<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['admin'])->group(function () {
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

    Route::get('/category', [DataController::class, 'category'])->name('category');
    Route::post('/category_store', [DataController::class, 'store_category'])->name('category.store');
    Route::get('/category/delete/{id}', [DataController::class, 'delete'])->name('category.delete');
    Route::get('/category/edit/{id}', [DataController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [DataController::class, 'update'])->name('category.update');
    

    Route::get('/mail_create', [DataController::class, 'mail_create'])->name('mail.create');
    Route::post('/mail_create/store', [DataController::class, 'create_mail_store'])->name('create.mail.store');

    Route::get('/get_reference', [DataController::class, 'get_reference'])->name('get.reference');
    Route::get('/company_type', [DataController::class, 'company_type'])->name('company.type');
    Route::post('/company_type/store', [DataController::class, 'store_company'])->name('store.company');
    Route::get('/company_type/delete/{id}' ,[DataController::class, 'company_delete'])->name('company.delete');
    Route::get('/company_type/edit/{id}', [DataController::class, 'company_edit'])->name('company.edit');
    Route::post('/company_type/update/{id}', [DataController::class, 'company_update'])->name('company.update');

    Route::get('/users/search', [DataController::class, 'search'])->name('users.search');
    Route::get('/mail-templates/show', [DataController::class, 'show'])->name('mail.templates.show');
    Route::get('/user/mail-history', [DataController::class, 'mailHistory'])->name('user.mail.history');
});


Route::get('/', [DataController::class, 'login'])->name('login.view');
Route::post('/auth', [DataController::class, 'auth'])->name('login.auth');
Route::post('/logout', [DataController::class, 'logout'])->name('logout');
