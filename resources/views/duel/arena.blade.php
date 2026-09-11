@extends('layouts.student-layout')

@section('title', 'কুইজ ব্যাটেল এরিনা – ' . $duel->duel_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="battleArena()">
    {{-- Top Battle Bar --}}
    <div class="bg-gradient-to-r from-orange-600 via-amber-600 to-rose-600 rounded-3xl p-5 text-white shadow-lg flex items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-xs flex items-center justify-center font-black text-xl">
                ⚔️
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-orange-200">ব্যাটেল কোড: {{ $duel->duel_code }}</span>
                    <span class="px-2 py-0.2 text-[9px] font-black uppercase rounded bg-white/20">১০ প্রশ্ন</span>
                </div>
                <h1 class="text-base font-black">{{ $duel->creator->name }} vs {{ $duel->opponent->name ?? 'প্রতিদ্বন্দ্বী' }}</h1>
            </div>
        </div>

        {{-- Countdown Timer --}}
        <div class="bg-black/30 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20 flex items-center space-x-2">
            <svg class="w-4 h-4 text-amber-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-mono font-black text-base text-amber-300" x-text="formatTime(timeLeft)">05:00</span>
        </div>
    </div>

    {{-- Questions Form --}}
    <form id="battleForm" action="{{ route('battle.submit', $duel->duel_code) }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="time_taken_seconds" :value="300 - timeLeft">

        @foreach($questions as $index => $q)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start space-x-3">
                        <span class="w-7 h-7 rounded-xl bg-orange-50 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 font-black text-xs flex items-center justify-center shrink-0 mt-0.5">
                            {{ $index + 1 }}
                        </span>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white leading-relaxed">
                            {{ $q->stem_bn }}
                        </h2>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 shrink-0 uppercase">১.০০ নম্বর</span>
                </div>

                {{-- Options Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2">
                    @foreach($q->options as $optIndex => $opt)
                        @php
                            $labels = ['ক', 'খ', 'গ', 'ঘ'];
                            $label = $labels[$optIndex] ?? ($optIndex + 1);
                        @endphp
                        <label class="flex items-center space-x-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 hover:border-orange-400 dark:hover:border-orange-500 cursor-pointer transition has-checked:bg-orange-50 has-checked:border-orange-500 dark:has-checked:bg-orange-950/40 dark:has-checked:border-orange-500">
                            <input type="radio"
                                   name="answers[{{ $q->id }}]"
                                   value="{{ $opt->id }}"
                                   @change="answeredCount++"
                                   class="text-orange-600 focus:ring-orange-500 shrink-0">
                            <span class="w-5 h-5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $label }}
                            </span>
                            <span class="text-xs font-semibold text-slate-800 dark:text-slate-200">
                                {{ $opt->option_text_bn }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="sticky bottom-4 z-20 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200 dark:border-slate-800 shadow-xl flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500">
                ১০টির মধ্যে উত্তর দিচ্ছেন...
            </span>

            <button type="submit"
                    class="px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-black text-xs shadow-md shadow-orange-600/20 transition flex items-center space-x-2">
                <span>🔥</span>
                <span>উত্তরপত্র জমা দিন</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function battleArena() {
    return {
        timeLeft: 300,
        answeredCount: 0,
        timer: null,
        init() {
            this.timer = setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                } else {
                    clearInterval(this.timer);
                    document.getElementById('battleForm').submit();
                }
            }, 1000);
        },
        formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }
    };
}
</script>
@endpush
@endsection
