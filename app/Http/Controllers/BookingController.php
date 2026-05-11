<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::withTrashed()->with([
            'room' => function ($q) {
                $q->withTrashed();
            }
        ]);

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
            'contact_number' => 'required|string|max:15',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $roomId = $request->room_id;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        $room = Room::findOrFail($roomId);

        if ($room->status === 'Cleaning' || $room->status === 'Maintenance') {
            Logger::log(
                'Booking Denied',
                'Bookings',
                "Booking attempt failed for Room #{$room->room_number} due to status: {$room->status}."
            );
            return back()->withInput()->with('error', "This room is currently under {$room->status} and cannot be booked.");
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
            Logger::log(
                'Overlap Detected',
                'Bookings',
                "System blocked a double-booking attempt for Room #{$room->room_number} on {$checkIn} to {$checkOut}."
            );
            return back()->withInput()->with('error', 'Double-booking detected! This room is already reserved for the selected dates.');
        }

        DB::transaction(function () use ($request, $room) {
            Booking::create([
                'room_id' => $request->room_id,
                'guest_name' => $request->guest_name,
                'contact_number' => $request->contact_number,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'status' => 'Confirmed',
            ]);

            $room->update(['status' => 'Booked']);

            Logger::log(
                'New Booking',
                'Bookings',
                "Room #{$room->room_number} booked for '{$request->guest_name}' from {$request->check_in} to {$request->check_out}."
            );
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

            Logger::log(
                'Booking Cancelled',
                'Bookings',
                "Booking for '{$booking->guest_name}' (Room #{$booking->room->room_number}) was cancelled by user."
            );
        });

        return redirect()->route('bookings.index')->with('success', 'Booking has been cancelled and the room is now available.');
    }
}
