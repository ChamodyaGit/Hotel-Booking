<aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
    <div class="p-6 text-2xl font-bold border-b border-slate-800">
        <span class="text-blue-400 text-3xl mr-2">H</span>Booking
    </div>

    <nav class="flex-1 mt-6 px-4 space-y-2">
        <a href="{{ route('dashboard') }}"
            class="flex items-center p-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <i class="fa-solid fa-gauge mr-3 w-5"></i> Dashboard
        </a>

        {{-- @if (auth()->user()->role == 'manager' || auth()->user()->role == 'receptionist') --}}
            <a href="{{ route('rooms.index') }}"
                class="flex items-center p-3 rounded-lg {{ request()->routeIs('rooms.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                <i class="fa-solid fa-bed mr-3 w-5"></i> Room Inventory
            </a>
        {{-- @endif --}}

        {{-- @if (auth()->user()->role == 'manager' || auth()->user()->role == 'receptionist') --}}
            <div class="pt-4 pb-1">
                <p class="text-xs font-semibold text-slate-500 uppercase px-3 tracking-wider">Reservations</p>
            </div>
            <a href="{{ route('bookings.index') }}"
                class="flex items-center p-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-calendar-check mr-3 w-5"></i> All Bookings
            </a>
            <a href="{{ route('bookings.create') }}"
                class="flex items-center p-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition ">
                <i class="fa-solid fa-plus-circle mr-3 w-5"></i> New Booking
            </a>
        {{-- @endif --}}

        {{-- @if (auth()->user()->role == 'admin') --}}
            <div class="pt-4 pb-1">
                <p class="text-xs font-semibold text-slate-500 uppercase px-3 tracking-wider">Admin Tools</p>
            </div>
            <a href="#"
                class="flex items-center p-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-users-gear mr-3 w-5"></i> User Management
            </a>
            <a href="#"
                class="flex items-center p-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-clock-rotate-left mr-3 w-5"></i> Audit Trails
            </a>
        {{-- @endif --}}

        <div class="pt-4 pb-1">
            <p class="text-xs font-semibold text-slate-500 uppercase px-3 tracking-wider">System</p>
        </div>
        <a href="{{ route('profile.show') }}"
            class="flex items-center p-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
            <i class="fa-solid fa-user-circle mr-3 w-5"></i> My Profile
        </a>

        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit"
                class="w-full flex items-center p-3 rounded-lg text-red-400 hover:bg-red-900/20 hover:text-red-300 transition">
                <i class="fa-solid fa-right-from-bracket mr-3 w-5"></i> Logout
            </button>
        </form>
    </nav>
</aside>
