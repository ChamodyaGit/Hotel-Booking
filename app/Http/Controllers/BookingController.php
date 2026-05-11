<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room');

        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(guest_name) LIKE ?', ["%{$searchTerm}%"]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);

        return view('dashboard.pages.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'Available')->get();
        return view('dashboard.pages.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $roomId = $request->room_id;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        $room = Room::findOrFail($roomId);
        if ($room->status === 'Cleaning') {
            return back()->withInput()->with('error', 'This room is currently being cleaned. Please wait until it is ready.');
        }

        if ($room->status === 'Maintenance') {
            return back()->withInput()->with('error', 'This room is under maintenance and cannot be booked.');
        }

        $isAlreadyBooked = Booking::where('room_id', $roomId)
            ->where('status', 'Confirmed')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '>=', $checkIn)
                        ->where('check_in', '<', $checkOut);
                })->orWhere(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_out', '>', $checkIn)
                        ->where('check_out', '<=', $checkOut);
                })->orWhere(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<=', $checkIn)
                        ->where('check_out', '>=', $checkOut);
                });
            })->exists();

        if ($isAlreadyBooked) {
            return back()->withInput()->with('error', 'Double-booking detected! This room is already reserved for the selected dates.');
        }

        DB::transaction(function () use ($request, $room) {
            Booking::create([
                'room_id' => $request->room_id,
                'guest_name' => $request->guest_name,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'status' => 'Confirmed',
            ]);

            $room->update(['status' => 'Booked']);
        });

        return redirect()->route('bookings.index')->with('success', 'Reservation confirmed successfully!');
    }

    public function show(Booking $booking)
    {
        $booking->load('room');
        return view('dashboard.pages.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'Only confirmed bookings can be cancelled.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'Cancelled']);
            $booking->room->update(['status' => 'Available']);
        });

        return redirect()->route('bookings.index')->with('success', 'Booking has been cancelled and the room is now available.');
    }
}
