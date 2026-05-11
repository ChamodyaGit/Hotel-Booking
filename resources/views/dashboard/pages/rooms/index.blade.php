@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Room Inventory</h1>
                <p class="text-sm text-gray-600">Manage all hotel rooms and their status.</p>
            </div>
            <a href="{{ route('rooms.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center transition">
                <i class="fa-solid fa-plus mr-2"></i> Add New Room
            </a>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search room number..."
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">

                <select name="status"
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700 bg-white">
                    <option value="">All Statuses</option>
                    <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Cleaning" {{ request('status') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                </select>

                <button type="submit"
                    class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition">
                    Filter Results
                </button>

                @if (request()->has('search') || request()->has('status'))
                    <a href="{{ route('rooms.index') }}"
                        class="text-red-500 text-sm flex items-center hover:underline">Clear All</a>
                @endif
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
                            <th class="px-6 py-4 text-center">Actions</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">No rooms found in the
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
