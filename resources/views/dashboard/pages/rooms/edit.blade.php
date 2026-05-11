@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="max-w-3xl mx-auto">
            <a href="{{ route('rooms.index') }}"
                class="text-blue-600 hover:underline text-sm mb-4 inline-block italic font-medium">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Room Inventory
            </a>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-2">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h1 class="text-xl font-bold text-gray-800">Edit Room: <span
                            class="text-blue-600">#{{ $room->room_number }}</span></h1>
                    <p class="text-sm text-gray-500">Update the room details, pricing, and availability status.</p>
                </div>

                <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Room Number</label>
                            <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}"
                                required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('room_number') border-red-500 @enderror">
                            @error('room_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Room Type</label>
                            <select name="room_type" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition">
                                <option value="Single"
                                    {{ old('room_type', $room->room_type) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Double"
                                    {{ old('room_type', $room->room_type) == 'Double' ? 'selected' : '' }}>Double</option>
                                <option value="Suite"
                                    {{ old('room_type', $room->room_type) == 'Suite' ? 'selected' : '' }}>Suite</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Floor / Level</label>
                            <input type="number" name="floor" value="{{ old('floor', $room->floor) }}" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Capacity (Persons)</label>
                            <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Price per Night ($)</label>
                            <input type="number" step="0.01" name="price_per_night"
                                value="{{ old('price_per_night', $room->price_per_night) }}" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Status</label>
                            <select name="status" required
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 transition">
                                <option value="Available"
                                    {{ old('status', $room->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Booked" {{ old('status', $room->status) == 'Booked' ? 'selected' : '' }}>
                                    Booked</option>
                                <option value="Cleaning"
                                    {{ old('status', $room->status) == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                                <option value="Maintenance"
                                    {{ old('status', $room->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-100 space-x-4">
                        <a href="{{ route('rooms.index') }}"
                            class="px-6 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                            Cancel Changes
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-2 rounded-lg font-bold shadow-lg transition transform active:scale-95">
                            Update Room Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
