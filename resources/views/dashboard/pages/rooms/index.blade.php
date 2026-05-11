@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Room Inventory</h1>
                <p class="text-sm text-gray-600">Manage all hotel rooms and their status.</p>
            </div>
            @if (auth()->user()->role === 'manager')
                <a href="{{ route('rooms.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center transition">
                    <i class="fa-solid fa-plus mr-2"></i> Add New Room
                </a>
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('rooms.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Room No</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ex: 101"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Type</label>
                        <select name="type" class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            <option value="">All Types</option>
                            <option value="Single" {{ request('type') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Double" {{ request('type') == 'Double' ? 'selected' : '' }}>Double</option>
                            <option value="Suite" {{ request('type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Status</label>
                        <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            <option value="">All Statuses</option>
                            <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                            <option value="Cleaning" {{ request('status') == 'Cleaning' ? 'selected' : '' }}>Cleaning
                            </option>
                            <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>
                                Maintenance</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">From Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">To Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                    <div class="flex space-x-4">
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Floor</label>
                            <input type="number" name="floor" value="{{ request('floor') }}" placeholder="Any"
                                class="w-20 px-2 py-1 border border-gray-200 rounded text-sm">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Min Capacity</label>
                            <input type="number" name="capacity" value="{{ request('capacity') }}" placeholder="Any"
                                class="w-24 px-2 py-1 border border-gray-200 rounded text-sm">
                        </div>
                    </div>

                    <div class="flex space-x-3 items-center">
                        @if (request()->anyFilled(['search', 'status', 'type', 'floor', 'capacity', 'start_date']))
                            <a href="{{ route('rooms.index') }}"
                                class="text-red-500 text-sm hover:underline font-medium">Clear All</a>
                        @endif
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i> Find Rooms
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Room No</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4 text-end">Floor</th>
                            <th class="px-6 py-4">Capacity</th>
                            <th class="px-6 py-4 text-end">Price</th>
                            <th class="px-6 py-4">Status</th>
                            @if (auth()->user()->role === 'manager')
                                <th class="px-6 py-4 text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($rooms as $room)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $room->room_number }}</td>
                                <td class="px-6 py-4">{{ $room->room_type }}</td>
                                <td class="px-6 py-4 text-gray-500 text-end">{{ $room->floor }}</td>
                                <td class="px-6 py-4">{{ $room->capacity }} Person(s)</td>
                                <td class="px-6 py-4 font-semibold text-end">
                                    ${{ number_format($room->price_per_night, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if ($room->status == 'Available')
                                        <span
                                            class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold uppercase">Available</span>
                                    @elseif($room->status == 'Booked')
                                        <span
                                            class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold uppercase">Booked</span>
                                    @elseif($room->status == 'Cleaning')
                                        <span
                                            class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-bold uppercase">Cleaning</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold uppercase">Maintenance</span>
                                    @endif
                                </td>
                                @if (auth()->user()->role === 'manager')
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('rooms.edit', $room->id) }}"
                                            class="text-blue-600 hover:text-blue-900">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                                            id="delete-form-{{ $room->id }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('{{ $room->id }}')"
                                                class="text-red-600 hover:text-red-900">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">No rooms found in
                                    the
                                    inventory.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-100">
                {{ $rooms->links() }}
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This room will be moved to the trash inventory!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
