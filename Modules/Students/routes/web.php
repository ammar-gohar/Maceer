<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

use Modules\Students\Livewire\Pages\StudentCreate;
use Modules\Students\Livewire\Pages\StudentsIndex;
use Modules\Students\Livewire\Pages\StudentEdit;
use Modules\Students\Livewire\Pages\StudentShow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix'     => 'students',
    'middleware' => ['auth'],
], function () {
    Route::get('/', StudentsIndex::class)
        ->name('students.index')
        ->middleware(['permission:students.index']);

    Route::get('/create', StudentCreate::class)
        ->name('students.create')
        ->middleware(['permission:students.create']);

    Route::get('/{national_id}', StudentShow::class)
        ->name('students.show')
        ->middleware(['permission:students.show']);

    Route::get('/edit/{national_id}', StudentEdit::class)
        ->name('students.edit')
        ->middleware(['permission:students.edit']);

});
