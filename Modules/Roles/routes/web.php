<?php

use Illuminate\Support\Facades\Route;
use Modules\Roles\Livewire\Pages\{
    RolesIndex,
    RolesShow,
    RolesCreate,
    RolesEdit,
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
    'prefix' => 'roles',
    'middleware' => ['auth', 'permission:roles.*'],
], function () {
    Route::get('/', RolesIndex::class)->name('roles.index')->middleware('permission:roles.index');
    Route::get('/create', RolesCreate::class)->name('roles.create')->middleware('permission:roles.create');
    Route::get('/{id}', RolesShow::class)->name('roles.show')->middleware('permission:roles.show');
    Route::get('/edit/{id}', RolesEdit::class)->name('roles.edit')->middleware('permission:roles.edit');
});
