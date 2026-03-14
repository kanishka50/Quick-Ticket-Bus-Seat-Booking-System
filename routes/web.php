<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleDateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverAssignmentController;
use App\Http\Controllers\DriverTrackingController;
use App\Http\Controllers\TrackingController;

use App\Http\Controllers\PageController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProviderController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\AdminBookingController;

// ─── Public Routes ───────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');

// ─── Authentication Routes ───────────────────────────────────────────────────

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification
Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// ─── PayHere Payment Callbacks (no auth) ─────────────────────────────────────

Route::post('/payment/notify', [PaymentController::class, 'processPayHerePayment'])
    ->name('payment.notify')
    ->withoutMiddleware(['web', 'csrf']);

Route::get('/payment/return', [PaymentController::class, 'paymentReturn'])
    ->name('payment.return')
    ->middleware('web');

// ─── Authenticated Routes ────────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // User Dashboard & Notifications
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/notifications', [UserDashboardController::class, 'allNotifications'])->name('user.notifications');
    Route::get('/user-bookings', [UserDashboardController::class, 'allBookings'])->name('user.bookings');
    Route::post('/notifications/{id}/mark-read', [UserDashboardController::class, 'markNotificationAsRead'])->name('user.notifications.mark-read');
    Route::post('/notifications/mark-all-read', [UserDashboardController::class, 'markAllNotificationsAsRead'])->name('user.notifications.mark-all-read');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    });

    // Booking
    Route::get('/book/{schedule}', [BookingController::class, 'show'])->name('book');
    Route::post('/book/{schedule}', [BookingController::class, 'store'])->name('book.store');
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');

    // Payment
    Route::get('/payment/success/{booking}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/{booking}/print', [PaymentController::class, 'printReceipt'])->name('payment.print');
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');

    // Live Tracking (Customer)
    Route::get('/tracking/{booking}', [TrackingController::class, 'track'])->name('tracking.show');
    Route::get('/api/tracking/{scheduleDateId}', [DriverTrackingController::class, 'getLocation'])->name('tracking.api');
});

// ─── Provider Routes ─────────────────────────────────────────────────────────

// Onboarding and pending status (auth only — no provider middleware)
Route::middleware(['auth'])->prefix('provider')->group(function () {
    Route::get('/onboarding', [ProviderController::class, 'create'])->name('provider.create');
    Route::post('/onboarding', [ProviderController::class, 'store'])->name('provider.store');
    Route::get('/pending', [ProviderController::class, 'pending'])->name('provider.pending');
});

// Provider management (requires auth + provider role)
Route::middleware(['auth', 'verified', 'provider'])->prefix('provider')->group(function () {
    Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('provider.dashboard');
    Route::get('/edit', [ProviderController::class, 'edit'])->name('provider.edit');
    Route::put('/update', [ProviderController::class, 'update'])->name('provider.update');

    // Provider Notifications
    Route::get('/notifications', [ProviderController::class, 'allNotifications'])->name('provider.notifications.index');
    Route::post('/notifications/{id}/mark-read', [ProviderController::class, 'markNotificationAsRead'])->name('provider.notifications.mark-read');
    Route::post('/notifications/mark-all-read', [ProviderController::class, 'markAllNotificationsAsRead'])->name('provider.notifications.mark-all-read');

    // Booking Management
    Route::get('/bookings', [ProviderController::class, 'bookings'])->name('provider.bookings.index');
    Route::get('/bookings/{booking}', [ProviderController::class, 'bookingShow'])->name('provider.bookings.show');

    // API Route for fetching schedule dates
    Route::get('/schedules/{scheduleId}/dates', [ScheduleDateController::class, 'getScheduleDates']);
    Route::post('/schedules/dates/{dateId}/update-status', [ScheduleDateController::class, 'updateStatus'])->name('provider.schedules.dates.update-status');

    // Bus Management
    Route::prefix('buses')->group(function () {
        Route::get('/', [BusController::class, 'index'])->name('provider.buses.index');
        Route::get('/create', [BusController::class, 'create'])->name('provider.buses.create');
        Route::post('/', [BusController::class, 'store'])->name('provider.buses.store');
        Route::get('/{bus}/edit', [BusController::class, 'edit'])->name('provider.buses.edit');
        Route::put('/{bus}', [BusController::class, 'update'])->name('provider.buses.update');
        Route::delete('/{bus}', [BusController::class, 'destroy'])->name('provider.buses.destroy');
    });

    // Schedule Management
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('provider.schedules.index');
        Route::get('/create', [ScheduleController::class, 'create'])->name('provider.schedules.create');
        Route::post('/', [ScheduleController::class, 'store'])->name('provider.schedules.store');
        Route::get('/{schedule}/edit', [ScheduleController::class, 'edit'])->name('provider.schedules.edit');
        Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('provider.schedules.update');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('provider.schedules.destroy');
        Route::post('/{schedule}/request-cancellation', [ScheduleController::class, 'requestCancellation'])->name('provider.schedules.request-cancellation');
    });

    // Schedule Date Management
    Route::prefix('schedules/dates')->group(function () {
        Route::get('/', [ScheduleDateController::class, 'index'])->name('provider.schedules.dates');
        Route::post('/', [ScheduleDateController::class, 'store'])->name('provider.schedules.dates.store');
        Route::delete('/{scheduleDate}', [ScheduleDateController::class, 'destroy'])->name('provider.schedules.dates.destroy');
    });

    // Driver Management
    Route::prefix('drivers')->group(function () {
        Route::get('/', [DriverController::class, 'index'])->name('provider.drivers.index');
        Route::get('/create', [DriverController::class, 'create'])->name('provider.drivers.create');
        Route::post('/', [DriverController::class, 'store'])->name('provider.drivers.store');
        Route::get('/{driver}/edit', [DriverController::class, 'edit'])->name('provider.drivers.edit');
        Route::put('/{driver}', [DriverController::class, 'update'])->name('provider.drivers.update');
        Route::delete('/{driver}', [DriverController::class, 'destroy'])->name('provider.drivers.destroy');
    });

    // Driver Assignments
    Route::prefix('assignments')->group(function () {
        Route::get('/', [DriverAssignmentController::class, 'index'])->name('provider.assignments.index');
        Route::get('/create', [DriverAssignmentController::class, 'create'])->name('provider.assignments.create');
        Route::get('/schedule-dates/{schedule}', [DriverAssignmentController::class, 'getScheduleDates'])->name('provider.assignments.schedule-dates');
        Route::post('/', [DriverAssignmentController::class, 'store'])->name('provider.assignments.store');
        Route::delete('/{assignment}', [DriverAssignmentController::class, 'destroy'])->name('provider.assignments.destroy');
    });
});

