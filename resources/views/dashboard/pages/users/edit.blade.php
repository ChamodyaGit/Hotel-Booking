@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="max-w-2xl mx-auto">
            <a href="{{ route('users.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block italic">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Staff List
            </a>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-2">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h1 class="text-xl font-bold text-gray-800">Edit Staff Member: <span
                            class="text-blue-600">{{ $user->name }}</span></h1>
                    <p class="text-sm text-gray-500 font-medium">Update account information and system access levels.</p>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            {{ auth()->user()->role !== 'admin' ? 'readonly' : '' }}
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition {{ auth()->user()->role !== 'admin' ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}">
                        @if (auth()->user()->role !== 'admin')
                            <p class="text-[10px] text-orange-500 mt-1 italic">* Only Admins can change names.</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            {{ auth()->user()->role !== 'admin' ? 'readonly' : '' }}
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition {{ auth()->user()->role !== 'admin' ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Assign System Role</label>
                        <select name="role" required
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition">
                            <option value="receptionist" {{ old('role', $user->role) == 'receptionist' ? 'selected' : '' }}>
                                Receptionist</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager
                            </option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Full
                                Access)</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-2 italic">Changes take effect upon user's next login.</p>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-100 space-x-4">
                        <button type="reset"
                            class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                            Reset Changes
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg font-bold shadow-lg transition transform active:scale-95">
                            Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
