<?php

use Illuminate\Support\Facades\Route;
use Modules\moderators\Http\Controllers\moderatorsController;

use Modules\Moderators\Livewire\Pages\ModeratorsCreate;
use Modules\Moderators\Livewire\Pages\ModeratorsIndex;
use Modules\Moderators\Livewire\Pages\ModeratorsEdit;
use Modules\Moderators\Livewire\Pages\ModeratorsShow;

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
    'prefix'     => 'moderators',
    'middleware' => ['auth'],
], function () {
    Route::get('/', ModeratorsIndex::class)
        ->name('moderators.index')
        ->middleware(['permission:moderators.index']);

    Route::get('/create', ModeratorsCreate::class)
        ->name('moderators.create')
        ->middleware(['permission:moderators.create']);

    Route::get('/{national_id}', Moderatorsshow::class)
        ->name('moderators.show')
        ->middleware(['permission:moderators.show']);

    Route::get('/edit/{national_id}', ModeratorsEdit::class)
        ->name('moderators.edit')
        ->middleware(['permission:moderators.edit']);

});
