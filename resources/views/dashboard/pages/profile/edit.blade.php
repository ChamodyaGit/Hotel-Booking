@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8 space-y-8">
        <h1 class="text-2xl font-bold text-gray-800">Account Settings</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1">
                <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
            </div>

            <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('profile.info.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    </div>

                    <div class="flex justify-end bg-gray-50 -mx-6 -mb-6 p-4">
                        <button type="submit"
                            class="bg-slate-900 text-white px-6 py-2 rounded-md text-xs font-bold uppercase tracking-widest hover:bg-slate-800 transition">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="border-gray-200">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1">
                <h3 class="text-lg font-medium text-gray-900">Update Password</h3>
                </p>
            </div>

            <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('profile.password.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    </div>

                    <div class="flex justify-end bg-gray-50 -mx-6 -mb-6 p-4">
                        <button type="submit"
                            class="bg-slate-900 text-white px-6 py-2 rounded-md text-xs font-bold uppercase tracking-widest hover:bg-slate-800 transition">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
