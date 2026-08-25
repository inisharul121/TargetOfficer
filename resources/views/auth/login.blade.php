@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-600 items-center justify-center text-white font-black text-2xl shadow-md shadow-indigo-200 mb-4">T</div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">অ্যাকাউন্টে লগইন করুন</h2>
        <p class="mt-2 text-sm text-slate-500">
            নতুন ইউজার? 
            <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500">ফ্রি রেজিস্ট্রেশন করুন</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 sm:px-10 shadow-xl shadow-slate-200/60 rounded-3xl border border-slate-100">
            <form class="space-y-5" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">ইমেইল এড্রেস</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">পাসওয়ার্ড</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 block text-xs font-medium text-slate-600">আমাকে মনে রাখুন</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-200 transition">
                        লগইন করুন
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100">
                <p class="text-xs font-bold text-slate-400 text-center uppercase tracking-wider mb-3">দ্রুত ডেমো পরীক্ষা করুন</p>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('demo.login', 'student') }}" class="py-2.5 px-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs text-center border border-indigo-200 transition flex items-center justify-center space-x-1">
                        <span>👨‍🎓 ক্যান্ডিডেট ডেমো</span>
                    </a>
                    <a href="{{ route('demo.login', 'admin') }}" class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center border border-slate-200 transition flex items-center justify-center space-x-1">
                        <span>🛡️ এডমিন ডেমো</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
