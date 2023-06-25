<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.jobs.index');
});
Route::resource('jobs',\App\Http\Controllers\Job\JobController::class);
Route::get('jobs/{job}/show',[\App\Http\Controllers\Job\JobController::class,'showJob'])->name('jobs.show.ajax');
