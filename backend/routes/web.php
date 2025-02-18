<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

Route::resource('question', QuestionController::class);
Route::resource('answer', AnswerController::class);