<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = QuestionReport::with(['question.options', 'question.subject', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        if ($request->filled('type')) {
            $query->where('report_type', $request->type);
        }

        $reports = $query->latest()->paginate(15)->withQueryString();
        $pendingCount = QuestionReport::where('status', 'pending')->count();
        $resolvedCount = QuestionReport::where('status', 'resolved')->count();
        $rejectedCount = QuestionReport::where('status', 'rejected')->count();

        return view('admin.reports.index', compact('reports', 'pendingCount', 'resolvedCount', 'rejectedCount'));
    }

    public function updateStatus(Request $request, QuestionReport $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,rejected',
        ]);

        $report->update(['status' => $validated['status']]);

        return back()->with('success', 'রিপোর্টের স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!');
    }

    public function destroy(QuestionReport $report)
    {
        $report->delete();
        return back()->with('success', 'রিপোর্টটি মুছে ফেলা হয়েছে।');
    }
}
