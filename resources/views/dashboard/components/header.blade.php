<header class="bg-white shadow-sm border-b h-16 flex items-center justify-between px-8">
    <div class="flex items-center">
        <button class="md:hidden mr-4 text-gray-600">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Overview</h2>
    </div>

    <div class="flex items-center space-x-4">
        <div class="text-right hidden sm:block px-2">
            <p class="text-sm font-medium text-gray-900">
                {{ auth()->user()->name }}
            </p>
            <p class="text-xs text-gray-500 capitalize">
                {{ auth()->user()->role }}
            </p>
        </div>
        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
            CP
        </div>
    </div>
</header>
