<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isOpen: true }" x-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Canteen Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for sidebar toggle -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- Optionally include a navigation bar --}}
        @include('layouts.navigation')

        <!-- Page Content -->
        <div class="min-h-screen flex" style="background-image: url('/icons/cit.png'); background-repeat: repeat; background-size: auto; background-position: center; min-height: 100vh;">
            <!-- Sidebar -->
            <aside class="bg-white shadow-md min-h-screen transition-all duration-300"
                :class="isOpen ? 'w-1/7' : 'w-20'" style="background-color: #000;">
                <ul class="space-y-4 mt-4">
                    <li class="mt-5 mx-5">
                        <a href="{{ route('dashboard') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            <span x-show="isOpen" x-transition>Dashboard</span>
                        </a>
                    </li>
                    <li class="mt-5 mx-5">
                        <a href="{{ route('canteen.shows.index') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span x-show="isOpen" x-transition>Shows</span>
                        </a>
                    </li>
                    <li class="mt-5 mx-5">
                        <a href="{{ route('canteen.products.index') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-box-open mr-2"></i>
                            <span x-show="isOpen" x-transition>Products</span>
                        </a>
                    </li>
                    <li class="mt-5 mx-5">
                        <a href="{{ route('canteen.inventory.selectShow') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-warehouse mr-2"></i>
                            <span x-show="isOpen" x-transition>Inventory</span>
                        </a>
                    </li>
                    <li class="mt-5 mx-5">
                        <a href="{{ route('canteen.transactions.index') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-money-check-alt mr-2"></i>
                            <span x-show="isOpen" x-transition>Transactions</span>
                        </a>
                    </li>
                    <li class="mt-5 mx-5">
                        <a href="{{ route('canteen.inside_inventory.index') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-money-check-alt mr-2"></i>
                            <span x-show="isOpen" x-transition>Inside Consumption</span>
                        </a>
                    </li>
                    @if(Auth::user()->usertype === 'super_admin')
                    <li class="mt-5 mx-5">
                        <a href="{{ route('superadmin.dashboard') }}" class="flex items-center text-white hover:text-gray-300 px-4 py-2">
                            <i class="fas fa-tools mr-2"></i>
                            <span x-show="isOpen" x-transition>Super Admin</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="p-6 transition-all duration-300" :class="isOpen ? 'w-6/7' : 'flex-1'" style="background-color: #f7f9f9;">
                <main class="w-[1200px] mx-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</body>
</html>
