@extends('dashboard.layouts.app')
@section('content')
    <main class="p-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Total Rooms</h3>
                    <i class="fa-solid fa-door-open text-blue-500"></i>
                </div>
                <p class="text-3xl font-bold mt-2">45</p>
                <p class="text-green-500 text-xs mt-1 font-semibold">5 Available now</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Today's Bookings</h3>
                    <i class="fa-solid fa-bookmark text-green-500"></i>
                </div>
                <p class="text-3xl font-bold mt-2">12</p>
                <p class="text-gray-400 text-xs mt-1 italic">Expected check-ins: 8</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Staff Active</h3>
                    <i class="fa-solid fa-user-tie text-purple-500"></i>
                </div>
                <p class="text-3xl font-bold mt-2">08</p>
                <p class="text-gray-400 text-xs mt-1 italic">Across 2 locations</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 uppercase tracking-wider text-sm">Upcoming Bookings</h3>
                <button class="text-blue-600 text-sm font-semibold hover:underline">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4 italic">Guest Name</th>
                            <th class="px-6 py-4 italic">Room</th>
                            <th class="px-6 py-4 italic">Check In</th>
                            <th class="px-6 py-4 italic">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <tr>
                            <td class="px-6 py-4 font-medium">Kasun Perera</td>
                            <td class="px-6 py-4">Room 204 (Suite)</td>
                            <td class="px-6 py-4">May 12, 2026</td>
                            <td class="px-6 py-4 text-blue-600 font-semibold">Confirmed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-medium">Imara Silva</td>
                            <td class="px-6 py-4">Room 105 (Single)</td>
                            <td class="px-6 py-4">May 12, 2026</td>
                            <td class="px-6 py-4 text-orange-500 font-semibold">Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
