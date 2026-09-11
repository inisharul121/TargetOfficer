<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} – TargetOfficer PDF</title>

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
<body class="p-4 sm:p-8">

    {{-- Top Action Bar (No Print) --}}
    <div class="no-print max-w-5xl mx-auto mb-6 p-4 rounded-2xl bg-white shadow-md border border-slate-200 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <button onclick="window.history.back()" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:bg-slate-100 text-xs font-bold text-slate-700 transition">
                ← ফিরে যান
            </button>
            <div class="text-xs font-bold text-slate-500">
                মুদ্রণ / PDF এক্সপোর্ট ভিউ
            </div>
        </div>

        <div class="flex items-center space-x-2">
            {{-- Mode Switcher --}}
            <div class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-bold">
                <a href="?mode=questions"
                   class="px-3 py-1.5 rounded-lg transition {{ $mode === 'questions' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600' }}">
                    📝 শুধু প্রশ্নপত্র
                </a>
                <a href="?mode=solutions"
                   class="px-3 py-1.5 rounded-lg transition {{ $mode === 'solutions' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-600' }}">
                    💡 প্রশ্ন ও পূর্ণ সমাধান
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
        {{-- Exam Header --}}
        <div class="text-center border-b-2 border-slate-800 pb-5 mb-6 space-y-1">
            <div class="inline-flex items-center space-x-2 mb-1">
                <div class="w-7 h-7 rounded-lg bg-slate-900 text-white font-black text-sm flex items-center justify-center">T</div>
                <span class="font-black text-lg tracking-tight">Target<span class="text-indigo-600">Officer</span></span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">{{ $title }}</h1>
            
            <div class="flex items-center justify-center space-x-6 text-xs font-bold text-slate-700 pt-2 border-t border-slate-200 mt-2">
                <span>মোট প্রশ্ন: {{ $questions->count() }}টি</span>
                <span>•</span>
                <span>পূর্ণমান: {{ (int)$totalMarks }}</span>
                <span>•</span>
                <span>সময়: {{ $durationMinutes }} মিনিট</span>
                <span>•</span>
                <span>নেগেটিভ মার্কিং: ০.৫০</span>
            </div>

            <p class="text-[11px] text-slate-500 italic pt-1">
                [বিশেষ নির্দেশনাবলী: প্রতিটি সঠিক উত্তরের জন্য ১.০০ নম্বর এবং প্রতিটি ভুল উত্তরের জন্য ০.৫০ নম্বর কাটা যাবে।]
            </p>
        </div>

        {{-- 2-Column Question Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            @foreach($questions as $index => $q)
                @php
                    $correctOpt = $q->options->firstWhere('is_correct', true);
                @endphp
                <div class="page-break-avoid border-b border-slate-100 pb-4 text-xs space-y-2">
                    {{-- Question Stem --}}
                    <div class="flex items-start space-x-2">
                        <span class="font-black text-slate-900 shrink-0">{{ $index + 1 }}.</span>
                        <div class="font-bold text-slate-900 leading-snug">
                            {{ $q->stem_bn }}
                        </div>
                    </div>

                    {{-- Options 2x2 Grid --}}
                    <div class="grid grid-cols-2 gap-x-3 gap-y-1 pl-5 text-slate-700">
                        @foreach($q->options as $optIdx => $opt)
                            @php
                                $label = ['(ক)', '(খ)', '(গ)', '(ঘ)'][$optIdx] ?? ('(' . ($optIdx + 1) . ')');
                                $isThisCorrect = $mode === 'solutions' && $opt->is_correct;
                            @endphp
                            <div class="flex items-center space-x-1.5 {{ $isThisCorrect ? 'font-black text-emerald-800' : '' }}">
                                <span class="text-slate-400 font-bold {{ $isThisCorrect ? 'text-emerald-700' : '' }}">{{ $label }}</span>
                                <span>{{ $opt->option_text_bn }}</span>
                                @if($isThisCorrect)
                                    <span class="text-[10px] text-emerald-600 font-black">✓</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Solution & Explanation if in solutions mode --}}
                    @if($mode === 'solutions')
                        <div class="mt-2 pl-5 pt-2 border-t border-slate-100 text-[11px] text-slate-600 bg-slate-50 p-2.5 rounded-xl space-y-1 leading-relaxed">
                            <div>
                                <strong class="text-emerald-700">সঠিক উত্তর:</strong>
                                <span class="font-semibold">{{ $correctOpt ? $correctOpt->option_text_bn : '-' }}</span>
                            </div>
                            @if($q->explanation_bn)
                                <div class="text-slate-600">
                                    {!! $q->explanation_bn !!}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Paper Footer --}}
        <div class="mt-8 pt-4 border-t-2 border-slate-800 text-center text-[10px] text-slate-500 flex items-center justify-between">
            <span>TargetOfficer — Precision Preparation for Public Service</span>
            <span>https://targetofficer.com</span>
            <span>পৃষ্ঠা ১</span>
        </div>
    </div>

</body>
</html>
