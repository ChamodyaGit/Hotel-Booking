<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $totalRooms = Room::count();
        // $availableRooms = Room::where('status', 'Available')->count();
        // $todayBookings = Booking::whereDate('created_at', today())->count();
        // $totalStaff = User::whereIn('role', ['manager', 'receptionist'])->count();

        // $recentBookings = Booking::with('room')->latest()->take(5)->get();

        // return view('dashboard.pages.dashboard.index', compact(
        //     'totalRooms',
        //     'availableRooms',
        //     'todayBookings',
        //     'totalStaff',
        //     'recentBookings'
        // ));
        return view('dashboard.pages.dashboard.index');
    }
}
