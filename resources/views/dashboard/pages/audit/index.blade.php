@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">System Audit Trail</h1>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('audit.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search action or description..."
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">

                <select name="module" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    <option value="">All Modules</option>
                    <option value="Rooms" {{ request('module') == 'Rooms' ? 'selected' : '' }}>Rooms</option>
                    <option value="Bookings" {{ request('module') == 'Bookings' ? 'selected' : '' }}>Bookings</option>
                    <option value="Users" {{ request('module') == 'Users' ? 'selected' : '' }}>Users</option>
                    <option value="Auth" {{ request('module') == 'Auth' ? 'selected' : '' }}>Authentication</option>
                </select>

                <button type="submit"
                    class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-900 transition">
                    Filter Logs
                </button>

                @if (request()->has('search') || request()->has('module'))
                    <a href="{{ route('audit.index') }}"
                        class="text-red-500 text-sm flex items-center hover:underline italic">Clear Filters</a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-900 text-white text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Timestamp</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Action</th>
                        <th class="px-6 py-4">Module</th>
                        <th class="px-6 py-4">Description</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                {{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 font-bold text-blue-600">
                                {{ $log->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-[10px] font-bold uppercase border border-blue-100">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600 font-medium">{{ $log->module }}</span>
                            </td>
                            <td class="px-6 py-4 italic text-gray-500">{{ $log->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No audit records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4 bg-gray-50 border-t border-gray-100">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
@endsection
