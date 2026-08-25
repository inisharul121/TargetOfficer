<!DOCTYPE html>
<html lang="bn" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'TargetOfficer - Precision Preparation for Public Service' }}</title>
    <meta name="description" content="Bangladesh's premier online preparation platform for BCS, Bank, and Government Job exams with question setter analysis.">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white">
    
    @include('layouts.navigation')

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full" x-data="{ show: true }" x-show="show" x-transition>
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 shadow-sm flex items-center justify-between text-emerald-800">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full" x-data="{ show: true }" x-show="show" x-transition>
            <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 shadow-sm flex items-center justify-between text-rose-800">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="text-sm font-medium">
                        {{ session('error') ?? $errors->first() }}
                    </div>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 to-indigo-400 flex items-center justify-center text-white font-black text-lg shadow-md">T</span>
                        <span class="text-xl font-extrabold text-white tracking-tight">Target<span class="text-indigo-400">Officer</span></span>
                    </div>
                    <p class="mt-3 text-sm text-slate-400 max-w-sm leading-relaxed">
                        Aim High. Aim Officer. বিসিএস, বাংলাদেশ ব্যাংক ও সরকারি চাকরির নির্ভুল প্রস্তুতি এবং প্রশ্নকর্তা প্যাটার্ন বিশ্লেষণের নির্ভরযোগ্য প্ল্যাটফর্ম।
                    </p>
                    <div class="mt-4 flex items-center space-x-3 text-xs text-slate-500">
                        <span>© {{ date('Y') }} TargetOfficer. All rights reserved.</span>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-200">দ্রুত লিংক</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('exams.index') }}" class="hover:text-white transition">সকল মডেল টেস্ট</a></li>
                        <li><a href="{{ route('practice.index') }}" class="hover:text-white transition">বিষয়ভিত্তিক অনুশীলন</a></li>
                        <li><a href="{{ route('question-bank.index') }}" class="hover:text-white transition">প্রশ্ন ব্যাংক ও প্যাটার্ন</a></li>
                        <li><a href="{{ route('leaderboard.index') }}" class="hover:text-white transition">লিডারবোর্ড</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-200">প্রশ্নকর্তা প্যাটার্ন</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('question-bank.index', ['setter' => 1]) }}" class="hover:text-white transition">বিপিএসসি (BPSC)</a></li>
                        <li><a href="{{ route('question-bank.index', ['setter' => 2]) }}" class="hover:text-white transition">বুয়েট প্যাটার্ন (BUET)</a></li>
                        <li><a href="{{ route('question-bank.index', ['setter' => 3]) }}" class="hover:text-white transition">আইবিএ প্যাটার্ন (IBA)</a></li>
                        <li><a href="{{ route('question-bank.index', ['setter' => 5]) }}" class="hover:text-white transition">কলা অনুষদ (Arts Faculty)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
