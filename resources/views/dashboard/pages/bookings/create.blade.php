@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="max-w-3xl mx-auto">
            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block italic">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to All Bookings
            </a>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-blue-50/30">
                    <h1 class="text-xl font-bold text-gray-800">New Guest Reservation</h1>
                    <p class="text-sm text-gray-500">Ensure all dates are double-checked to avoid overlaps.</p>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Guest Full Name</label>
                        <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            placeholder="Enter guest name">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Select Available Room</label>
                            <select name="room_id" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500">
                                <option value="">-- Choose a Room --</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">Room {{ $room->room_number }}
                                        ({{ $room->room_type }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1 italic font-medium">* Only currently available rooms are
                                listed here.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Booking Status</label>
                            <input type="text" value="Confirmed" readonly
                                class="block w-full px-4 py-2 border border-gray-100 bg-gray-50 rounded-lg text-gray-500 cursor-not-allowed">
                            <input type="hidden" name="status" value="Confirmed">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check-in Date</label>
                            <input type="date" name="check_in" min="{{ date('Y-m-d') }}" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check-out Date</label>
                            <input type="date" name="check_out" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-lg font-bold shadow-lg transition transform active:scale-95">
                            Confirm Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
