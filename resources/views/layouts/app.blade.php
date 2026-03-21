<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OptiDrive')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        :root { --brand: #39C70D; }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
             <a href="{{ route('settings') }}" class="text-sm text-gray-600 hover:text-green-600 font-medium transition">
             Settings
              </a>

                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2">
                    <div style="width:36px;height:36px;background:white;border:2px solid #39C70D;border-radius:9px;display:flex;align-items:center;justify-content:center;">
                        <div style="width:18px;height:18px;background:#39C70D;border-radius:50%;"></div>
                    </div>
                    <span style="font-size:18px;font-weight:700;color:#39C70D;">OptiDrive</span>
                </a>

                <!-- Nav links -->
                <div class="flex items-center space-x-4">
                    @auth
                        {{-- Bell icon with unread badge --}}
                        <a href="{{ route('notifications.index') }}" style="position:relative;display:flex;align-items:center;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            @php
                                $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                                    ->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span style="position:absolute;top:-6px;right:-6px;background:#39C70D;color:white;font-size:10px;font-weight:700;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('history.index') }}" class="text-sm text-gray-600 hover:text-green-600 font-medium transition">
                            History
                        </a>

                        <span class="text-sm text-gray-600">
                            Hello, {{ auth()->user()->name ?? 'User' }} 👋
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-green-600 font-medium transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="text-sm bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
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