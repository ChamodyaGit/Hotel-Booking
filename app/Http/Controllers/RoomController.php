<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);

            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(room_number) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(room_type) LIKE ?', ["%{$searchTerm}%"]);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->latest()->paginate(10);

        return view('dashboard.pages.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('dashboard.pages.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number|max:10',
            'room_type' => 'required|in:Single,Double,Suite',
            'floor' => 'required|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Cleaning,Maintenance',
        ]);

        Room::create($validated);

        Logger::log(
            'Create Room',
            'Rooms',
            "New room #{$request->room_number} ({$request->room_type}) was added to the inventory."
        );

        return redirect()->route('rooms.index')->with('success', 'Room has been added successfully!');
    }

    public function edit(Room $room)
    {
        return view('dashboard.pages.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|max:10|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|in:Single,Double,Suite',
            'floor' => 'required|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Booked,Cleaning,Maintenance',
        ]);

        $oldStatus = $room->status;
        $roomNumber = $room->room_number;

        $room->update($validated);

        $description = "Details updated for Room #{$roomNumber}.";
        if ($oldStatus !== $request->status) {
            $description .= " Status changed from '{$oldStatus}' to '{$request->status}'.";
        }

        Logger::log('Update Room', 'Rooms', $description);

        return redirect()->route('rooms.index')->with('success', 'Room details updated successfully!');
    }

    public function destroy(Room $room)
    {
        $roomNumber = $room->room_number;
        $room->delete();

        Logger::log(
            'Delete Room',
            'Rooms',
            "Room #{$roomNumber} was moved to trash (Soft Deleted)."
        );

        return redirect()->route('rooms.index')->with('success', 'Room has been moved to trash successfully!');
    }
}
