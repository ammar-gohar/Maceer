<?php

use Illuminate\Support\Facades\Route;
use Modules\Courses\Livewire\Pages\CoursesCreate;
use Modules\Courses\Livewire\Pages\CoursesEdit;
use Modules\Courses\Livewire\Pages\CoursesIndex;
use Modules\Courses\Livewire\Pages\CoursesShow;
use Modules\Courses\Livewire\Pages\Schedule;

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
    'middleware' => ['auth', 'permission:courses.*'],
], function () {

    Route::group([
        'prefix' => 'courses'
    ], function () {

        Route::get('/', CoursesIndex::class)
        ->middleware('permission:courses.index')
        ->name('courses.index');

        Route::get('/create', CoursesCreate::class)
            ->middleware('permission:courses.create')
            ->name('courses.create');

        Route::get('/{code}', CoursesShow::class)
            ->middleware('permission:courses.show')
            ->name('courses.show');

        Route::get('/{code}/edit', CoursesEdit::class)
            ->middleware('permission:courses.edit')
            ->name('courses.edit');
    });

    Route::get('/schedule', Schedule::class)
        ->middleware('permission:courses.schedule')
        ->name('courses.schedule');

});
