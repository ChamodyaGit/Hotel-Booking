<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$searchTerm}%"]);
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return view('dashboard.pages.users.index', compact('users'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'Only Admins can add new staff members.');
        }
        return view('dashboard.pages.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,manager,receptionist',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'New user added successfully!');
    }

    public function edit(User $user)
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            return redirect()->route('users.index')->with('error', 'Unauthorized access.');
        }

        return view('dashboard.pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'role' => 'required|in:admin,manager,receptionist',
        ];

        if (Auth::user()->role === 'admin') {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        }

        $validated = $request->validate($rules);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }
}
