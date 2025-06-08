<?php

use Illuminate\Support\Facades\Route;
use Modules\Quizzes\Http\Controllers\QuizzesController;
use Modules\Quizzes\Livewire\Pages\QuizzesCreate;
use Modules\Quizzes\Livewire\Pages\QuizzesEdit;
use Modules\Quizzes\Livewire\Pages\QuizzesIndex;
use Modules\Quizzes\Livewire\Pages\QuizzesIndexStudent;
use Modules\Quizzes\Livewire\Pages\QuizzesShowStudent;

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
    'prefix' => 'courses/{courseId}/quizzes',
], function () {
    // Route::resource('quizzes', QuizzesController::class)->names('quizzes');
    Route::get('/', QuizzesIndex::class)
        ->middleware('permission:quizzes.index')
        ->name('courses.quizzes');

    Route::get('/create', QuizzesCreate::class)
        ->middleware('permission:quizzes.create')
        ->name('quizzes.create');

    Route::get('/edit/{quizId}', QuizzesEdit::class)
        ->middleware('permission:quizzes.edit')
        ->name('quizzes.edit');

});

Route::group([
    'prefix' => 'quizzes',
    // 'middleware' => ['auth', 'permission:quizzes.attempt']
], function () {

    Route::get('/', QuizzesIndexStudent::class)
        ->name('quizzes.index-student');

    Route::get('/{id}', QuizzesShowStudent::class)
        ->name('quizzes.take-quiz');

});
