<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('examAttempts');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term);
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $totalStudents = User::where('role', 'student')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSetters = User::where('role', 'setter')->count();

        return view('admin.users.index', compact('users', 'totalStudents', 'totalAdmins', 'totalSetters'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:student,admin,setter,reviewer',
            'coins' => 'required|integer|min:0',
        ]);

        $user->update([
            'role' => $validated['role'],
            'coins' => $validated['coins'],
        ]);

        return back()->with('success', 'ব্যবহারকারীর রোল ও কয়েন সফলভাবে আপডেট করা হয়েছে!');
    }
}
