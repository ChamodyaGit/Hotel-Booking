<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $availableRoomsNow = Room::where('status', 'Available')->count();

        $today = Carbon::today();
        $todaysBookingsCount = Booking::whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>=', $today)
            ->where('status', 'Confirmed')
            ->count();
        $expectedCheckIns = Booking::whereDate('check_in', $today)
            ->where('status', 'Confirmed')
            ->count();

        $activeStaff = User::count();

        $upcomingBookings = Booking::with('room')
            ->where('check_in', '>=', $today)
            ->where('status', 'Confirmed')
            ->orderBy('check_in', 'asc')
            ->take(5)
            ->get();

        return view('dashboard.pages.dashboard.index', compact(
            'totalRooms',
            'availableRoomsNow',
            'todaysBookingsCount',
            'expectedCheckIns',
            'activeStaff',
            'upcomingBookings'
        ));
    }
}
