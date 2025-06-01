<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Tailwind CSS via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- Include Vite assets if you are using Vite for frontend (React/Vue etc) --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Custom Styles --}}
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a class="font-semibold text-xl text-gray-800" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div>
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 mr-4">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
                    @endif
                @else
                    <a href="{{ route('admin.roles.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Manage Roles</a> 
                    <a href="{{ route('admin.permissions.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Manage Permissions</a>
                    <span class="text-gray-600 mr-4">{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-gray-600 hover:text-gray-800">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    {{-- Custom Scripts --}}
    @stack('scripts')
</body>
</html> 