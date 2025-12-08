<!DOCTYPE html>
<html lang="sr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'EcoFlow - Sistem za upravljanje otpadom')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-white to-teal-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Mobile Menu Button -->
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center space-x-2 hover:opacity-80 transition-opacity duration-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent hidden sm:block">Eko Sistem</span>
                    </a>
                    
                    <!-- Desktop Navigation Links -->
                    <div class="hidden md:ml-8 md:flex md:space-x-1">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                            Početna
                        </a>
                        
                        <!-- Organizacija Dropdown -->
                        <div class="relative group" id="organizacija-dropdown">
                            <button class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 flex items-center {{ request()->routeIs('companies.*') || request()->routeIs('locations.*') || request()->routeIs('operators.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                                Organizacija
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="organizacija-menu" class="hidden absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                <a href="{{ route('companies.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('companies.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    Kompanije
                                </a>
                                <a href="{{ route('locations.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('locations.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    Lokacije
                                </a>
                                <a href="{{ route('operators.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('operators.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    Operateri
                                </a>
                            </div>
                        </div>
                        
                        <!-- Otpad Dropdown -->
                        <div class="relative group" id="otpad-dropdown">
                            <button class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 flex items-center {{ request()->routeIs('wastes.*') || request()->routeIs('pickups.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                                Otpad
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="otpad-menu" class="hidden absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                <a href="{{ route('wastes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('wastes.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    Evidencija otpada
                                </a>
                                <a href="{{ route('pickups.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('pickups.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    Preuzimanja
                                </a>
                            </div>
                        </div>
                        
                        <!-- Dokumentacija Dropdown -->
                        <div class="relative group" id="dokumentacija-dropdown">
                            <button class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 flex items-center {{ request()->routeIs('reports.*') || request()->routeIs('kpo.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                                Dokumentacija
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="dokumentacija-menu" class="hidden absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                <a href="{{ route('reports.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('reports.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    Izveštaji
                                </a>
                                <a href="{{ route('kpo.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ request()->routeIs('kpo.*') ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                    KPO knjiga
                                </a>
                            </div>
                        </div>
                        
                        <a href="#" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200">
                            Podešavanja
                        </a>
                    </div>
                </div>

                <!-- Right Side: User Info and Logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:block">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 text-sm font-medium hover:bg-gray-50 hover:text-emerald-600 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Odjavi se</span>
                            <span class="sm:hidden">Odjava</span>
                        </button>
                    </form>
                    
                    <!-- Mobile Menu Button -->
                    <button type="button" id="mobile-menu-button" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="close-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                    Početna
                </a>
                
                <!-- Organizacija Section -->
                <div class="pt-2">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Organizacija</div>
                    <a href="{{ route('companies.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('companies.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        Kompanije
                    </a>
                    <a href="{{ route('locations.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('locations.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        Lokacije
                    </a>
                    <a href="{{ route('operators.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('operators.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        Operateri
                    </a>
                </div>
                
                <!-- Otpad Section -->
                <div class="pt-2">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Otpad</div>
                    <a href="{{ route('wastes.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('wastes.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        Evidencija otpada
                    </a>
                    <a href="{{ route('pickups.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('pickups.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        Preuzimanja
                    </a>
                </div>
                
                <!-- Dokumentacija Section -->
                <div class="pt-2">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokumentacija</div>
                    <a href="{{ route('reports.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('reports.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        Izveštaji
                    </a>
                    <a href="{{ route('kpo.index') }}" class="block px-6 py-2 text-sm text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200 {{ request()->routeIs('kpo.*') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                        KPO knjiga
                    </a>
                </div>
                
                <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-200">
                    Podešavanja
                </a>
                <div class="pt-4 border-t border-gray-200">
                    <div class="px-3 py-2 text-sm font-medium text-gray-700">
                        {{ Auth::user()->name }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="p-6">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Dropdown and Mobile Menu Scripts -->
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Desktop Dropdown Menus
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = [
                { trigger: 'organizacija-dropdown', menu: 'organizacija-menu' },
                { trigger: 'otpad-dropdown', menu: 'otpad-menu' },
                { trigger: 'dokumentacija-dropdown', menu: 'dokumentacija-menu' }
            ];

            let hideTimeouts = {};

            dropdowns.forEach(function(dropdown) {
                const trigger = document.getElementById(dropdown.trigger);
                const menu = document.getElementById(dropdown.menu);

                if (trigger && menu) {
                    // Show dropdown on mouseenter
                    trigger.addEventListener('mouseenter', function() {
                        // Clear any pending hide timeout
                        if (hideTimeouts[dropdown.menu]) {
                            clearTimeout(hideTimeouts[dropdown.menu]);
                            delete hideTimeouts[dropdown.menu];
                        }
                        menu.classList.remove('hidden');
                    });

                    // Hide dropdown on mouseleave with delay
                    trigger.addEventListener('mouseleave', function() {
                        hideTimeouts[dropdown.menu] = setTimeout(function() {
                            menu.classList.add('hidden');
                        }, 200); // 200ms delay
                    });

                    // Keep dropdown open when mouse is over menu
                    menu.addEventListener('mouseenter', function() {
                        if (hideTimeouts[dropdown.menu]) {
                            clearTimeout(hideTimeouts[dropdown.menu]);
                            delete hideTimeouts[dropdown.menu];
                        }
                        menu.classList.remove('hidden');
                    });

                    // Hide dropdown when mouse leaves menu
                    menu.addEventListener('mouseleave', function() {
                        hideTimeouts[dropdown.menu] = setTimeout(function() {
                            menu.classList.add('hidden');
                        }, 200); // 200ms delay
                    });
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                dropdowns.forEach(function(dropdown) {
                    const trigger = document.getElementById(dropdown.trigger);
                    const menu = document.getElementById(dropdown.menu);
                    
                    if (trigger && menu && !trigger.contains(event.target) && !menu.contains(event.target)) {
                        if (hideTimeouts[dropdown.menu]) {
                            clearTimeout(hideTimeouts[dropdown.menu]);
                            delete hideTimeouts[dropdown.menu];
                        }
                        menu.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>
