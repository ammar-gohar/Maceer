<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;
use Modules\Reports\Livewire\ExamSchedule;

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

Route::group([], function () {
    // Route::resource('reports', ReportsController::class)->names('reports');
    Route::get('/exams/generator', ExamSchedule::class)
        ->name('exam.schedule.generate');
});
