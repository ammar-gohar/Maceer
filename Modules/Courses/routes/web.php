<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Courses\Livewire\Pages\CourseLibrary;
use Modules\Courses\Livewire\Pages\CourseRequests;
use Modules\Courses\Livewire\Pages\CourseRequestsStats;
use Modules\Courses\Livewire\Pages\CoursesCreate;
use Modules\Courses\Livewire\Pages\CoursesEdit;
use Modules\Courses\Livewire\Pages\CoursesIndex;
use Modules\Courses\Livewire\Pages\CoursesShow;
use Modules\Courses\Livewire\Pages\ProfessorCourses;
use Modules\Courses\Livewire\Pages\Schedule;
use Modules\Courses\Livewire\Pages\StudentCourses;
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
        'prefix' => 'courses'
    ], function () {

        Route::get('/schedule', Schedule::class)
            ->middleware('permission:courses.schedule')
            ->name('courses.schedule');

        Route::get('/student-schedule', Schedule::class)
            ->middleware('permission:courses.student-schedule')
            ->name('courses.student-schedule');

        Route::get('/student-courses', StudentCourses::class)
        ->middleware('permission:courses.student.show')
        ->name('courses.student-show');

        Route::get('/professor-courses', ProfessorCourses::class)
        ->middleware('permission:courses.professor.show')
        ->name('courses.professor-show');

        Route::get('courses/requests', CourseRequestsStats::class)
        ->middleware(['auth', 'permission:courses.enrollment'])
        ->name('courses.requests');

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

        Route::get('/{code}/library', CourseLibrary::class)
            ->name('courses.library');

    });

});


