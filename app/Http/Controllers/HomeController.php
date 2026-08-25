<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Organization;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredExams = Exam::with(['organization', 'examType'])
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        $subjects = Subject::withCount('questions')->where('is_active', true)->get();
        $setterBodies = Organization::where('is_question_setter', true)->withCount('setterQuestions')->get();
        
        $totalQuestions = Question::where('status', 'published')->count();
        $totalExams = Exam::where('is_published', true)->count();
        $totalCandidates = User::count();

        return view('home', compact('featuredExams', 'subjects', 'setterBodies', 'totalQuestions', 'totalExams', 'totalCandidates'));
    }
}
