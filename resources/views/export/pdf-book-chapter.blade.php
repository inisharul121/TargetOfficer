<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $chapter->title_bn }} | {{ $book->title_bn }} – TargetOfficer ই-বুক</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .written-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.9rem;
        }
        .written-content th, .written-content td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            text-align: left;
        }
        .written-content th {
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .written-content ul, .written-content ol {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .written-content ul {
            list-style-type: disc;
        }
        .written-content ol {
            list-style-type: decimal;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .page-break-avoid {
                break-inside: avoid;
                page-break-inside: avoid;
            }
            .page-break-before {
                break-before: page;
                page-break-before: always;
            }
            @page {
                size: A4;
                margin: 12mm 15mm;
            }
            .paper-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="p-3 sm:p-8">

    {{-- Top Action Bar (No Print) --}}
    <div class="no-print max-w-5xl mx-auto mb-6 p-4 rounded-2xl bg-white shadow-md border border-slate-200 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <button onclick="window.history.back()" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:bg-slate-100 text-xs font-bold text-slate-700 transition">
                ← রিডারে ফিরে যান
            </button>
            <div class="text-xs font-bold text-slate-500">
                অধ্যায় প্রিন্ট ও অফলাইন স্টাডি শীট
            </div>
        </div>

        <div class="flex items-center space-x-2">
            {{-- Mode Switcher --}}
            <div class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-bold">
                <a href="?mode=all"
                   class="px-3 py-1.5 rounded-lg transition {{ $mode === 'all' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600' }}">
                    📚 সম্পূর্ণ অধ্যায় (MCQ + লিখিত)
                </a>
                <a href="?mode=mcq"
                   class="px-3 py-1.5 rounded-lg transition {{ $mode === 'mcq' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600' }}">
                    🎯 শুধু প্রিলিমিনারি (MCQ)
                </a>
                <a href="?mode=written"
                   class="px-3 py-1.5 rounded-lg transition {{ $mode === 'written' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600' }}">
                    ✍️ শুধু লিখিত মডেল উত্তর
                </a>
            </div>

            <button onclick="window.print()"
                    class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md transition flex items-center space-x-1.5">
                <span>🖨️</span>
                <span>প্রিন্ট / PDF সংরক্ষণ</span>
            </button>
        </div>
    </div>

    {{-- Printable Paper Sheet --}}
    <div class="paper-container max-w-5xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-200">
        
        {{-- Header --}}
        <div class="text-center border-b-2 border-slate-800 pb-5 mb-6 space-y-1">
            <div class="inline-flex items-center space-x-2 mb-1">
                <div class="w-7 h-7 rounded-lg bg-slate-900 text-white font-black text-sm flex items-center justify-center">T</div>
                <span class="font-black text-lg tracking-tight">Target<span class="text-indigo-600">Officer</span> <span class="text-xs uppercase bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-bold border border-slate-200">Digital Book Series</span></span>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $book->title_bn }}</h1>
            <p class="text-sm font-bold text-indigo-700">{{ $book->title_en }} • {{ $book->target_exam }}</p>
            
            <div class="mt-3 inline-block bg-slate-100 px-4 py-1.5 rounded-full border border-slate-300">
                <span class="text-sm font-black text-slate-800">
                    অধ্যায় {{ $chapter->chapter_number }}: {{ $chapter->title_bn }}
                </span>
                @if($chapter->title_en)
                    <span class="text-xs text-slate-500 ml-1 font-medium">({{ $chapter->title_en }})</span>
                @endif
            </div>

            <div class="flex items-center justify-center space-x-6 text-xs font-bold text-slate-600 pt-3 border-t border-slate-200 mt-3">
                <span>বিষয়: {{ $book->subject ? $book->subject->name_bn : 'সাধারণ জ্ঞান' }}</span>
                <span>•</span>
                <span>প্রিলিমিনারি প্রশ্ন: {{ $questions->count() }}টি</span>
                <span>•</span>
                <span>লিখিত মডেল প্রশ্ন: {{ $writtenContents->count() }}টি</span>
                <span>•</span>
                <span>সংস্করণ: BCS Master Edition</span>
            </div>
        </div>

        {{-- SECTION 1: MCQ QUESTIONS --}}
        @if($mode === 'all' || $mode === 'mcq')
            <div class="mb-10">
                <div class="flex items-center space-x-2 border-b-2 border-indigo-600 pb-2 mb-6">
                    <span class="text-lg">🎯</span>
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-wide">
                        পর্ব ১: প্রিলিমিনারি বহুনির্বাচনী প্রশ্ন ও ব্যাখ্যা (MCQs)
                    </h2>
                    <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-2 py-0.5 rounded ml-auto">
                        {{ $questions->count() }} টি প্রশ্ন
                    </span>
                </div>

                @if($questions->isEmpty())
                    <p class="text-center py-6 text-slate-400 text-sm font-semibold">এই অধ্যায়ে কোনো প্রিলিমিনারি MCQ সংযুক্ত নেই।</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($questions as $idx => $q)
                            <div class="page-break-avoid p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <div class="font-bold text-slate-900 text-sm leading-snug">
                                            <span class="text-indigo-600 font-black mr-1">{{ $idx + 1 }}.</span>
                                            {{ $q->question_text }}
                                        </div>
                                    </div>

                                    {{-- Source tags --}}
                                    @if($q->tags && $q->tags->count() > 0)
                                        <div class="flex flex-wrap gap-1 mb-2.5">
                                            @foreach($q->tags as $tag)
                                                <span class="text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 px-1.5 py-0.2 rounded">
                                                    🏛️ {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Options --}}
                                    <div class="space-y-1.5 text-xs">
                                        @foreach($q->options as $opt)
                                            <div class="flex items-start space-x-2 px-2 py-1 rounded {{ $opt->is_correct ? 'bg-emerald-100 text-emerald-950 font-bold border border-emerald-300' : 'text-slate-700' }}">
                                                <span class="w-4 text-center font-bold text-slate-500">{{ $opt->option_label }}.</span>
                                                <span class="flex-1">{{ $opt->option_text }}</span>
                                                @if($opt->is_correct)
                                                    <span class="text-emerald-700 font-black text-[11px]">✓ সঠিক</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Explanation --}}
                                @if($q->explanation)
                                    <div class="mt-3 pt-2 border-t border-slate-200 text-xs text-slate-700 bg-white p-2 rounded-lg border border-slate-100">
                                        <span class="font-bold text-indigo-700">💡 ব্যাখ্যা:</span>
                                        <div class="mt-0.5 leading-relaxed text-slate-600 text-[11px]">
                                            {{ $q->explanation }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- SECTION 2: WRITTEN MATERIALS --}}
        @if($mode === 'all' || $mode === 'written')
            <div class="{{ $mode === 'all' ? 'page-break-before mt-8' : '' }} mb-8">
                <div class="flex items-center space-x-2 border-b-2 border-purple-600 pb-2 mb-6">
                    <span class="text-lg">✍️</span>
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-wide">
                        পর্ব ২: বিসিএস লিখিত মডেল উত্তর ও থিওরি (Written Material)
                    </h2>
                    <span class="text-xs bg-purple-50 text-purple-700 font-bold px-2 py-0.5 rounded ml-auto">
                        {{ $writtenContents->count() }} টি মডেল প্রশ্ন/বিষয়
                    </span>
                </div>

                @if($writtenContents->isEmpty())
                    <p class="text-center py-6 text-slate-400 text-sm font-semibold">এই অধ্যায়ে কোনো লিখিত মডেল উত্তর অন্তর্ভুক্ত নেই।</p>
                @else
                    <div class="space-y-6">
                        @foreach($writtenContents as $wIdx => $wc)
                            <div class="page-break-avoid p-6 rounded-2xl border border-slate-300 bg-white shadow-xs">
                                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 pb-3 mb-3">
                                    <div class="flex items-center space-x-2">
                                        <span class="w-6 h-6 rounded-full bg-purple-600 text-white font-black text-xs flex items-center justify-center">
                                            {{ $wIdx + 1 }}
                                        </span>
                                        <span class="text-xs font-black uppercase text-purple-700 tracking-wider">
                                            @if($wc->content_type === 'model_question')
                                                মডেল প্রশ্ন ও স্ট্যান্ডার্ড সমাধান
                                            @elseif($wc->content_type === 'essay_outline')
                                                রচনামূলক কাঠামো ও তথ্য
                                            @elseif($wc->content_type === 'rule_sheet')
                                                নিয়মাবলী ও সূত্রতালিকা
                                            @else
                                                সংক্ষিপ্ত নোট
                                            @endif
                                        </span>
                                    </div>

                                    <div class="flex items-center space-x-2 text-xs font-bold">
                                        @if($wc->marks)
                                            <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded font-mono">
                                                মান: {{ $wc->marks }} নম্বর
                                            </span>
                                        @endif
                                        @if($wc->exam_year_reference)
                                            <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded">
                                                🏛️ {{ $wc->exam_year_reference }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <h3 class="text-base font-black text-slate-900 mb-3 leading-snug">
                                    {{ $wc->title_bn }}
                                </h3>

                                <div class="written-content text-slate-800 leading-relaxed text-sm bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    {!! $wc->content_bn !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- Footer --}}
        <div class="mt-12 pt-4 border-t border-slate-300 text-center text-xs text-slate-500 space-y-1">
            <p class="font-bold text-slate-700">TargetOfficer Digital Book System • সর্বস্বত্ব সংরক্ষিত</p>
            <p class="text-[11px] text-slate-400">অনলাইন অনুশীলনের জন্য ভিজিট করুন: targetofficer.com</p>
        </div>

    </div>

</body>
</html>
