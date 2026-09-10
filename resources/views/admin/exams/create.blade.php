@extends('layouts.dashboard-layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900">নতুন মডেল টেস্ট / পরীক্ষা তৈরি</h1>
                <p class="text-xs text-slate-500">পরীক্ষার নাম, সময়, নেগেটিভ মার্কিং ও শিডিউল নির্ধারণ করুন</p>
            </div>
            <a href="{{ route('admin.exams.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">← তালিকায় ফিরুন</a>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm" x-data="{ mode: 'timed_mock' }">
            <form action="{{ route('admin.exams.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Mode & Title -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">পরীক্ষার ধরন (Exam Mode)</label>
                        <select name="exam_mode" x-model="mode" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white font-semibold">
                            <option value="timed_mock">টাইমড মডেল টেস্ট (Timed Standard Simulation)</option>
                            <option value="live_model_test">লাইভ শিডিউলড মডেল টেস্ট (Synchronized Live Exam)</option>
                            <option value="practice">অনুশীলন মোড (Untimed Practice with Explanations)</option>
                            <option value="previous_year">বিগত বছরের প্রশ্নপত্র (Archive Paper)</option>
                            <option value="daily_quiz">ডেইলি স্পিড কুইজ (Micro-Quiz)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">পরীক্ষার শিরোনাম (বাংলায়) *</label>
                            <input type="text" name="title_bn" required placeholder="যেমন: ৪৭তম বিসিএস স্পেশাল মডেল টেস্ট - ০২" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">পরীক্ষার শিরোনাম (ইংরেজিতে)</label>
                            <input type="text" name="title_en" placeholder="e.g. 47th BCS Special Model Test - 02" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium">
                        </div>
                    </div>
                </div>

                <!-- Organization & Exam Types -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সংস্থা / প্রশ্নকর্তা সংস্থা</label>
                        <select name="organization_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="">সাধারণ / বিপিএসসি</option>
                            @foreach($organizations as $org)
                                <option value="{{ $org->id }}">{{ $org->name_bn ?? $org->name_en }} ({{ $org->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">পরীক্ষার ক্যাটাগরি</label>
                        <select name="exam_type_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="">নির্বাচন করুন...</option>
                            @foreach($examTypes as $et)
                                <option value="{{ $et->id }}">{{ $et->name_bn ?? $et->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সংস্করণ / সাল</label>
                        <select name="exam_year_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="">নির্বাচন করুন...</option>
                            @foreach($examYears as $ey)
                                <option value="{{ $ey->id }}">{{ $ey->name_bn ?? $ey->name_en }} ({{ $ey->year }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Timers & Marks Rules -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সময়সীমা (মিনিটে, ০ = আনলিমিটেড)</label>
                        <input type="number" name="duration_minutes" value="60" min="0" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">পাস মার্কস শতকরা (%)</label>
                        <input type="number" step="0.5" name="pass_percentage" value="40" min="0" max="100" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">নেগেটিভ মার্ক কর্তন (প্রতি ভুল উত্তরের জন্য)</label>
                        <input type="number" step="0.05" name="negative_mark_per_question" value="0.50" min="0" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                    </div>
                </div>

                <!-- Live Test Scheduling (Visible if live_model_test) -->
                <div x-show="mode === 'live_model_test'" class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200 space-y-3" x-transition>
                    <div class="text-xs font-bold text-rose-800">লাইভ পরীক্ষার শিডিউল (Synchronized Live Window)</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">শুরুর তারিখ ও সময়</label>
                            <input type="datetime-local" name="scheduled_start_at" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">সমাপ্তির তারিখ ও সময়</label>
                            <input type="datetime-local" name="scheduled_end_at" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">পরীক্ষার বিবরণ ও নির্দেশনা (বাংলায়)</label>
                    <textarea name="description_bn" rows="2" placeholder="মডেল টেস্ট সংক্রান্ত প্রয়োজনীয় নির্দেশনা..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></textarea>
                </div>

                <!-- Options Checkboxes -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs font-medium">
                    <label class="flex items-center space-x-2 p-2.5 rounded-xl border border-slate-100 bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" checked class="rounded text-indigo-600">
                        <span class="font-bold text-slate-700">প্রকাশিত (Live)</span>
                    </label>
                    <label class="flex items-center space-x-2 p-2.5 rounded-xl border border-slate-100 bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="shuffle_questions" value="1" checked class="rounded text-indigo-600">
                        <span class="text-slate-700">প্রশ্ন শাফল করুন</span>
                    </label>
                    <label class="flex items-center space-x-2 p-2.5 rounded-xl border border-slate-100 bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="shuffle_options" value="1" checked class="rounded text-indigo-600">
                        <span class="text-slate-700">অপশন শাফল করুন</span>
                    </label>
                    <label class="flex items-center space-x-2 p-2.5 rounded-xl border border-slate-100 bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="show_instant_result" value="1" checked class="rounded text-indigo-600">
                        <span class="text-slate-700">তাৎক্ষণিক রেজাল্ট</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.exams.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">
                        সংরক্ষণ করুন ও প্রশ্ন যোগ করুন →
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