// ─── Driver Routes ──────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'driver'])->prefix('driver')->group(function () {
    Route::get('/dashboard', [DriverTrackingController::class, 'dashboard'])->name('driver.dashboard');
    Route::post('/trips/{assignment}/start', [DriverTrackingController::class, 'startTrip'])->name('driver.trip.start');
    Route::get('/trips/{assignment}', [DriverTrackingController::class, 'trip'])->name('driver.trip');
    Route::post('/trips/{assignment}/end', [DriverTrackingController::class, 'endTrip'])->name('driver.trip.end');
    Route::post('/location', [DriverTrackingController::class, 'updateLocation'])->name('driver.location.update');

    // Driver Notifications
    Route::get('/notifications', [DriverTrackingController::class, 'allNotifications'])->name('driver.notifications.index');
    Route::post('/notifications/{id}/mark-read', [DriverTrackingController::class, 'markNotificationAsRead'])->name('driver.notifications.mark-read');
    Route::post('/notifications/mark-all-read', [DriverTrackingController::class, 'markAllNotificationsAsRead'])->name('driver.notifications.mark-all-read');
});

// ─── Admin Routes ────────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Notifications
    Route::get('/notifications', [DashboardController::class, 'allNotifications'])->name('admin.notifications.index');
    Route::post('/notifications/{id}/mark-read', [DashboardController::class, 'markNotificationAsRead'])->name('admin.notifications.mark-read');
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsAsRead'])->name('admin.notifications.mark-all-read');

    // Provider Management
    Route::prefix('providers')->group(function () {
        Route::get('/', [AdminProviderController::class, 'index'])->name('admin.providers.index');
        Route::get('/create', [AdminProviderController::class, 'create'])->name('admin.providers.create');
        Route::post('/', [AdminProviderController::class, 'store'])->name('admin.providers.store');
        Route::get('/{provider}', [AdminProviderController::class, 'show'])->name('admin.providers.show');
        Route::get('/{provider}/edit', [AdminProviderController::class, 'edit'])->name('admin.providers.edit');
        Route::put('/{provider}', [AdminProviderController::class, 'update'])->name('admin.providers.update');
        Route::patch('/{provider}/status', [AdminProviderController::class, 'updateStatus'])->name('admin.providers.updateStatus');
        Route::delete('/{provider}', [AdminProviderController::class, 'destroy'])->name('admin.providers.destroy');
    });

    // Route Management
    Route::prefix('routes')->group(function () {
        Route::get('/', [RouteController::class, 'index'])->name('admin.routes.index');
        Route::get('/create', [RouteController::class, 'create'])->name('admin.routes.create');
        Route::post('/', [RouteController::class, 'store'])->name('admin.routes.store');
        Route::get('/{route}', [RouteController::class, 'show'])->name('admin.routes.show');
        Route::get('/{route}/edit', [RouteController::class, 'edit'])->name('admin.routes.edit');
        Route::put('/{route}', [RouteController::class, 'update'])->name('admin.routes.update');
    });

    // Booking Management
    Route::prefix('bookings')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
        Route::get('/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
        Route::post('/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('admin.bookings.cancel');
    });

    // Location Management
    Route::prefix('locations')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('admin.locations.index');
        Route::get('/create', [LocationController::class, 'create'])->name('admin.locations.create');
        Route::post('/', [LocationController::class, 'store'])->name('admin.locations.store');
        Route::get('/{location}', [LocationController::class, 'show'])->name('admin.locations.show');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('admin.locations.edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('admin.locations.update');
    });
});
