<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $chapter->title_bn }} | {{ $book->title_bn }} – TargetOfficer ই-বুক</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

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
                অধ্যায় প্রিন্ট ও অফলাইন স্টাডি শীট
            </div>
        </div>

        <button onclick="window.print()"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md transition flex items-center space-x-1.5">
            <span>🖨️</span>
            <span>প্রিন্ট / PDF সংরক্ষণ</span>
        </button>
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
                <span>মোট পাঠ ও টপিক: {{ $writtenContents->count() }}টি</span>
                <span>•</span>
                <span>সংস্করণ: BCS Master Edition (Textbook)</span>
            </div>
        </div>

        {{-- Chapter Summary --}}
        @if($chapter->summary_bn)
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 mb-6 text-xs leading-relaxed text-slate-600 italic">
                <strong>অধ্যায় সারসংক্ষেপ:</strong> {{ $chapter->summary_bn }}
            </div>
        @endif

        {{-- TEXT SECTIONS & ARTICLES --}}
        <div class="space-y-6">
            @foreach($writtenContents as $wIdx => $wc)
                <div class="page-break-avoid p-6 rounded-2xl border border-slate-300 bg-white shadow-xs">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 pb-3 mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-indigo-600 text-white font-black text-xs flex items-center justify-center">
                                {{ $wIdx + 1 }}
                            </span>
                            <span class="text-xs font-black uppercase text-indigo-700 tracking-wider">
                                @if($wc->content_type === 'written_question_solution')
                                    মডেল প্রশ্নোত্তর ও সমাধান
                                @elseif($wc->content_type === 'theory_and_rules')
                                    থিওরি ও নিয়মাবলী
                                @else
                                    বিশদ পাঠ্য বিষয়
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 text-xs font-bold">
                            @if($wc->marks)
                                <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded font-mono">
                                    মান: {{ (int)$wc->marks }} নম্বর
                                </span>
                            @endif
                            @if($wc->bcs_reference)
                                <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded">
                                    🏛️ {{ $wc->bcs_reference }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <h2 class="text-base font-black text-slate-900 mb-3 leading-snug">
                        {{ $wc->title_bn }}
                    </h2>

                    @if($wc->question_bn)
                        <div class="p-3 mb-3 rounded-lg bg-slate-100 border border-slate-200 text-xs font-bold text-slate-800">
                            <span class="text-indigo-600 font-bold block mb-0.5">বিসিএস লিখিত প্রশ্ন:</span>
                            {{ $wc->question_bn }}
                        </div>
                    @endif

                    <div class="written-content text-slate-800 leading-relaxed text-sm bg-slate-50 p-4 rounded-xl border border-slate-200">
                        {!! $wc->content_bn !!}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="mt-12 pt-4 border-t border-slate-300 text-center text-xs text-slate-500 space-y-1">
            <p class="font-bold text-slate-700">TargetOfficer Digital Book System • সর্বস্বত্ব সংরক্ষিত</p>
            <p class="text-[11px] text-slate-400">অনলাইন অনুশীলনের জন্য ভিজিট করুন: targetofficer.com</p>
        </div>

    </div>

</body>
</html>
