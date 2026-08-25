<?php

use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\QuestionBankController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
Route::get('/exams/{exam:slug}', [ExamController::class, 'show'])->name('exams.show');
Route::get('/practice', [PracticeController::class, 'index'])->name('practice.index');
Route::get('/question-bank', [QuestionBankController::class, 'index'])->name('question-bank.index');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::get('/demo-login/{type?}', [AuthController::class, 'demoLogin'])->name('demo.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Candidate Authenticated Portal
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Exam Engine
    Route::get('/exams/{exam:slug}/room', [ExamController::class, 'room'])->name('exams.room');
    Route::post('/attempts/{attempt}/save-state', [ExamController::class, 'saveState'])->name('attempts.saveState');
    Route::post('/attempts/{attempt}/submit', [ExamController::class, 'submit'])->name('attempts.submit');
    Route::get('/attempts/{attempt}/result', [ExamController::class, 'result'])->name('exams.result');

    // Custom Exam Generator
    Route::get('/custom-exam', [ExamController::class, 'createCustom'])->name('exams.custom');
    Route::post('/custom-exam', [ExamController::class, 'storeCustom'])->name('exams.custom.store');

    // Bookmarks & Reports
    Route::post('/questions/{question}/bookmark', [QuestionBankController::class, 'toggleBookmark'])->name('questions.bookmark');
    Route::post('/questions/{question}/report', [QuestionBankController::class, 'reportQuestion'])->name('questions.report');

    // Admin & Setter CMS
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/questions', [AdminQuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/create', [AdminQuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
        Route::get('/questions/template', [AdminQuestionController::class, 'downloadTemplate'])->name('questions.template');
        Route::post('/questions/bulk-upload', [AdminQuestionController::class, 'bulkUpload'])->name('questions.bulk-upload');
    });
});
