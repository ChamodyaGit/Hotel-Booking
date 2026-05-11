<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room Booking System</title>
    @include('dashboard.libraries.styles')
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        @include('dashboard.components.sidebar')

        <div class="flex-1 flex flex-col overflow-y-auto">

            @include('dashboard.components.header')

            @yield('content')

        </div>
    </div>

    @include('dashboard.libraries.scripts')

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563eb', // Blue-600
                timer: 3000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626', // Red-600
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: "Please check the form for errors and try again.",
                confirmButtonColor: '#f59e0b', // Amber-500
            });
        </script>
    @endif
</body>

</html>
