@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-800">Booking Details</h2>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $booking->status == 'Confirmed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                        {{ $booking->status }}
                    </span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-4">Guest Information</h3>
                        <p class="text-lg font-semibold">{{ $booking->guest_name }}</p>
                        <p class="text-sm text-gray-500 mt-1 italic">Booked on:
                            {{ $booking->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-4">Room Information</h3>
                        <p class="text-lg font-semibold">Room {{ $booking->room->room_number }}
                            ({{ $booking->room->room_type }})</p>
                        <p class="text-sm text-gray-500 mt-1">Floor: Level {{ $booking->room->floor }}</p>
                    </div>
                    <div class="border-t pt-4">
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2">Check-in</h3>
                        <p class="text-md font-medium text-blue-600">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</p>
                    </div>
                    <div class="border-t pt-4">
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2">Check-out</h3>
                        <p class="text-md font-medium text-red-600">
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
