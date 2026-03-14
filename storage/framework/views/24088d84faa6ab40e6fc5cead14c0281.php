<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>QuickTicket - Bus Ticket Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-surface font-sans text-slate-800">

    <!-- Header -->
    <header class="bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 border-b border-white/5">
        <div class="container mx-auto px-4 max-w-7xl">
            <nav class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="/" class="text-xl font-bold tracking-tight">
                    <span class="text-accent">Quick</span><span class="text-white">Ticket</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-7">
                    <a href="<?php echo e(route('home')); ?>" class="text-sm font-medium text-white transition-colors">Home</a>
                    <a href="<?php echo e(route('pages.about')); ?>" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">About</a>
                    <a href="<?php echo e(route('pages.contact')); ?>" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Contact</a>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->user_type == 'provider'): ?>
                            <a href="<?php echo e(route('provider.dashboard')); ?>" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        <?php elseif(auth()->user()->user_type == 'admin'): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Auth Links -->
                <div class="hidden md:flex space-x-3 items-center">
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 rounded-md border border-slate-600 text-slate-300 text-sm font-medium hover:bg-slate-800 hover:text-white transition-all">Log In</a>
                        <a href="<?php echo e(route('register')); ?>" class="px-4 py-2 rounded-md bg-accent text-slate-900 text-sm font-semibold hover:bg-accent-dark transition-all">Sign Up</a>
                    <?php else: ?>
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profile-dropdown-button" class="flex items-center space-x-2 focus:outline-none rounded-md p-1.5 hover:bg-slate-800 transition-colors duration-200">
                                <div class="w-8 h-8 bg-primary rounded-md flex items-center justify-center text-white overflow-hidden">
                                    <?php if(auth()->user()->profile_image): ?>
                                        <img src="<?php echo e(asset('storage/' . auth()->user()->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <span class="text-sm font-medium"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-slate-300"><?php echo e(auth()->user()->name); ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-1 z-50 border border-slate-100">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-900"><?php echo e(auth()->user()->name); ?></p>
                                    <p class="text-xs text-slate-500 truncate"><?php echo e(auth()->user()->email); ?></p>
                                </div>
                                <div class="py-1">
                                    <?php if(auth()->user()->user_type == 'provider'): ?>
                                    <a href="<?php echo e(route('provider.dashboard')); ?>" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <?php elseif(auth()->user()->user_type == 'admin'): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <?php else: ?>
                                    <a href="<?php echo e(route('user.dashboard')); ?>" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="block w-full text-left">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
                <a href="<?php echo e(route('home')); ?>" class="text-base font-medium text-white transition-colors">Home</a>
                <a href="<?php echo e(route('pages.about')); ?>" class="text-base font-medium text-slate-300 hover:text-white transition-colors">About</a>
                <a href="<?php echo e(route('pages.contact')); ?>" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Contact</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->user_type == 'provider'): ?>
                        <a href="<?php echo e(route('provider.dashboard')); ?>" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    <?php elseif(auth()->user()->user_type == 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="text-base font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col space-y-3 mt-10">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="px-5 py-2.5 rounded-md border border-slate-600 text-slate-300 font-medium text-center hover:bg-slate-800">Log In</a>
                    <a href="<?php echo e(route('register')); ?>" class="px-5 py-2.5 rounded-md bg-accent text-slate-900 font-semibold text-center">Sign Up</a>
                <?php else: ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-5 py-2.5 rounded-md border border-slate-600 text-slate-300 font-medium text-center w-full">Logout</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-slate-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="<?php echo e(asset('storage/images/hero-bg1.png')); ?>" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-900/70"></div>
        </div>

        <div class="relative container mx-auto px-4 max-w-7xl py-28 md:py-36">
            <div class="max-w-2xl">
                <span class="inline-block px-3 py-1 text-xs font-semibold text-accent bg-accent/10 rounded-md mb-6 tracking-wide uppercase">Sri Lanka's Bus Booking Platform</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    Book Your Bus<br>Journey Today
                </h1>
                <p class="text-lg text-slate-300 mb-8 leading-relaxed">
                    Travel anywhere across Sri Lanka with comfort and convenience. Search routes, pick your seats, and book tickets instantly.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#search-section" class="px-6 py-3 bg-accent text-slate-900 font-semibold rounded-md hover:bg-accent-dark transition-all text-sm">
                        <i class="fas fa-search mr-2"></i>Search Buses
                    </a>
                    <a href="<?php echo e(route('pages.about')); ?>" class="px-6 py-3 border border-slate-500 text-slate-300 font-medium rounded-md hover:bg-white/5 transition-all text-sm">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 grid grid-cols-3 gap-6 max-w-lg">
                <div>
                    <p class="text-2xl font-bold text-white">500+</p>
                    <p class="text-sm text-slate-400">Daily Trips</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">50+</p>
                    <p class="text-sm text-slate-400">Routes</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">10K+</p>
                    <p class="text-sm text-slate-400">Happy Travelers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Form -->
    <section id="search-section" class="relative z-20 -mt-10">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-lg shadow-xl p-6 md:p-8 border border-slate-100">
                <form action="<?php echo e(route('search')); ?>" method="GET">
                    <div class="grid md:grid-cols-3 gap-5 mb-5">
                        <div>
                            <label for="origin" class="block mb-1.5 text-sm font-medium text-slate-700">From</label>
                            <div class="relative">
                                <i class="fas fa-map-pin absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <select id="origin" name="origin" required class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white">
                                    <option value="" disabled selected>Select departure</option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="destination" class="block mb-1.5 text-sm font-medium text-slate-700">To</label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <select id="destination" name="destination" required class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white">
                                    <option value="" disabled selected>Select arrival</option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="date" class="block mb-1.5 text-sm font-medium text-slate-700">Date</label>
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="date" id="date" name="date" required class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-md transition-all text-sm">
                        <i class="fas fa-search mr-2"></i>Search Available Buses
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-14">
                <span class="text-xs font-semibold text-primary uppercase tracking-wider">Why QuickTicket</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2 mb-3">Everything You Need for a Great Trip</h2>
                <p class="text-slate-500 max-w-xl mx-auto text-sm">We provide the best bus booking experience with features designed for your comfort and convenience.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-7 rounded-lg border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 bg-primary/10 rounded-lg flex items-center justify-center mb-5">
                        <i class="fas fa-ticket-alt text-primary text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Easy Booking</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Book your tickets with just a few clicks. Our intuitive platform makes booking quick and hassle-free.</p>
                </div>
                <div class="bg-white p-7 rounded-lg border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 bg-emerald-500/10 rounded-lg flex items-center justify-center mb-5">
                        <i class="fas fa-map-marked-alt text-emerald-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Multiple Routes</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Choose from hundreds of routes across the country. We connect all major cities and towns.</p>
                </div>
                <div class="bg-white p-7 rounded-lg border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 bg-amber-500/10 rounded-lg flex items-center justify-center mb-5">
                        <i class="fas fa-couch text-amber-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Seat Selection</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pick your favorite seat in advance. View the bus layout and choose the most comfortable spot.</p>
                </div>
                <div class="bg-white p-7 rounded-lg border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 bg-rose-500/10 rounded-lg flex items-center justify-center mb-5">
                        <i class="fas fa-map-marker-alt text-rose-500 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Live Tracking</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Track your bus in real-time on a live map. Know exactly where your bus is and when it'll arrive.</p>
                </div>
                <div class="bg-white p-7 rounded-lg border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 bg-sky-500/10 rounded-lg flex items-center justify-center mb-5">
                        <i class="fas fa-shield-alt text-sky-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Secure Payments</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pay securely via PayHere with Visa, MasterCard, bank transfer, or mobile payment options.</p>
                </div>
                <div class="bg-white p-7 rounded-lg border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 bg-violet-500/10 rounded-lg flex items-center justify-center mb-5">
                        <i class="fas fa-headset text-violet-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">24/7 Support</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Our AI chatbot and support team are always available to help you with any questions or issues.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-14">
                <span class="text-xs font-semibold text-primary uppercase tracking-wider">Simple Process</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2 mb-3">How It Works</h2>
                <p class="text-slate-500 max-w-xl mx-auto text-sm">Book your bus ticket in 4 simple steps.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 bg-primary text-white rounded-lg flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                    <h3 class="font-semibold text-slate-900 mb-1">Search</h3>
                    <p class="text-sm text-slate-500">Select your route and travel date</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-primary text-white rounded-lg flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                    <h3 class="font-semibold text-slate-900 mb-1">Choose</h3>
                    <p class="text-sm text-slate-500">Pick your preferred bus and schedule</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-primary text-white rounded-lg flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                    <h3 class="font-semibold text-slate-900 mb-1">Select Seats</h3>
                    <p class="text-sm text-slate-500">Choose your seats from the layout</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-accent text-slate-900 rounded-lg flex items-center justify-center mx-auto mb-4 text-xl font-bold">4</div>
                    <h3 class="font-semibold text-slate-900 mb-1">Pay & Go</h3>
                    <p class="text-sm text-slate-500">Complete payment and you're set</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Routes Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-14">
                <span class="text-xs font-semibold text-primary uppercase tracking-wider">Top Destinations</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2 mb-3">Popular Routes</h2>
                <p class="text-slate-500 max-w-xl mx-auto text-sm">Explore our most popular routes with competitive prices and frequent departures.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Colombo to Kandy -->
                <div class="bg-white rounded-lg overflow-hidden border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                    <div class="h-44 bg-slate-200 overflow-hidden">
                        <img src="<?php echo e(asset('storage/images/colombo-kandy.jpg')); ?>" alt="Colombo to Kandy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-sm font-semibold text-slate-900">
                                <span>Colombo</span>
                                <i class="fas fa-arrow-right mx-2 text-primary text-xs"></i>
                                <span>Kandy</span>
                            </div>
                            <span class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i>3.5 hrs</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">LKR 750</span>
                            <a href="#search-section" class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-md hover:bg-primary hover:text-white transition-all">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Colombo to Galle -->
                <div class="bg-white rounded-lg overflow-hidden border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                    <div class="h-44 bg-slate-200 overflow-hidden">
                        <img src="<?php echo e(asset('storage/images/colombo-galle.jpg')); ?>" alt="Colombo to Galle" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-sm font-semibold text-slate-900">
                                <span>Colombo</span>
                                <i class="fas fa-arrow-right mx-2 text-primary text-xs"></i>
                                <span>Galle</span>
                            </div>
                            <span class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i>2.5 hrs</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">LKR 650</span>
                            <a href="#search-section" class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-md hover:bg-primary hover:text-white transition-all">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Kandy to Nuwara Eliya -->
                <div class="bg-white rounded-lg overflow-hidden border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                    <div class="h-44 bg-slate-200 overflow-hidden">
                        <img src="<?php echo e(asset('storage/images/kandy-nuwara-eliya.jpg')); ?>" alt="Kandy to Nuwara Eliya" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-sm font-semibold text-slate-900">
                                <span>Kandy</span>
                                <i class="fas fa-arrow-right mx-2 text-primary text-xs"></i>
                                <span>Nuwara Eliya</span>
                            </div>
                            <span class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i>2 hrs</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">LKR 550</span>
                            <a href="#search-section" class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-md hover:bg-primary hover:text-white transition-all">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-14">
                <span class="text-xs font-semibold text-primary uppercase tracking-wider">Testimonials</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2 mb-3">What Our Customers Say</h2>
                <p class="text-slate-500 max-w-xl mx-auto text-sm">Read about the experiences of our happy travelers.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-1 mb-4">
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-5">"The booking process was incredibly easy. I got my ticket instantly and the journey was very comfortable. Will definitely use QuickTicket again!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-md overflow-hidden mr-3 bg-slate-200">
                            <img src="<?php echo e(asset('storage/images/rajiv-perera.jpg')); ?>" alt="Rajiv Perera" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Rajiv Perera</h4>
                            <p class="text-xs text-slate-400">Regular Traveler</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-1 mb-4">
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-5">"I was surprised by how clean and comfortable the bus was. The staff was friendly and the whole journey was enjoyable. Great service!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-md overflow-hidden mr-3 bg-slate-200">
                            <img src="<?php echo e(asset('storage/images/amali-fernando.jpeg')); ?>" alt="Amali Fernando" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Amali Fernando</h4>
                            <p class="text-xs text-slate-400">Business Traveler</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-1 mb-4">
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        <i class="fas fa-star-half-alt text-amber-400 text-sm"></i>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-5">"The ability to choose my seat online was fantastic! The bus arrived on time and the journey was smooth. I recommend QuickTicket to everyone!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-md overflow-hidden mr-3 bg-slate-200">
                            <img src="<?php echo e(asset('storage/images/mahesh-silva.jpeg')); ?>" alt="Mahesh Silva" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Mahesh Silva</h4>
                            <p class="text-xs text-slate-400">Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 max-w-7xl text-center relative">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your Journey?</h2>
            <p class="text-slate-400 max-w-lg mx-auto mb-8 text-sm">Join thousands of travelers who book their bus tickets with QuickTicket. Sign up today and enjoy hassle-free travel.</p>
            <div class="flex justify-center gap-3">
                <a href="<?php echo e(route('register')); ?>" class="px-6 py-3 bg-accent text-slate-900 font-semibold rounded-md hover:bg-accent-dark transition-all text-sm">
                    Sign Up Free
                </a>
                <a href="#search-section" class="px-6 py-3 border border-slate-600 text-slate-300 font-medium rounded-md hover:bg-white/5 transition-all text-sm">
                    Search Buses
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 pt-14 pb-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div>
                    <a href="/" class="text-xl font-bold tracking-tight mb-4 inline-block">
                        <span class="text-accent">Quick</span><span class="text-white">Ticket</span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed mb-5">Your trusted partner for convenient bus ticket booking across Sri Lanka.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-9 h-9 bg-slate-800 rounded-md flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all"><i class="fab fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 rounded-md flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all"><i class="fab fa-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 rounded-md flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all"><i class="fab fa-instagram text-sm"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h3>
                    <ul class="space-y-2.5">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-sm text-slate-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="<?php echo e(route('pages.about')); ?>" class="text-sm text-slate-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="<?php echo e(route('pages.contact')); ?>" class="text-sm text-slate-400 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Support</h3>
                    <ul class="space-y-2.5">
                        <li><a href="<?php echo e(route('pages.terms')); ?>" class="text-sm text-slate-400 hover:text-white transition-colors">Terms & Conditions</a></li>
                        <li><a href="<?php echo e(route('pages.privacy')); ?>" class="text-sm text-slate-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="<?php echo e(route('pages.contact')); ?>" class="text-sm text-slate-400 hover:text-white transition-colors">Help Center</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</h3>
                    <ul class="space-y-2.5">
                        <li class="flex items-start text-sm text-slate-400">
                            <i class="fas fa-map-marker-alt mt-0.5 mr-2.5 text-slate-500"></i>
                            <span>123 Main Street, Colombo</span>
                        </li>
                        <li class="flex items-start text-sm text-slate-400">
                            <i class="fas fa-phone mt-0.5 mr-2.5 text-slate-500"></i>
                            <span>+94 11 234 5678</span>
                        </li>
                        <li class="flex items-start text-sm text-slate-400">
                            <i class="fas fa-envelope mt-0.5 mr-2.5 text-slate-500"></i>
                            <span>info@quickticket.lk</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 text-center">
                <p class="text-sm text-slate-500">&copy; <?php echo e(date('Y')); ?> QuickTicket. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

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

        // Date Input Min Date (Today) — use local date, not UTC
        const dateInput = document.getElementById('date');
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;
        dateInput.min = formattedDate;
        dateInput.value = formattedDate;

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>

    <?php echo $__env->make('partials.chatbot', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>
<?php /**PATH H:\bus-ticket-booking-system\resources\views/home.blade.php ENDPATH**/ ?>