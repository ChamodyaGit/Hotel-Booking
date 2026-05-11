<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

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
}
