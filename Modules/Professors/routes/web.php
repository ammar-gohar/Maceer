<?php

use Illuminate\Support\Facades\Route;
use Modules\professors\Http\Controllers\professorsController;

use Modules\Professors\Livewire\{
    ProfessorsList,
    Pages\ProfessorsCreate,
    Pages\ProfessorsEdit,
    Pages\ProfessorsIndex,
    Pages\ProfessorsShow,
};
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
    'prefix'     => 'professors',
    'middleware' => ['auth', 'permission:professors.*'],
], function () {
    Route::get('/', ProfessorsIndex::class)
        ->name('professors.index')
        ->middleware(['permission:professors.index']);

    Route::get('/create', ProfessorsCreate::class)
        ->name('professors.create')
        ->middleware(['permission:professors.create']);

    Route::get('/{national_id}', ProfessorsShow::class)
        ->name('professors.show')
        ->middleware(['permission:professors.show']);

    Route::get('/edit/{national_id}', ProfessorsEdit::class)
        ->name('professors.edit')
        ->middleware(['permission:professors.edit']);

});
