@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Total Rooms</h3>
                    <i class="fa-solid fa-door-open text-blue-500"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $totalRooms }}</p>
                <p class="text-green-500 text-xs mt-1 font-semibold">{{ $availableRoomsNow }} Available now</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Today's Bookings</h3>
                    <i class="fa-solid fa-bookmark text-green-500"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ str_pad($todaysBookingsCount, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-gray-400 text-xs mt-1 italic">Expected check-ins: {{ $expectedCheckIns }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Staff Registered</h3>
                    <i class="fa-solid fa-user-tie text-purple-500"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ str_pad($activeStaff, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-gray-400 text-xs mt-1 italic">Authorized system users</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 uppercase tracking-wider text-sm">Upcoming Bookings (Next Few Days)</h3>
                <a href="{{ route('bookings.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">View
                    All</a>
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
                        @forelse($upcomingBookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium">{{ $booking->guest_name }}</td>
                                <td class="px-6 py-4">Room {{ $booking->room->room_number }}
                                    ({{ $booking->room->room_type }})</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-blue-600 font-semibold">
                                        <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">No upcoming bookings
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
