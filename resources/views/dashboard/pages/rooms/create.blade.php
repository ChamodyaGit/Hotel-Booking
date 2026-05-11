@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="max-w-3xl mx-auto">
            <a href="{{ route('rooms.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block italic">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Inventory
            </a>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-2">
                <div class="p-6 border-b border-gray-100">
                    <h1 class="text-xl font-bold text-gray-800">Add New Room</h1>
                    <p class="text-sm text-gray-500">Fill in the details to register a new room in the system.</p>
                </div>

                <form action="{{ route('rooms.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Room Number</label>
                            <input type="text" name="room_number"
                                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white"
                                placeholder="e.g. 101, B-204">
                            @error('room_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Room Type</label>
                            <select name="room_type" required class="block w-full px-4 py-2 mt-1 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                                <option value="Suite">Suite</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Floor</label>
                            <input type="number" name="floor" placeholder="Enter floor number" required
                                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Capacity</label>
                            <input type="number" name="capacity" placeholder="Enter capacity" required
                                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Price per Night ($)</label>
                            <input type="number" step="0.01" name="price_per_night" placeholder="Enter price per night"
                                required class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Initial Status</label>
                            <select name="status" required class="block w-full px-4 py-2 mt-1 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700">
                                <option value="Available">Available</option>
                                <option value="Cleaning">Cleaning</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="reset" class="px-6 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 mr-4">
                            Clear Form
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg font-bold shadow-md transition">
                            Save Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
