@extends('dashboard.layouts.app')

@section('content')
    <main class="p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Booking Management</h1>
                <p class="text-sm text-gray-600">View and manage guest reservations and history.</p>
            </div>
            <a href="{{ route('bookings.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center transition">
                <i class="fa-solid fa-plus mr-2"></i> New Booking
            </a>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search guest name..."
                    class="border-gray-200 rounded-lg text-sm focus:ring-blue-500">

                <select name="status" class="border-gray-200 rounded-lg text-sm focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit"
                    class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition">
                    Search Bookings
                </button>

                @if (request()->has('search') || request()->has('status'))
                    <a href="{{ route('bookings.index') }}"
                        class="text-red-500 text-sm flex items-center hover:underline">Clear Filters</a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Guest Name</th>
                            <th class="px-6 py-4">Room No</th>
                            <th class="px-6 py-4">Check In</th>
                            <th class="px-6 py-4">Check Out</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Booked Date</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $booking->guest_name }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
                                        Room {{ $booking->room->room_number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($booking->status == 'Confirmed')
                                        <span class="text-blue-600 font-bold"><i class="fa-solid fa-circle-check mr-1"></i>
                                            Confirmed</span>
                                    @elseif($booking->status == 'Completed')
                                        <span class="text-green-600 font-bold"><i
                                                class="fa-solid fa-flag-checkered mr-1"></i> Completed</span>
                                    @else
                                        <span class="text-red-600 font-bold"><i class="fa-solid fa-circle-xmark mr-1"></i>
                                            Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">
                                    {{ $booking->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                            class="text-gray-600 hover:text-blue-600" title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        @if ($booking->status == 'Confirmed')
                                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
                                                id="cancel-form-{{ $booking->id }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" onclick="confirmCancel('{{ $booking->id }}')"
                                                    class="text-red-500 hover:text-red-700" title="Cancel Booking">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">No bookings found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-100">
                {{ $bookings->links() }}
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function confirmCancel(id) {
            Swal.fire({
                title: 'Cancel Reservation?',
                text: "This will cancel the booking and mark the room as Available.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
