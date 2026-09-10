@extends('layouts.app')

@section('content')
<div class="py-4 bg-slate-100 min-h-screen" 
     x-data="examEngine({
        attemptId: {{ $attempt->id }},
        totalQuestions: {{ $questions->count() }},
        remainingSeconds: {{ $remainingSeconds }},
        isTimed: {{ $exam->duration_minutes > 0 ? 'true' : 'false' }},
        saveUrl: '{{ route('attempts.saveState', $attempt->id) }}',
        submitUrl: '{{ route('attempts.submit', $attempt->id) }}',
        csrfToken: '{{ csrf_token() }}',
        initialAnswers: {{ json_encode($savedAnswers ?? []) }},
        questionsCount: {{ $questions->count() }}
     })"
     x-init="initEngine()">

    <!-- Fixed Header Bar for Exam Room -->
    <div class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm py-3 px-4 sm:px-6 mb-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Left: Exam Title & View Mode Toggle -->
            <div class="flex items-center space-x-3">
                <div>
                    <h1 class="text-sm sm:text-base font-extrabold text-slate-900 truncate max-w-xs sm:max-w-md">
                        {{ $exam->title_bn }}
                    </h1>
                    <div class="flex items-center space-x-2 text-[11px] text-slate-500">
                        <span>প্রশ্ন: {{ $questions->count() }} টি</span>
                        <span>•</span>
                        <span class="text-rose-600 font-semibold">নেগেটিভ: -{{ $exam->negative_mark_per_question }}</span>
                    </div>
                </div>

                <!-- View Mode Toggle (Single Card vs Full Paper) -->
                <div class="hidden sm:flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-bold">
                    <button type="button" @click="viewMode = 'single'" :class="viewMode === 'single' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-500 hover:text-slate-800'" class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>কার্ড ভিউ</span>
                    </button>
                    <button type="button" @click="viewMode = 'paper'" :class="viewMode === 'paper' ? 'bg-white text-indigo-700 shadow-xs' : 'text-slate-500 hover:text-slate-800'" class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        <span>পেপার ভিউ</span>
                    </button>
                </div>
            </div>

            <!-- Right: Timer, Autosave Status & Submit Button -->
            <div class="flex items-center space-x-3">
                <!-- Tab switch alert count -->
                <div x-show="tabSwitches > 0" class="hidden sm:flex items-center space-x-1 px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold" title="ট্যাব পরিবর্তন কাউন্টার">
                    <span>⚠️</span>
                    <span x-text="tabSwitches + ' বার সুইচ'"></span>
                </div>

                <!-- Timer -->
                @if($exam->duration_minutes > 0)
                    <div class="flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border font-black text-sm"
                         :class="remainingSeconds < 120 ? 'bg-rose-50 border-rose-300 text-rose-600 animate-pulse' : 'bg-slate-50 border-slate-200 text-slate-800'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span x-text="formatTimer()"></span>
                    </div>
                @endif

                <!-- Submit Button -->
                <button type="button" @click="showSubmitModal = true" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1">
                    <span>{{ __t('জমা দিন', 'Submit') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Exam Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            
            <!-- Left 3 Cols: Question Paper or Card -->
            <div class="lg:col-span-3 space-y-6">

                <!-- 1. SINGLE CARD VIEW -->
                <div x-show="viewMode === 'single'" class="space-y-6">
                    @foreach($questions as $index => $q)
                        <div x-show="currentIndex === {{ $index }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                            
                            <!-- Question Header -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div class="flex items-center space-x-2">
                                    <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-black text-sm flex items-center justify-center shadow-xs">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg">
                                        {{ $q->subject->name_bn }}
                                    </span>
                                    @if($q->setterOrganization)
                                        <span class="text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg">
                                            {{ $q->setterOrganization->code }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Bookmark / Flag for Review -->
                                <button type="button" @click="toggleReview({{ $q->id }})" 
                                        :class="isFlagged({{ $q->id }}) ? 'bg-amber-50 text-amber-800 border-amber-300' : 'bg-slate-50 text-slate-500 border-slate-200 hover:bg-slate-100'"
                                        class="px-3 py-1.5 rounded-xl border text-xs font-bold flex items-center space-x-1.5 transition">
                                    <span x-text="isFlagged({{ $q->id }}) ? '⭐ চিহ্নিত' : '☆ রিভিউতে রাখুন'"></span>
                                </button>
                            </div>

                            <!-- Question Stem (LaTeX KaTeX rendered) -->
                            <div class="math-tex text-base sm:text-lg font-bold text-slate-900 leading-relaxed">
                                {!! app()->getLocale() === 'en' && !empty($q->stem_en) ? $q->stem_en : $q->stem_bn !!}
                            </div>

                            @if(app()->getLocale() === 'bn' && $q->stem_en)
                                <div class="math-tex text-xs text-slate-500 font-medium italic">
                                    {!! $q->stem_en !!}
                                </div>
                            @endif

                            <!-- Options List -->
                            <div class="space-y-3 pt-2">
                                @foreach($q->options as $opt)
                                    <label @click="selectAnswer({{ $q->id }}, {{ $opt->id }})" 
                                           :class="answers[{{ $q->id }}] == {{ $opt->id }} ? 'bg-indigo-50 border-indigo-600 ring-1 ring-indigo-500/30 shadow-xs' : 'bg-slate-50 hover:bg-slate-100 border-slate-200'"
                                           class="flex items-center p-4 rounded-2xl border cursor-pointer transition select-none group">
                                        
                                        <div :class="answers[{{ $q->id }}] == {{ $opt->id }} ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-700 border-slate-300 group-hover:border-slate-400'"
                                             class="w-8 h-8 rounded-xl border font-bold text-xs flex items-center justify-center mr-3.5 shrink-0 transition">
                                            {{ $opt->option_letter }}
                                        </div>

                                        <div class="math-tex text-sm font-semibold text-slate-800 flex-1">
                                            {!! app()->getLocale() === 'en' && !empty($opt->option_text_en) ? $opt->option_text_en : $opt->option_text_bn !!}
                                        </div>

                                        <div x-show="answers[{{ $q->id }}] == {{ $opt->id }}" class="text-indigo-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Single Card Navigation Buttons -->
                            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                                <button type="button" @click="prevQuestion()" :disabled="currentIndex === 0" 
                                        class="px-5 py-2.5 rounded-xl border border-slate-200 font-bold text-xs text-slate-600 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition">
                                    ← পূর্ববর্তী
                                </button>

                                <button type="button" @click="clearAnswer({{ $q->id }})" x-show="answers[{{ $q->id }}]" class="text-xs font-bold text-rose-500 hover:text-rose-700">
                                    উত্তর বাতিল করুন
                                </button>

                                <button type="button" @click="nextQuestion()" :disabled="currentIndex === {{ $questions->count() - 1 }}" 
                                        class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 font-bold text-xs text-white disabled:opacity-40 disabled:cursor-not-allowed shadow-xs transition">
                                    পরবর্তী →
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 2. FULL PAPER VIEW (Physical Exam Paper Style) -->
                <div x-show="viewMode === 'paper'" class="space-y-6">
                    @foreach($questions as $index => $q)
                        <div id="paper-q-{{ $q->id }}" class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-black text-xs flex items-center justify-center shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                        {{ $q->subject->name_bn }}
                                    </span>
                                </div>

                                <button type="button" @click="toggleReview({{ $q->id }})" 
                                        :class="isFlagged({{ $q->id }}) ? 'text-amber-600 font-bold' : 'text-slate-400 hover:text-slate-600'"
                                        class="text-xs flex items-center space-x-1">
                                    <span x-text="isFlagged({{ $q->id }}) ? '⭐ চিহ্নিত' : '☆ ফ্ল্যাগ'"></span>
                                </button>
                            </div>

                            <div class="math-tex text-base font-bold text-slate-900 leading-snug">
                                {!! $q->stem_bn !!}
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                @foreach($q->options as $opt)
                                    <label @click="selectAnswer({{ $q->id }}, {{ $opt->id }})" 
                                           :class="answers[{{ $q->id }}] == {{ $opt->id }} ? 'bg-indigo-50 border-indigo-600 ring-1 ring-indigo-500/30' : 'bg-slate-50 hover:bg-slate-100 border-slate-200'"
                                           class="flex items-center p-3 rounded-xl border cursor-pointer transition select-none">
                                        
                                        <div :class="answers[{{ $q->id }}] == {{ $opt->id }} ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-700 border-slate-300'"
                                             class="w-6 h-6 rounded-lg border font-bold text-[11px] flex items-center justify-center mr-2.5 shrink-0">
                                            {{ $opt->option_letter }}
                                        </div>

                                        <div class="math-tex text-xs font-semibold text-slate-800 flex-1">
                                            {!! $opt->option_text_bn !!}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Col: Live Question Palette & Summary Sidebar -->
            <div class="lg:col-span-1 sticky top-20 space-y-4">
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-md space-y-4">
                    
                    <h3 class="font-black text-sm text-slate-900 border-b border-slate-100 pb-3 flex items-center justify-between">
                        <span>প্রশ্ন প্যালেট (Status Palette)</span>
                        <span class="text-xs font-bold text-indigo-700" x-text="answeredCount() + '/' + totalQuestions"></span>
                    </h3>

                    <!-- Palette Legend -->
                    <div class="grid grid-cols-3 gap-2 text-[10px] font-bold text-center">
                        <div class="bg-indigo-50 text-indigo-700 p-1.5 rounded-lg border border-indigo-200">
                            <span class="block text-xs font-black" x-text="answeredCount()"></span>
                            <span>উত্তর প্রদত্ত</span>
                        </div>
                        <div class="bg-amber-50 text-amber-700 p-1.5 rounded-lg border border-amber-200">
                            <span class="block text-xs font-black" x-text="flaggedCount()"></span>
                            <span>রিভিউ চিহ্নিত</span>
                        </div>
                        <div class="bg-slate-100 text-slate-600 p-1.5 rounded-lg border border-slate-200">
                            <span class="block text-xs font-black" x-text="totalQuestions - answeredCount()"></span>
                            <span>বাকি</span>
                        </div>
                    </div>

                    <!-- Question Number Bubbles -->
                    <div class="grid grid-cols-5 gap-2 max-h-64 overflow-y-auto p-1">
                        @foreach($questions as $index => $q)
                            <button type="button" @click="goToQuestion({{ $index }}, {{ $q->id }})"
                                    :class="getPaletteClass({{ $index }}, {{ $q->id }})"
                                    class="w-full h-9 rounded-xl font-bold text-xs flex items-center justify-center transition border shadow-2xs">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2">
                        <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium">
                            <span>অটো-সেভ স্ট্যাটাস:</span>
                            <span class="text-emerald-700 font-bold" x-text="saveStatus"></span>
                        </div>
                        
                        <button type="button" @click="showSubmitModal = true" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-xs transition">
                            পরীক্ষা সমাপ্ত ও জমা দিন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <div x-show="showSubmitModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/40 backdrop-blur-xs" x-transition>
        <div @click.outside="showSubmitModal = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100 space-y-6">
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-2xl font-bold">
                    📝
                </div>
                <h3 class="text-xl font-black text-slate-900">আপনি কি পরীক্ষা জমা দিতে চান?</h3>
                <p class="text-xs text-slate-500">একবার জমা দিলে আর উত্তর পরিবর্তন করা সম্ভব হবে না।</p>
            </div>

            <!-- Submission Stats Box -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/70 grid grid-cols-3 gap-2 text-center">
                <div>
                    <div class="text-lg font-black text-indigo-600" x-text="answeredCount()"></div>
                    <div class="text-[10px] font-bold text-slate-500">উত্তর করেছেন</div>
                </div>
                <div>
                    <div class="text-lg font-black text-rose-600" x-text="totalQuestions - answeredCount()"></div>
                    <div class="text-[10px] font-bold text-slate-500">বাকি আছে</div>
                </div>
                <div>
                    <div class="text-lg font-black text-amber-600" x-text="flaggedCount()"></div>
                    <div class="text-[10px] font-bold text-slate-500">ফ্ল্যাগড</div>
                </div>
            </div>

            <!-- Form -->
            <form :action="submitUrl" method="POST">
                <input type="hidden" name="_token" :value="csrfToken">
                <template x-for="(optId, qId) in answers" :key="qId">
                    <input type="hidden" :name="'answers[' + qId + ']'" :value="optId">
                </template>
                <input type="hidden" name="time_spent" :value="timeSpent">
                <input type="hidden" name="tab_switches" :value="tabSwitches">

                <div class="flex items-center space-x-3 pt-2">
                    <button type="button" @click="showSubmitModal = false" class="w-1/2 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 font-bold text-xs text-slate-600 transition">
                        পরীক্ষায় ফিরে যান
                    </button>
                    <button type="submit" class="w-1/2 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-xs transition">
                        হ্যাঁ, জমা দিন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function examEngine(config) {
    return {
        attemptId: config.attemptId,
        totalQuestions: config.totalQuestions,
        remainingSeconds: config.remainingSeconds,
        isTimed: config.isTimed,
        saveUrl: config.saveUrl,
        submitUrl: config.submitUrl,
        csrfToken: config.csrfToken,
        viewMode: 'single', // 'single' or 'paper'
        currentIndex: 0,
        answers: config.initialAnswers || {},
        flagged: {},
        tabSwitches: 0,
        timeSpent: 0,
        saveStatus: 'সংরক্ষিত ✓',
        showSubmitModal: false,
        timerInterval: null,

        initEngine() {
            // Anti-cheat tab-switch detection
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.tabSwitches++;
                    this.triggerAutoSave();
                }
            });

            // Prevent accidental reload
            window.addEventListener('beforeunload', (e) => {
                if (!this.showSubmitModal) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });

            // Start timer
            if (this.isTimed && this.remainingSeconds > 0) {
                this.timerInterval = setInterval(() => {
                    this.remainingSeconds--;
                    this.timeSpent++;

                    if (this.remainingSeconds <= 0) {
                        clearInterval(this.timerInterval);
                        this.autoSubmit();
                    }

                    // Auto save every 15 seconds
                    if (this.timeSpent % 15 === 0) {
                        this.triggerAutoSave();
                    }
                }, 1000);
            }

            // Render LaTeX formulas
            this.$nextTick(() => {
                document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
            });
        },

        formatTimer() {
            const totalSecs = Math.max(0, Math.floor(this.remainingSeconds));
            const m = Math.floor(totalSecs / 60);
            const s = totalSecs % 60;
            return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        },

        selectAnswer(questionId, optionId) {
            this.answers[questionId] = optionId;
            this.saveStatus = 'সংরক্ষণ হচ্ছে...';
            this.triggerAutoSave();
        },

        clearAnswer(questionId) {
            delete this.answers[questionId];
            this.triggerAutoSave();
        },

        toggleReview(questionId) {
            this.flagged[questionId] = !this.flagged[questionId];
        },

        isFlagged(questionId) {
            return !!this.flagged[questionId];
        },

        answeredCount() {
            return Object.keys(this.answers).length;
        },

        flaggedCount() {
            return Object.values(this.flagged).filter(Boolean).length;
        },

        nextQuestion() {
            if (this.currentIndex < this.totalQuestions - 1) {
                this.currentIndex++;
                this.$nextTick(() => {
                    document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
                });
            }
        },

        prevQuestion() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.$nextTick(() => {
                    document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
                });
            }
        },

        goToQuestion(index, questionId) {
            this.currentIndex = index;
            if (this.viewMode === 'paper') {
                const el = document.getElementById('paper-q-' + questionId);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                this.$nextTick(() => {
                    document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
                });
            }
        },

        getPaletteClass(index, questionId) {
            if (this.currentIndex === index && this.viewMode === 'single') {
                return 'ring-2 ring-indigo-600 bg-indigo-50 text-indigo-700 border-indigo-300 font-black';
            }
            if (this.answers[questionId]) {
                return 'bg-indigo-600 text-white border-indigo-600';
            }
            if (this.flagged[questionId]) {
                return 'bg-amber-100 text-amber-900 border-amber-300 font-bold';
            }
            return 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200';
        },

        triggerAutoSave() {
            fetch(this.saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    answers: this.answers,
                    tab_switches: this.tabSwitches,
                })
            })
            .then(res => res.json())
            .then(() => {
                this.saveStatus = 'সংরক্ষিত ✓';
            })
            .catch(() => {
                this.saveStatus = 'লোকাল সেভ ✓';
            });
        },

        autoSubmit() {
            alert('সময় সমাপ্ত! আপনার পরীক্ষা স্বয়ংক্রিয়ভাবে জমা দেওয়া হচ্ছে...');
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.submitUrl;

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = this.csrfToken;
            form.appendChild(tokenInput);

            for (const [qId, optId] of Object.entries(this.answers)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `answers[${qId}]`;
                input.value = optId;
                form.appendChild(input);
            }

            const timeInput = document.createElement('input');
            timeInput.type = 'hidden';
            timeInput.name = 'time_spent';
            timeInput.value = this.timeSpent;
            form.appendChild(timeInput);

            const tabInput = document.createElement('input');
            tabInput.type = 'hidden';
            tabInput.name = 'tab_switches';
            tabInput.value = this.tabSwitches;
            form.appendChild(tabInput);

            document.body.appendChild(form);
            form.submit();
        }
    };
}
</script>
@endpush
