<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamType;
use App\Models\ExamYear;
use App\Models\Organization;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTaxonomyController extends Controller
{
    public function index()
    {
        $subjects = Subject::with(['topics'])->withCount('questions')->orderBy('order')->get();
        $organizations = Organization::withCount(['exams'])->orderBy('name_en')->get();
        $examTypes = ExamType::with('organization')->get();
        $examYears = ExamYear::latest()->get();

        return view('admin.taxonomies.index', compact('subjects', 'organizations', 'examTypes', 'examYears'));
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'color' => 'required|string|max:30',
            'icon' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($validated['name_en']);
        if (Subject::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        Subject::create([
            'name_bn' => $validated['name_bn'],
            'name_en' => $validated['name_en'],
            'slug' => $slug,
            'color' => $validated['color'],
            'icon' => $validated['icon'] ?? 'book-open',
            'order' => Subject::count() + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'নতুন বিষয় সফলভাবে তৈরি করা হয়েছে!');
    }

    public function storeTopic(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $slug = Str::slug($validated['name_en']);
        if (Topic::where('subject_id', $validated['subject_id'])->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        Topic::create([
            'subject_id' => $validated['subject_id'],
            'name_bn' => $validated['name_bn'],
            'name_en' => $validated['name_en'],
            'slug' => $slug,
            'order' => Topic::where('subject_id', $validated['subject_id'])->count() + 1,
        ]);

        return back()->with('success', 'নতুন টপিক সফলভাবে তৈরি করা হয়েছে!');
    }

    public function storeOrganization(Request $request)
    {
        $validated = $request->validate([
            'name_bn' => 'nullable|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:20',
            'is_question_setter' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['name_en']);
        if (Organization::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        Organization::create([
            'name_bn' => $validated['name_bn'] ?? null,
            'name_en' => $validated['name_en'],
            'slug' => $slug,
            'code' => strtoupper($validated['code']),
            'is_question_setter' => $request->boolean('is_question_setter', true),
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'নতুন সংস্থা / প্রশ্নকর্তা সফলভাবে সংরক্ষণ করা হয়েছে!');
    }

    public function storeExamType(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'nullable|exists:organizations,id',
            'name_bn' => 'nullable|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $slug = Str::slug($validated['name_en']);
        if (ExamType::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        ExamType::create([
            'organization_id' => $validated['organization_id'] ?? null,
            'name_bn' => $validated['name_bn'] ?? null,
            'name_en' => $validated['name_en'],
            'slug' => $slug,
        ]);

        return back()->with('success', 'পরীক্ষার ধরন সফলভাবে তৈরি করা হয়েছে!');
    }

    public function storeExamYear(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:20',
            'name_bn' => 'nullable|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        ExamYear::create([
            'year' => $validated['year'],
            'name_bn' => $validated['name_bn'] ?? null,
            'name_en' => $validated['name_en'],
        ]);

        return back()->with('success', 'পরীক্ষার সাল/সংস্করণ সফলভাবে তৈরি করা হয়েছে!');
    }
}
