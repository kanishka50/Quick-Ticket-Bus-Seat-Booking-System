<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QuickTicket - Bus Ticket Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 border-b border-white/5">
        <div class="container mx-auto px-4 max-w-7xl">
            <nav class="flex justify-between items-center py-3.5">
                <!-- Logo -->
                <a href="/" class="text-xl font-bold tracking-tight">
                    <span class="text-accent">Quick</span><span class="text-white">Ticket</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-7">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Home</a>
                    <a href="{{ route('pages.about') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">About</a>
                    <a href="{{ route('pages.contact') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Contact</a>
                    @auth
                        @if(auth()->user()->user_type == 'provider')
                            <a href="{{ route('provider.dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        @elseif(auth()->user()->user_type == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        @elseif(auth()->user()->user_type == 'driver')
                            <a href="{{ route('driver.dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        @endif
                    @endauth
                </div>

                <!-- Auth Links -->
                <div class="hidden md:flex space-x-3 items-center">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md border border-slate-600 text-slate-300 text-sm font-medium hover:bg-slate-800 hover:text-white transition-all">Log In</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-accent text-slate-900 text-sm font-semibold hover:bg-accent-dark transition-all">Sign Up</a>
                    @else
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profile-dropdown-button" class="flex items-center space-x-2 focus:outline-none rounded-md p-1.5 hover:bg-slate-800 transition-colors duration-200">
                                <div class="w-8 h-8 bg-primary rounded-md flex items-center justify-center text-white overflow-hidden">
                                    @if(auth()->user()->profile_image)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <span class="hidden md:block text-sm font-medium text-slate-300">{{ auth()->user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-1 z-50 border border-slate-100">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-1">
                                    @if(auth()->user()->user_type == 'provider')
                                    <a href="{{ route('provider.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        My Profile
                                    </a>
                                    @elseif(auth()->user()->user_type == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        My Profile
                                    </a>
                                    @elseif(auth()->user()->user_type == 'driver')
                                    <a href="{{ route('driver.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        My Profile
                                    </a>
                                    @else
                                    <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    @endif
                                    <form action="{{ route('logout') }}" method="POST" class="block w-full text-left">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-xl text-white" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="fixed inset-0 bg-slate-900 transform -translate-x-full transition-transform duration-300 z-50 md:hidden" id="mobile-menu">
        <div class="p-6">
            <div class="flex justify-between items-center mb-10">
                <a href="/" class="text-xl font-bold tracking-tight">
                    <span class="text-accent">Quick</span><span class="text-white">Ticket</span>
                </a>
                <button class="text-xl text-slate-400 hover:text-white" id="close-menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="flex flex-col space-y-5">
                <a href="{{ route('home') }}" class="text-base font-medium text-white transition-colors">Home</a>
                <a href="{{ route('pages.about') }}" class="text-base font-medium text-slate-300 hover:text-white transition-colors">About</a>
                <a href="{{ route('pages.contact') }}" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Contact</a>
                @auth
                    @if(auth()->user()->user_type == 'provider')
                        <a href="{{ route('provider.dashboard') }}" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    @elseif(auth()->user()->user_type == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    @elseif(auth()->user()->user_type == 'driver')
                        <a href="{{ route('driver.dashboard') }}" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    @endif
                @endauth
            </div>
            <div class="flex flex-col space-y-3 mt-10">
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-md border border-slate-600 text-slate-300 font-medium text-center hover:bg-slate-800">Log In</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-md bg-accent text-slate-900 font-semibold text-center">Sign Up</a>
                @else
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 rounded-md border border-slate-600 text-slate-300 font-medium text-center w-full hover:bg-slate-800">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 max-w-7xl mt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md text-sm flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fas fa-times"></i></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 max-w-7xl mt-4">
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-md text-sm flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fas fa-times"></i></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 mt-auto">
        <div class="container mx-auto px-4 max-w-7xl py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- Logo -->
                <a href="/" class="text-lg font-bold tracking-tight">
                    <span class="text-accent">Quick</span><span class="text-white">Ticket</span>
                </a>

                <!-- Links -->
                <nav class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                    <a href="{{ route('pages.about') }}" class="text-sm text-slate-400 hover:text-white transition-colors">About Us</a>
                    <a href="{{ route('pages.privacy') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="{{ route('pages.terms') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="{{ route('pages.contact') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Contact Us</a>
                </nav>

                <!-- Social -->
                <div class="flex space-x-2">
                    <a href="#" class="w-8 h-8 bg-slate-800 rounded-md flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-slate-800 rounded-md flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <i class="fab fa-twitter text-xs"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-slate-800 rounded-md flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                        <i class="fab fa-instagram text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-6 pt-6 text-center">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} QuickTicket. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    @include('partials.chatbot')

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuClose = document.getElementById('close-menu');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('-translate-x-full');
        });

        mobileMenuClose.addEventListener('click', () => {
            mobileMenu.classList.add('-translate-x-full');
        });

        // Profile Dropdown Toggle
        const profileDropdownButton = document.getElementById('profile-dropdown-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileDropdownButton) {
            profileDropdownButton.addEventListener('click', () => {
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!profileDropdownButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
