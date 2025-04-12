<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Students\StudentScoreController;

//=================================================================================
Route::get('/', [HomeController::class,'home'])->name('home');
//================================================================================
Route::group(['controller' => StudentScoreController::class], function () {
    Route::get('/scores/upload', 'uploadScores')->name('scores.upload');
    Route::post('/scores/process', 'processScores')->name('scores.process');
    Route::get('/scores/template', 'csvTemplate')->name('scores.template');
});
//=================================================================================
Route::resource('subjects', SubjectController::class);
//=================================================================================