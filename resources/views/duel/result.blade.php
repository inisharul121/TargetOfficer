@extends('layouts.student-layout')

@section('title', 'কুইজ ব্যাটেল ফলাফল – ' . $duel->duel_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header Banner --}}
    @php
        $isCompleted = $duel->status === 'completed';
        $isCreator = auth()->check() && $duel->creator_id === auth()->id();
        $isWinner = auth()->check() && $duel->winner_id === auth()->id();
        $shareUrl = route('battle.arena', $duel->duel_code);
        $shareText = "আমি TargetOfficer ১ বনাম ১ কুইজ ব্যাটেলে অংশ নিয়েছি! আমাকে চ্যালেঞ্জ করো: " . $shareUrl;
    @endphp

    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 text-white shadow-xl
                {{ $isWinner ? 'bg-gradient-to-br from-emerald-600 via-teal-700 to-indigo-900' : 'bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-800' }}">
        <div class="relative z-10 text-center space-y-3">
            @if($isCompleted)
                @if($isWinner)
                    <span class="inline-flex items-center space-x-1.5 px-3.5 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-300/30 text-xs font-black uppercase">
                        <span>🏆</span>
                        <span>অভিনন্দন! আপনি বিজয়ী হয়েছেন (+২৫ কয়েন অর্জিত)</span>
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black">বিজয় আপনার! 🎉</h1>
                @else
                    <span class="inline-flex items-center space-x-1.5 px-3.5 py-1 rounded-full bg-white/10 text-slate-200 border border-white/20 text-xs font-black uppercase">
                        <span>⚔️</span>
                        <span>কুইজ ব্যাটেল সমাপ্ত</span>
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black">দারুণ লড়াই হয়েছে! 🔥</h1>
                @endif
            @else
                <span class="inline-flex items-center space-x-1.5 px-3.5 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-300/30 text-xs font-black uppercase animate-pulse">
                    <span>⏳</span>
                    <span>প্রতিদ্বন্দ্বীর জন্য অপেক্ষমাণ</span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-black">আপনার উত্তর জমা হয়েছে!</h1>
                <p class="text-xs text-indigo-200 max-w-md mx-auto">
                    আপনার বন্ধু বা প্রতিদ্বন্দ্বী পরীক্ষা শেষ করলে স্বয়ংক্রিয়ভাবে বিজয়ী নির্ধারিত হবে। লিংকটি শেয়ার করুন।
                </p>
            @endif

            {{-- Face to Face Score Comparison --}}
            <div class="pt-6 max-w-lg mx-auto grid grid-cols-2 gap-4">
                {{-- Creator --}}
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-center">
                    <span class="text-[10px] uppercase font-bold text-indigo-200 block truncate">{{ $duel->creator->name }}</span>
                    <div class="text-2xl font-black mt-1">{{ $duel->creator_completed_at ? $duel->creator_score : '...' }}</div>
                    <span class="text-[10px] text-indigo-200 font-semibold">
                        {{ $duel->creator_completed_at ? $duel->creator_time_seconds . ' সেকেন্ড' : 'অপেক্ষমাণ' }}
                    </span>
                </div>

                {{-- Opponent --}}
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-center">
                    <span class="text-[10px] uppercase font-bold text-indigo-200 block truncate">{{ $duel->opponent->name ?? 'প্রতিদ্বন্দ্বী' }}</span>
                    <div class="text-2xl font-black mt-1">{{ $duel->opponent_completed_at ? $duel->opponent_score : '...' }}</div>
                    <span class="text-[10px] text-indigo-200 font-semibold">
                        {{ $duel->opponent_completed_at ? $duel->opponent_time_seconds . ' সেকেন্ড' : 'অপেক্ষমাণ' }}
                    </span>
                </div>
            </div>

            {{-- Share Button --}}
            <div class="pt-4 flex items-center justify-center space-x-3">
                <a href="https://wa.me/?text={{ urlencode($shareText) }}"
                   target="_blank"
                   class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                    <span>💬</span>
                    <span>WhatsApp-এ শেয়ার করুন</span>
                </a>
                <a href="{{ route('battle.index') }}"
                   class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs transition">
                    নতুন ব্যাটেল
                </a>
            </div>
        </div>
    </div>

    {{-- Questions & Correct Answer Review --}}
    <div class="space-y-4">
        <h2 class="text-base font-black text-slate-900 dark:text-white">ব্যাটেলের ১০টি প্রশ্নের সঠিক উত্তর</h2>

        @foreach($questions as $index => $q)
            @php
                $correctOpt = $q->options->firstWhere('is_correct', true);
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                <div class="flex items-start space-x-3">
                    <span class="w-6 h-6 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 font-black text-xs flex items-center justify-center shrink-0">
                        {{ $index + 1 }}
                    </span>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $q->stem_bn }}</h3>
                </div>

                <div class="p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-xs">
                    <strong class="text-emerald-800 dark:text-emerald-300">সঠিক উত্তর:</strong>
                    <span class="text-emerald-900 dark:text-emerald-200 font-semibold ml-1">
                        {{ $correctOpt ? $correctOpt->option_text_bn : 'নির্ধারিত নয়' }}
                    </span>
                </div>

                @if($q->explanation_bn)
                    <div class="text-xs text-slate-600 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/60 p-3 rounded-2xl border border-slate-100 dark:border-slate-800 leading-relaxed">
                        {!! $q->explanation_bn !!}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

@if($isWinner)
@push('scripts')
<script>
    if (typeof confetti === 'function') {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    }
</script>
@endpush
@endif
@endsection
