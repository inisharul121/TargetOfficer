<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ExamApiController;
use App\Http\Controllers\Api\V1\QuestionApiController;
use App\Http\Controllers\Api\V1\TaxonomyApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile REST API Routes (Version 1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Public Auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Taxonomies
    Route::get('/subjects', [TaxonomyApiController::class, 'subjects']);
    Route::get('/setter-bodies', [TaxonomyApiController::class, 'setterBodies']);

    // Exams (Public browse)
    Route::get('/exams', [ExamApiController::class, 'index']);
    Route::get('/exams/{exam}', [ExamApiController::class, 'show']);

    // Questions Practice
    Route::get('/questions/practice', [QuestionApiController::class, 'practice']);

    // Authenticated Mobile Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/user', [AuthController::class, 'user']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Exam Execution
        Route::post('/exams/{exam}/start', [ExamApiController::class, 'start']);
        Route::post('/attempts/{attempt}/autosave', [ExamApiController::class, 'autoSave']);
        Route::post('/attempts/{attempt}/submit', [ExamApiController::class, 'submit']);
        Route::get('/my-attempts', [ExamApiController::class, 'myAttempts']);

        // Bookmarks & Reporting
        Route::post('/questions/{question}/bookmark', [QuestionApiController::class, 'toggleBookmark']);
        Route::post('/questions/{question}/report', [QuestionApiController::class, 'report']);
    });
});
