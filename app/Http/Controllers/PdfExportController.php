<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class PdfExportController extends Controller
{
    /**
     * Generate printable question paper or solution guide for an Exam.
     */
    public function exportExam(Exam $exam, Request $request)
    {
        $mode = $request->query('mode', 'solutions'); // 'questions' or 'solutions'

        $questions = $exam->questions()
            ->with(['options', 'subject', 'topic'])
            ->orderBy('exam_questions.order')
            ->get();

        $title = $exam->title_bn;
        $totalMarks = $exam->total_marks > 0 ? $exam->total_marks : $questions->count();
        $durationMinutes = $exam->duration_minutes;
        $negativeMark = $exam->negative_mark_per_question;

        return view('export.pdf-question-paper', compact(
            'exam',
            'questions',
            'title',
            'totalMarks',
            'durationMinutes',
            'negativeMark',
            'mode'
        ));
    }

    /**
     * Generate printable question paper from Question Bank filters.
     */
    public function exportQuestionBank(Request $request)
    {
        $mode = $request->query('mode', 'solutions');
        $subjectId = $request->query('subject_id');
        $examYearId = $request->query('exam_year_id');
        $search = $request->query('search');

        $query = Question::where('status', 'published')->with(['options', 'subject', 'topic']);

        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }
        if ($examYearId) {
            $query->where('exam_year_id', $examYearId);
        }
        if ($search) {
            $query->where('stem_bn', 'like', "%{$search}%");
        }

        $questions = $query->take(100)->get();
        $title = 'টার্গেট অফিসার – বিসিএস ও চাকরি প্রস্তুতি প্রশ্ন আর্কাইভ';
        $totalMarks = $questions->count();
        $durationMinutes = $questions->count();
        $negativeMark = 0.50;

        return view('export.pdf-question-paper', compact(
            'questions',
            'title',
            'totalMarks',
            'durationMinutes',
            'negativeMark',
            'mode'
        ));
    }
}
