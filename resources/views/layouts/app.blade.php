<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RideCompare')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style> body { font-family: 'DM Sans', sans-serif; } </style>
 <style>
    * { font-family: 'Inter', sans-serif; }
    :root { --brand: #39C70D; }
    .bg-brand { background-color: #39C70D; }
    .text-brand { color: #39C70D; }
    .border-brand { border-color: #39C70D; }
    .hover-brand:hover { background-color: #2fa80b; }
</style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
                <a href="/" class="flex items-center space-x-2">
                <!-- OptiDrive Logo -->
              <a href="/" class="flex items-center space-x-2">
    <!-- OptiDrive Logo -->
    <div style="
        width:36px; height:36px;
        background:white;
        border:2px solid #39C70D;
        border-radius:9px;
        display:flex;
        align-items:center;
        justify-content:center;
    ">
        <div style="
            width:18px; height:18px;
            background:#39C70D;
            border-radius:50%;
        "></div>
    </div>
    <span style="font-size:18px; font-weight:700; color:#39C70D;">OptiDrive</span>
</a>
                    <span class="text-2xl">🚕</span>
                </a>
                <div class="flex items-center space-x-4">
                    @auth
                     <a href="{{ route('history.index') }}"
                     class="text-sm text-gray-600 hover:text-green-600 font-medium transition">
                     History
                       </a>
                        <span class="text-sm text-gray-600">
                            Hello, {{ auth()->user()->name ?? 'User' }} 👋
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm text-gray-600 hover:text-green-600 font-medium transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="text-sm bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

</body>
</html>