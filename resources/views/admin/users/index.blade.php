@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6" x-data="{ editUserModal: false, selectedUser: { id: '', name: '', email: '', role: 'student', coins: 0 } }">
    
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                    RBAC & User Access
                </div>
                <h1 class="text-2xl font-black text-slate-900">{{ __t('ব্যবহারকারী ও রোল ম্যানেজমেন্ট', 'User & Role Access Management') }}</h1>
                <p class="text-xs text-slate-500">{{ __t('স্টুডেন্ট, রিভিউয়ার, প্রশ্ন প্রণেতা ও অ্যাডমিনদের পারমিশন নিয়ন্ত্রণ করুন।', 'Manage candidate, question setter, reviewer, and admin access roles.') }}</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="নাম, ইমেইল বা ফোন দিয়ে খুঁজুন..." class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs w-64 bg-white">

                <select name="role" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল রোল</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>ক্যান্ডিডেট (Student)</option>
                    <option value="setter" {{ request('role') === 'setter' ? 'selected' : '' }}>প্রশ্ন প্রণেতা (Setter)</option>
                    <option value="reviewer" {{ request('role') === 'reviewer' ? 'selected' : '' }}>রিভিউয়ার (Reviewer)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>অ্যাডমিন (Admin)</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">ফিল্টার</button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4">ক্যান্ডিডেট নাম</th>
                            <th class="py-3.5 px-4">যোগাযোগ</th>
                            <th class="py-3.5 px-4">টার্গেট পরীক্ষা</th>
                            <th class="py-3.5 px-4">রোল (Role)</th>
                            <th class="py-3.5 px-4">স্ট্রাইক ও কয়েন</th>
                            <th class="py-3.5 px-4">পরীক্ষা সম্পন্ন</th>
                            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @foreach($users as $u)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-slate-900">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ $u->email }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $u->phone ?? 'ফোন যুক্ত নেই' }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-semibold">
                                        {{ $u->target_exam ?? 'সাধারণ বিসিএস' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $u->role === 'admin' ? 'bg-slate-100 text-slate-800' : ($u->role === 'setter' ? 'bg-slate-100 text-slate-700' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $u->role }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-rose-600">🔥 {{ $u->daily_streak }} দিন</div>
                                    <div class="text-[10px] text-amber-700 font-bold">🪙 {{ $u->coins }} কয়েন</div>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-800">
                                    {{ $u->exam_attempts_count }} টি
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <button type="button" @click="selectedUser = {{ $u->toJson() }}; editUserModal = true" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition">
                                        রোল পরিবর্তন
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        </div>

    <!-- Edit User Modal -->
    <div x-show="editUserModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/40 backdrop-blur-xs" x-transition>
        <div @click.outside="editUserModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900">ব্যবহারকারী রোল ও কয়েন পরিবর্তন</h3>
            <p class="text-xs text-slate-500" x-text="selectedUser.name + ' (' + selectedUser.email + ')'"></p>

            <form :action="'/admin/users/' + selectedUser.id + '/role'" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">অ্যাক্সেস রোল (Role)</label>
                    <select name="role" x-model="selectedUser.role" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white font-bold">
                        <option value="student">ক্যান্ডিডেট (Student)</option>
                        <option value="setter">প্রশ্ন প্রণেতা (Question Setter)</option>
                        <option value="reviewer">রিভিউয়ার (Reviewer)</option>
                        <option value="admin">সুপার অ্যাডমিন (Admin)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কয়েন ব্যালেন্স</label>
                    <input type="number" name="coins" x-model="selectedUser.coins" min="0" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="editUserModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">আপডেট করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
