<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportController;
use Modules\Reports\Http\Controllers\ReportsController;
use Modules\Reports\Livewire\ExamSchedule;
use Modules\Reports\Livewire\Pages\DocumentsCreate;
use Modules\Reports\Livewire\Pages\GpaCalculator;
use Modules\Reports\Livewire\Pages\Receipts;
use Modules\Reports\Livewire\Pages\ReportRequests;

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

], function () {
    // Route::resource('reports', ReportsController::class)->names('reports');
    Route::get('/exams/generator', ExamSchedule::class)
        ->name('exam.schedule.generate');
});

Route::group([
    'prefix' => 'reports',
    'as' => 'reports.',
], function () {

    Route::get('/current-enrollment/{semesterId}/{studentId}', [ReportController::class, 'current_enrollment'])
        ->name('current.enrollment');

    Route::get('/enrollments/{studentId}', [ReportController::class, 'enrollments'])
        ->name('all-enrollments');

    Route::get('/transcript/{id}/{lang?}', [ReportController::class, 'transcript'])
        ->name('transcript')
        ->middleware('permission:reports.requests.fullfilling');

    Route::get('/receipt/{studentId}', [ReportController::class, 'receipt'])
        ->name('receipt');

});

Route::get('documents/requests', ReportRequests::class)
    ->name('docs.index')
    ->middleware(['permission:reports.request|reports.requests.fullfilling', 'auth']);

Route::get('documents/print/{studentId?}', DocumentsCreate::class)
    ->name('docs.create')
    ->middleware(['permission:reports.requests.fullfilling', 'auth']);

Route::get('/receipts/register', Receipts::class)
    ->name('receipt.register')
    ->middleware(['permission:reports.receipt.register', 'auth']);

Route::get('/receipt', Receipts::class)
    ->name('receipt.show')
    ->middleware(['permission:reports.receipt', 'auth']);

Route::get('/gpa-calculator', GpaCalculator::class)
    ->name('gpa.calculator')
    ->middleware(['permission:courses.enrollment', 'auth']);
