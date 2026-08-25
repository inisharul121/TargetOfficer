<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionTag;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AdminQuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::with(['subject', 'topic', 'setterOrganization', 'options']);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $questions = $query->latest()->paginate(20)->withQueryString();
        $subjects = Subject::all();

        return view('admin.questions.index', compact('questions', 'subjects'));
    }

    public function create()
    {
        $subjects = Subject::with('topics')->get();
        $setters = Organization::where('is_question_setter', true)->get();

        return view('admin.questions.create', compact('subjects', 'setters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'setter_organization_id' => 'nullable|exists:organizations,id',
            'stem_bn' => 'required|string',
            'stem_en' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'default_marks' => 'required|numeric|min:0.5',
            'negative_marks' => 'required|numeric|min:0',
            'explanation_bn' => 'nullable|string',
            'reference_source' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*.text_bn' => 'required|string',
            'correct_option' => 'required|integer',
            'tags' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $question = Question::create([
                'subject_id' => $validated['subject_id'],
                'topic_id' => $validated['topic_id'] ?? null,
                'setter_organization_id' => $validated['setter_organization_id'] ?? null,
                'stem_bn' => $validated['stem_bn'],
                'stem_en' => $validated['stem_en'] ?? null,
                'difficulty' => $validated['difficulty'],
                'default_marks' => $validated['default_marks'],
                'negative_marks' => $validated['negative_marks'],
                'explanation_bn' => $validated['explanation_bn'] ?? null,
                'reference_source' => $validated['reference_source'] ?? null,
                'status' => 'published',
                'created_by' => Auth::id(),
                'verified_by' => Auth::id(),
            ]);

            $letters = ['A', 'B', 'C', 'D', 'E'];
            foreach ($validated['options'] as $index => $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_letter' => $letters[$index] ?? (string)($index + 1),
                    'option_text_bn' => $opt['text_bn'],
                    'option_text_en' => $opt['text_en'] ?? null,
                    'is_correct' => ($index == $validated['correct_option']),
                    'order' => $index + 1,
                ]);
            }

            if (!empty($validated['tags'])) {
                $tags = explode(',', $validated['tags']);
                foreach ($tags as $tag) {
                    $trimmed = trim($tag);
                    if ($trimmed) {
                        QuestionTag::create([
                            'question_id' => $question->id,
                            'tag_type' => 'pattern',
                            'tag_value' => $trimmed,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.questions.index')->with('success', 'প্রশ্ন সফলভাবে তৈরি করা হয়েছে!');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="targetofficer_question_template.csv"',
        ];

        $columns = [
            'subject_slug',
            'stem_bn',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'correct_option_letter',
            'difficulty',
            'explanation_bn',
            'reference_source',
            'setter_code',
            'tags',
        ];

        $sampleRow = [
            'bangla',
            'চর্যাপদ কোন ছন্দে রচিত?',
            'অক্ষরবৃত্ত',
            'মাত্রাবৃত্ত',
            'স্বরবৃত্ত',
            'পয়ার',
            'B',
            'medium',
            'চর্যাপদের পদগুলো মূলত মাত্রাবৃত্ত বা পাদাকুলক ছন্দে রচিত।',
            'লাল নীল দীপাবলি',
            'BPSC',
            '45th BCS,চর্যাপদ,বাংলা সাহিত্য',
        ];

        $callback = function () use ($columns, $sampleRow) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel Bangla support
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);
            fputcsv($file, $sampleRow);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');

        // Check BOM
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        $importedCount = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row[0]) || empty($row[1])) {
                    continue;
                }

                $subjectSlug = trim($row[0]);
                $stemBn = trim($row[1]);
                $optA = trim($row[2] ?? '');
                $optB = trim($row[3] ?? '');
                $optC = trim($row[4] ?? '');
                $optD = trim($row[5] ?? '');
                $correctLetter = strtoupper(trim($row[6] ?? 'A'));
                $difficulty = in_array(trim($row[7] ?? ''), ['easy', 'medium', 'hard']) ? trim($row[7]) : 'medium';
                $explanation = trim($row[8] ?? '');
                $ref = trim($row[9] ?? '');
                $setterCode = trim($row[10] ?? '');
                $tagsStr = trim($row[11] ?? '');

                $subject = Subject::where('slug', $subjectSlug)->first() ?? Subject::first();
                $setter = Organization::where('code', $setterCode)->first();

                $question = Question::create([
                    'subject_id' => $subject->id,
                    'setter_organization_id' => $setter?->id,
                    'stem_bn' => $stemBn,
                    'difficulty' => $difficulty,
                    'default_marks' => 1.00,
                    'negative_marks' => 0.50,
                    'explanation_bn' => $explanation,
                    'reference_source' => $ref,
                    'status' => 'published',
                    'created_by' => Auth::id(),
                ]);

                $opts = [
                    'A' => $optA,
                    'B' => $optB,
                    'C' => $optC,
                    'D' => $optD,
                ];

                $order = 1;
                foreach ($opts as $letter => $optText) {
                    if (!empty($optText)) {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'option_letter' => $letter,
                            'option_text_bn' => $optText,
                            'is_correct' => ($letter === $correctLetter),
                            'order' => $order++,
                        ]);
                    }
                }

                if (!empty($tagsStr)) {
                    $tags = explode(',', $tagsStr);
                    foreach ($tags as $tg) {
                        $t = trim($tg);
                        if ($t) {
                            QuestionTag::create([
                                'question_id' => $question->id,
                                'tag_type' => 'pattern',
                                'tag_value' => $t,
                            ]);
                        }
                    }
                }

                $importedCount++;
            }

            DB::commit();
            fclose($handle);

            return back()->with('success', "সফলভাবে {$importedCount} টি প্রশ্ন বাল্ক ইমপোর্ট করা হয়েছে!");
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->withErrors(['csv_file' => 'CSV ইমপোর্ট করার সময় ত্রুটি ঘটেছে: ' . $e->getMessage()]);
        }
    }
}
