<?php

use Illuminate\Support\Facades\Route;
use Modules\Halls\Http\Controllers\HallsController;
use Modules\Halls\Livewire\Pages\HallsCreate;
use Modules\Halls\Livewire\Pages\HallsEdit;
use Modules\Halls\Livewire\Pages\HallsIndex;
use Modules\Halls\Livewire\Pages\HallsShow;

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
    'middleware' => ['auth'],
], function () {

    Route::group([
        'prefix' => 'halls'
    ], function () {

        Route::get('/', HallsIndex::class)
        ->middleware('permission:halls.index')
        ->name('halls.index');

        Route::get('/create', HallsCreate::class)
            ->middleware('permission:halls.create')
            ->name('halls.create');

        Route::get('/{id}', HallsShow::class)
            ->middleware('permission:halls.show')
            ->name('halls.show');

        Route::get('/{id}/edit', HallsEdit::class)
            ->middleware('permission:halls.edit')
            ->name('halls.edit');
    });

});
