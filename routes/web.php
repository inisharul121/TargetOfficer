<?php

use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminExamController;
use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminTaxonomyController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\QuestionBankController;
use Illuminate\Support\Facades\Route;

// Public Routes & Language Switch
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['bn', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

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

    // Student Learning Hub & Performance Analytics
    Route::get('/student/progress', [\App\Http\Controllers\StudentAnalyticsController::class, 'progress'])->name('student.progress');
    Route::get('/student/mistakes', [\App\Http\Controllers\StudentAnalyticsController::class, 'mistakes'])->name('student.mistakes');
    Route::post('/student/mistakes/retake', [\App\Http\Controllers\StudentAnalyticsController::class, 'retakeMistakes'])->name('student.mistakes.retake');
    Route::get('/student/bookmarks', [\App\Http\Controllers\StudentAnalyticsController::class, 'bookmarks'])->name('student.bookmarks');

    // Live Model Test & Merit List
    Route::get('/live-exams', [\App\Http\Controllers\LiveExamController::class, 'index'])->name('live-exams.index');
    Route::get('/live-exams/{exam:slug}/leaderboard', [\App\Http\Controllers\LiveExamController::class, 'leaderboard'])->name('live-exams.leaderboard');

    // Weekly Study Routine & Syllabus Tracker
    Route::get('/routine', [\App\Http\Controllers\StudyRoutineController::class, 'index'])->name('routine.index');
    Route::post('/routine/{routine}/toggle', [\App\Http\Controllers\StudyRoutineController::class, 'toggle'])->name('routine.toggle');

    // 1v1 Quiz Duel Battle
    Route::get('/battle', [\App\Http\Controllers\QuizDuelController::class, 'index'])->name('battle.index');
    Route::post('/battle', [\App\Http\Controllers\QuizDuelController::class, 'store'])->name('battle.store');
    Route::post('/battle/join', [\App\Http\Controllers\QuizDuelController::class, 'join'])->name('battle.join');
    Route::get('/battle/{code}', [\App\Http\Controllers\QuizDuelController::class, 'arena'])->name('battle.arena');
    Route::post('/battle/{code}/submit', [\App\Http\Controllers\QuizDuelController::class, 'submit'])->name('battle.submit');
    Route::get('/battle/{code}/result', [\App\Http\Controllers\QuizDuelController::class, 'result'])->name('battle.result');

    // High-Yield Spaced Repetition Flashcards
    Route::get('/flashcards', [\App\Http\Controllers\FlashcardController::class, 'index'])->name('flashcards.index');
    Route::post('/flashcards/{flashcard}/rate', [\App\Http\Controllers\FlashcardController::class, 'rate'])->name('flashcards.rate');

    // Daily & Monthly Current Affairs GK Feed
    Route::get('/current-affairs', [\App\Http\Controllers\CurrentAffairsController::class, 'index'])->name('current-affairs.index');

    // Digital Books Engine (MCQ + Written)
    Route::get('/books', [\App\Http\Controllers\BookController::class, 'index'])->name('books.index');
    Route::get('/books/{slug}', [\App\Http\Controllers\BookController::class, 'show'])->name('books.show');
    Route::get('/books/{slug}/chapter/{chapterNumber?}', [\App\Http\Controllers\BookController::class, 'read'])->name('books.read');
    Route::get('/books/{slug}/chapter/{chapterNumber}/export', [\App\Http\Controllers\BookController::class, 'exportChapter'])->name('books.export');

    // PDF / Print Question Paper Generator
    Route::get('/export/exam/{exam}', [\App\Http\Controllers\PdfExportController::class, 'exportExam'])->name('export.exam');
    Route::get('/export/question-bank', [\App\Http\Controllers\PdfExportController::class, 'exportQuestionBank'])->name('export.question-bank');

    // Bookmarks, Reports & Discussion Threads
    Route::post('/questions/{question}/bookmark', [QuestionBankController::class, 'toggleBookmark'])->name('questions.bookmark');
    Route::post('/questions/{question}/report', [QuestionBankController::class, 'reportQuestion'])->name('questions.report');
    Route::post('/questions/{question}/comments', [QuestionBankController::class, 'addComment'])->name('questions.comments.store');
    Route::post('/comments/{comment}/upvote', [QuestionBankController::class, 'upvoteComment'])->name('comments.upvote');

    // Admin & Staff CMS Portal
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Exams Management & Builder
        Route::get('/exams', [AdminExamController::class, 'index'])->name('exams.index');
        Route::get('/exams/create', [AdminExamController::class, 'create'])->name('exams.create');
        Route::post('/exams', [AdminExamController::class, 'store'])->name('exams.store');
        Route::get('/exams/{exam}/edit', [AdminExamController::class, 'edit'])->name('exams.edit');
        Route::put('/exams/{exam}', [AdminExamController::class, 'update'])->name('exams.update');
        Route::delete('/exams/{exam}', [AdminExamController::class, 'destroy'])->name('exams.destroy');
        Route::get('/exams/{exam}/builder', [AdminExamController::class, 'builder'])->name('exams.builder');
        Route::post('/exams/{exam}/attach-question', [AdminExamController::class, 'attachQuestion'])->name('exams.attach-question');
        Route::post('/exams/{exam}/detach-question/{question}', [AdminExamController::class, 'detachQuestion'])->name('exams.detach-question');
        Route::post('/exams/{exam}/auto-assign', [AdminExamController::class, 'autoAssignQuestions'])->name('exams.auto-assign');

        // Questions Management
        Route::get('/questions', [AdminQuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/create', [AdminQuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
        Route::get('/questions/template', [AdminQuestionController::class, 'downloadTemplate'])->name('questions.template');
        Route::post('/questions/bulk-upload', [AdminQuestionController::class, 'bulkUpload'])->name('questions.bulk-upload');
        Route::get('/questions/duplicates', [AdminQuestionController::class, 'duplicates'])->name('questions.duplicates');
        Route::post('/questions/resolve-duplicate', [AdminQuestionController::class, 'resolveDuplicate'])->name('questions.resolve-duplicate');
        Route::get('/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/questions/{question}', [AdminQuestionController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');

        // Question Reports Moderation Queue
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::put('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.status');
        Route::delete('/reports/{report}', [AdminReportController::class, 'destroy'])->name('reports.destroy');

        // Taxonomies
        Route::get('/taxonomies', [AdminTaxonomyController::class, 'index'])->name('taxonomies.index');
        Route::post('/taxonomies/subject', [AdminTaxonomyController::class, 'storeSubject'])->name('taxonomies.subject.store');
        Route::post('/taxonomies/topic', [AdminTaxonomyController::class, 'storeTopic'])->name('taxonomies.topic.store');
        Route::post('/taxonomies/organization', [AdminTaxonomyController::class, 'storeOrganization'])->name('taxonomies.organization.store');
        Route::post('/taxonomies/exam-type', [AdminTaxonomyController::class, 'storeExamType'])->name('taxonomies.exam-type.store');
        Route::post('/taxonomies/exam-year', [AdminTaxonomyController::class, 'storeExamYear'])->name('taxonomies.exam-year.store');

        // User & Role Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');

        // Digital Books & Topics Management Suite
        Route::get('/books', [\App\Http\Controllers\Admin\AdminBookController::class, 'index'])->name('books.index');
        Route::get('/books/create', [\App\Http\Controllers\Admin\AdminBookController::class, 'create'])->name('books.create');
        Route::post('/books', [\App\Http\Controllers\Admin\AdminBookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [\App\Http\Controllers\Admin\AdminBookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [\App\Http\Controllers\Admin\AdminBookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [\App\Http\Controllers\Admin\AdminBookController::class, 'destroy'])->name('books.destroy');
        Route::get('/books/{book}/builder', [\App\Http\Controllers\Admin\AdminBookController::class, 'builder'])->name('books.builder');

        // Book Chapters
        Route::post('/books/{book}/chapters', [\App\Http\Controllers\Admin\AdminBookController::class, 'storeChapter'])->name('books.chapters.store');
        Route::put('/chapters/{chapter}', [\App\Http\Controllers\Admin\AdminBookController::class, 'updateChapter'])->name('books.chapters.update');
        Route::delete('/chapters/{chapter}', [\App\Http\Controllers\Admin\AdminBookController::class, 'destroyChapter'])->name('books.chapters.destroy');

        // Book Topics / Written Contents
        Route::post('/chapters/{chapter}/topics', [\App\Http\Controllers\Admin\AdminBookController::class, 'storeTopic'])->name('books.topics.store');
        Route::get('/topics/{topic}/edit', [\App\Http\Controllers\Admin\AdminBookController::class, 'editTopic'])->name('books.topics.edit');
        Route::put('/topics/{topic}', [\App\Http\Controllers\Admin\AdminBookController::class, 'updateTopic'])->name('books.topics.update');
        Route::delete('/topics/{topic}', [\App\Http\Controllers\Admin\AdminBookController::class, 'destroyTopic'])->name('books.topics.destroy');

        // Analytics & Question Calibration
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    });
});
