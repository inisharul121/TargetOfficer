@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-600 items-center justify-center text-white font-black text-2xl shadow-md shadow-indigo-200 mb-4">T</div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">নতুন অ্যাকাউন্ট তৈরি করুন</h2>
        <p class="mt-2 text-sm text-slate-500">
            পূর্বেই অ্যাকাউন্ট আছে? 
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500">লগইন করুন</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 sm:px-10 shadow-xl shadow-slate-200/60 rounded-3xl border border-slate-100">
            <form class="space-y-4" action="{{ route('register.post') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">আপনার পুরো নাম</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" placeholder="যেমন: তানভীর আহমেদ" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">ইমেইল এড্রেস</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="name@example.com" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">মোবাইল নম্বর (ঐচ্ছিক)</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="017XXXXXXXX" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                </div>

                <div>
                    <label for="target_exam" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">আপনার মূল টার্গেট পরীক্ষা</label>
                    <select id="target_exam" name="target_exam" required class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm bg-white">
                        <option value="47th BCS Preliminary">৪৭তম বিসিএস প্রিলিমিনারি</option>
                        <option value="46th BCS Written">৪৬তম বিসিএস লিখিত</option>
                        <option value="Bangladesh Bank AD">বাংলাদেশ ব্যাংক সহকারী পরিচালক (AD)</option>
                        <option value="Combined 8 Banks Officer">সমন্বিত ৮ ব্যাংক অফিসার</option>
                        <option value="IT Cadre & Specialized Exams">আইটি ক্যাডার / স্পেশালাইজড পদ</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">পাসওয়ার্ড</label>
                    <input id="password" name="password" type="password" required placeholder="কমপক্ষে ৬ অক্ষর" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="পুনরায় পাসওয়ার্ড লিখুন" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-200 transition">
                        রেজিস্ট্রেশন সম্পন্ন করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
