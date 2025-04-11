<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Students\StudentController;



Route::get('/', function () {
    return view('students.scores');
});
//================================================================================
Route::group(['controller' => StudentController::class], function () {
    Route::get('/scores/upload', 'uploadScores')->name('scores.upload');
    Route::post('/scores/process', 'processScores')->name('scores.process');
    Route::get('/scores/test', 'test')->name('scores.test');
});
//=================================================================================