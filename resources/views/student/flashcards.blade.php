@extends('layouts.student-layout')

@section('title', __t('স্মার্ট ফ্ল্যাশ কার্ড ও স্পেসড রিপিটেশন – TargetOfficer', 'Smart Flashcards – TargetOfficer'))

@push('styles')
<style>
.perspective-1000 {
    perspective: 1000px;
}
.transform-style-3d {
    transform-style: preserve-3d;
}
.backface-hidden {
    backface-visibility: hidden;
}
.rotate-y-180 {
    transform: rotateY(180deg);
}
</style>
@endpush

@section('content')
<div class="space-y-6 max-w-5xl mx-auto" x-data="flashcardDeck()">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-900 via-indigo-900 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-purple-500/20 border border-purple-500/30 text-purple-300 text-xs font-black uppercase tracking-wider">
                    <span>🧠</span>
                    <span>{{ __t('স্মার্ট ফ্ল্যাশ কার্ড ও মুখস্থ হাব', 'High-Yield Retention Engine') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ __t('স্পেসড রিপিটেশনে দ্রুত মুখস্থ করুন', 'Master Facts with Spaced Repetition') }}
                </h1>
                <p class="text-sm text-purple-200/90 leading-relaxed">
                    {{ __t('সংবিধানের অনুচ্ছেদ, গুরুত্বপূর্ণ ভোকাবুলারি ও ঐতিহাসিক ঘটনাবলী ফ্ল্যাশ কার্ডের মাধ্যমে স্থায়ী স্মৃতিতে রূপান্তর করুন। কার্ডে ক্লিক করে উত্তর দেখুন।', 'Flip cards to test recall, mark cards as mastered, and earn +2 coins per mastery.') }}
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 text-center min-w-[200px] shrink-0">
                <span class="text-[10px] font-black uppercase tracking-wider text-purple-200 block mb-1">ডেক অগ্রগতি</span>
                <div class="text-3xl font-black text-amber-300" x-text="masteredCount + ' / ' + cards.length">{{ $masteredCount }} / {{ $totalCards }}</div>
                <div class="w-full bg-white/20 rounded-full h-2 mt-2.5 overflow-hidden">
                    <div class="bg-amber-400 h-full rounded-full transition-all duration-300" :style="'width: ' + progressRate + '%'"></div>
                </div>
                <span class="text-[11px] text-purple-200 mt-2 block font-semibold" x-text="progressRate + '% মুখস্থ সম্পন্ন'">{{ $progressPercentage }}% মুখস্থ সম্পন্ন</span>
            </div>
        </div>
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>
    </div>

    {{-- Category Tabs --}}
    <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
        @foreach($categories as $key => $cat)
            <a href="{{ route('flashcards.index', ['category' => $key]) }}"
               class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition flex items-center space-x-2 border
                      {{ $currentCategory === $key
                         ? 'bg-purple-600 text-white border-purple-600 shadow-md shadow-purple-600/20'
                         : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-purple-300' }}">
                <span>{{ $cat['icon'] }}</span>
                <span>{{ $cat['name_bn'] }}</span>
            </a>
        @endforeach
    </div>

    @if($cards->isEmpty())
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
            <p class="text-slate-400 text-sm font-semibold">এই ক্যাটাগরিতে এখনও কোনো ফ্ল্যাশ কার্ড যুক্ত করা হয়নি।</p>
        </div>
    @else
        {{-- Interactive 3D Card --}}
        <div class="max-w-2xl mx-auto space-y-6">
            <div class="perspective-1000 w-full min-h-[320px] sm:min-h-[360px] cursor-pointer select-none"
                 @click="isFlipped = !isFlipped">
                <div class="relative w-full h-full min-h-[320px] sm:min-h-[360px] transition-transform duration-500 transform-style-3d rounded-3xl shadow-xl"
                     :class="isFlipped ? 'rotate-y-180' : ''">

                    {{-- FRONT SIDE (Question / Term) --}}
                    <div class="absolute inset-0 w-full h-full bg-white dark:bg-slate-900 border-2 border-purple-200 dark:border-purple-900/60 rounded-3xl p-8 flex flex-col justify-between backface-hidden">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300">
                                প্রশ্ন / টার্ম • কার্ড <span x-text="currentIndex + 1"></span> / <span x-text="cards.length"></span>
                            </span>
                            <template x-if="currentCard.user_mastered">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                    ✓ মুখস্থ
                                </span>
                            </template>
                        </div>

                        <div class="text-center py-6">
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white leading-relaxed"
                                x-text="currentCard.front_bn"></h2>
                            <template x-if="currentCard.front_en">
                                <p class="text-xs font-semibold text-slate-400 mt-2" x-text="currentCard.front_en"></p>
                            </template>
                            <template x-if="currentCard.source_tag">
                                <span class="inline-block mt-4 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400"
                                      x-text="currentCard.source_tag"></span>
                            </template>
                        </div>

                        <div class="text-center text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center justify-center space-x-1">
                            <span>🔄</span>
                            <span>উত্তর দেখতে কার্ডে ক্লিক করুন</span>
                        </div>
                    </div>

                    {{-- BACK SIDE (Answer / Explanation) --}}
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 text-white rounded-3xl p-8 flex flex-col justify-between backface-hidden rotate-y-180 border-2 border-indigo-500/40 shadow-2xl">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 text-white">
                                সঠিক উত্তর ও ব্যাখ্যা
                            </span>
                            <span class="text-xs text-indigo-300 font-semibold" x-text="currentCard.source_tag || ''"></span>
                        </div>

                        <div class="text-center py-6 space-y-3">
                            <div class="text-base sm:text-lg font-bold leading-relaxed text-indigo-100"
                                 x-html="currentCard.back_bn"></div>
                            <template x-if="currentCard.hint_bn">
                                <div class="text-xs text-indigo-300 italic pt-2">
                                    💡 <span x-text="currentCard.hint_bn"></span>
                                </div>
                            </template>
                        </div>

                        <div class="text-center text-xs font-bold text-indigo-300 flex items-center justify-center space-x-1">
                            <span>🔄</span>
                            <span>প্রশ্নে ফিরতে আবার ক্লিক করুন</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Controls --}}
            <div class="flex items-center justify-between gap-4">
                {{-- Prev --}}
                <button @click="prevCard()"
                        :disabled="currentIndex === 0"
                        class="p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-40 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                {{-- Rating Buttons --}}
                <div class="flex items-center space-x-3 flex-1 justify-center max-w-sm">
                    <button @click="rateCard(false)"
                            class="flex-1 py-3 rounded-2xl border border-rose-200 dark:border-rose-900/40 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-400 font-bold text-xs transition flex items-center justify-center space-x-1.5">
                        <span>❌</span>
                        <span>পুনরায় অনুশীলন</span>
                    </button>

                    <button @click="rateCard(true)"
                            class="flex-1 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center space-x-1.5">
                        <span>✅</span>
                        <span>মুখস্থ হয়েছে (+২🪙)</span>
                    </button>
                </div>

                {{-- Next --}}
                <button @click="nextCard()"
                        :disabled="currentIndex === cards.length - 1"
                        class="p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-40 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <div class="text-center text-[11px] text-slate-400">
                কী-বোর্ড শর্টকাট: <kbd class="px-1 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-mono">Space</kbd> কার্ড ফ্লিপ | <kbd class="px-1 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-mono">←</kbd> রিভিশন | <kbd class="px-1 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-mono">→</kbd> মুখস্থ
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function flashcardDeck() {
    return {
        cards: @json($cards),
        currentIndex: 0,
        isFlipped: false,
        masteredCount: {{ $masteredCount }},
        get currentCard() {
            return this.cards[this.currentIndex] || {};
        },
        get progressRate() {
            return this.cards.length > 0 ? Math.round((this.masteredCount / this.cards.length) * 100) : 0;
        },
        nextCard() {
            if (this.currentIndex < this.cards.length - 1) {
                this.isFlipped = false;
                this.currentIndex++;
            }
        },
        prevCard() {
            if (this.currentIndex > 0) {
                this.isFlipped = false;
                this.currentIndex--;
            }
        },
        async rateCard(isMastered) {
            const card = this.currentCard;
            if (!card.id) return;

            try {
                const response = await fetch(`/flashcards/${card.id}/rate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ is_mastered: isMastered ? 1 : 0 })
                });
                const data = await response.json();
                if (data.success) {
                    if (isMastered && !card.user_mastered) {
                        this.masteredCount++;
                    } else if (!isMastered && card.user_mastered) {
                        this.masteredCount = Math.max(0, this.masteredCount - 1);
                    }
                    card.user_mastered = isMastered;
                    this.nextCard();
                }
            } catch (err) {
                console.error(err);
            }
        },
        init() {
            window.addEventListener('keydown', (e) => {
                if (e.code === 'Space') {
                    e.preventDefault();
                    this.isFlipped = !this.isFlipped;
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    this.rateCard(true);
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    this.rateCard(false);
                }
            });
        }
    };
}
</script>
@endpush
@endsection
