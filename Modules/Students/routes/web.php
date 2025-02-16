<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

use Modules\Students\Livewire\Pages\StudentsCreate;
use Modules\Students\Livewire\Pages\StudentsIndex;

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
    'middleware' => 'auth',
], function () {
    // Route::resource('students', StudentsController::class)->names('students');
    Route::get('/', StudentsIndex::class)->name('students.index');

    Route::get('/create', StudentsCreate::class)->name('students.create');

    Route::get('/edit/{student:national_id}', StudentsCreate::class)->name('students.edit');

});
