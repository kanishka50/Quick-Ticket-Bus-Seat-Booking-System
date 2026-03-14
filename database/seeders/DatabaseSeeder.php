<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusType;
use App\Models\Driver;
use App\Models\DriverAssignment;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\ScheduleDate;
use App\Models\SeatBooking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ──────────────────────────────────────────────
        // 1. USERS (all email-verified)
        // ──────────────────────────────────────────────

        $admin = User::create([
            'name' => 'Kanishka Admin',
            'email' => 'admin@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0771234567',
            'address' => 'No. 10, Galle Road, Colombo 03',
            'user_type' => 'admin',
        ]);

        $providerUser1 = User::create([
            'name' => 'Nuwan Perera',
            'email' => 'provider@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0712345678',
            'address' => 'No. 45, Kandy Road, Kadawatha',
            'user_type' => 'provider',
        ]);

        $providerUser2 = User::create([
            'name' => 'Chaminda Silva',
            'email' => 'provider2@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0723456789',
            'address' => 'No. 120, Main Street, Kandy',
            'user_type' => 'provider',
        ]);

        $driverUser1 = User::create([
            'name' => 'Saman Kumara',
            'email' => 'driver@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0761234567',
            'address' => 'No. 22, Temple Road, Kelaniya',
            'user_type' => 'driver',
        ]);

        $driverUser2 = User::create([
            'name' => 'Kamal Jayasinghe',
            'email' => 'driver2@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0762345678',
            'address' => 'No. 88, Lake Road, Kandy',
            'user_type' => 'driver',
        ]);

        $customer1 = User::create([
            'name' => 'Amaya Fernando',
            'email' => 'customer@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0751234567',
            'address' => 'No. 55, Flower Road, Colombo 07',
            'user_type' => 'customer',
        ]);

        $customer2 = User::create([
            'name' => 'Dilshan Wickramasinghe',
            'email' => 'customer2@quickticket.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '0752345678',
            'address' => 'No. 33, Beach Road, Galle',
            'user_type' => 'customer',
        ]);

        // ──────────────────────────────────────────────
        // 2. PROVIDERS
        // ──────────────────────────────────────────────

        $provider1 = Provider::create([
            'user_id' => $providerUser1->id,
            'company_name' => 'Lanka Express Travels',
            'business_registration_number' => 'BR-2024-00145',
            'contact_number' => '0112345678',
            'address' => 'No. 45, Kandy Road, Kadawatha',
            'description' => 'Premium intercity bus service operating across Sri Lanka with modern AC buses and comfortable seating.',
            'status' => 'active',
        ]);

        $provider2 = Provider::create([
            'user_id' => $providerUser2->id,
            'company_name' => 'Hill Country Motors',
            'business_registration_number' => 'BR-2024-00289',
            'contact_number' => '0812345678',
            'address' => 'No. 120, Main Street, Kandy',
            'description' => 'Reliable hill country bus service connecting Kandy to major cities with experienced drivers.',
            'status' => 'active',
        ]);

        // ──────────────────────────────────────────────
        // 3. LOCATIONS (Sri Lankan cities)
        // ──────────────────────────────────────────────

        $colombo = Location::create([
            'name' => 'Colombo',
            'district' => 'Colombo',
            'province' => 'Western',
            'latitude' => 6.927079,
            'longitude' => 79.861244,
            'status' => 'active',
        ]);

        $kandy = Location::create([
            'name' => 'Kandy',
            'district' => 'Kandy',
            'province' => 'Central',
            'latitude' => 7.290572,
            'longitude' => 80.633728,
            'status' => 'active',
        ]);

        $galle = Location::create([
            'name' => 'Galle',
            'district' => 'Galle',
            'province' => 'Southern',
            'latitude' => 6.053519,
            'longitude' => 80.220978,
            'status' => 'active',
        ]);

        $jaffna = Location::create([
            'name' => 'Jaffna',
            'district' => 'Jaffna',
            'province' => 'Northern',
            'latitude' => 9.661498,
            'longitude' => 80.025543,
            'status' => 'active',
        ]);

        $matara = Location::create([
            'name' => 'Matara',
            'district' => 'Matara',
            'province' => 'Southern',
            'latitude' => 5.948853,
            'longitude' => 80.535148,
            'status' => 'active',
        ]);

        $nuwaraEliya = Location::create([
            'name' => 'Nuwara Eliya',
            'district' => 'Nuwara Eliya',
            'province' => 'Central',
            'latitude' => 6.949710,
            'longitude' => 80.789223,
            'status' => 'active',
        ]);

        // ──────────────────────────────────────────────
        // 4. BUS TYPES
        // ──────────────────────────────────────────────

        $luxury = BusType::create([
            'name' => 'Luxury AC',
            'description' => 'Air-conditioned luxury bus with reclining seats, WiFi, and charging ports.',
        ]);

        $semiLuxury = BusType::create([
            'name' => 'Semi Luxury',
            'description' => 'Comfortable semi-luxury bus with cushioned seats and fan cooling.',
        ]);

        $normal = BusType::create([
            'name' => 'Normal',
            'description' => 'Standard bus service with basic seating.',
        ]);

        // ──────────────────────────────────────────────
        // 5. BUSES (with seat layouts)
        // ──────────────────────────────────────────────

        // Helper: generate seat layout JSON
        $generateSeatLayout = function (int $rows, int $columns, array $disabledSeats = []): array {
            $layout = [];
            for ($r = 0; $r < $rows; $r++) {
                $letter = chr(65 + $r);
                for ($c = 0; $c < $columns; $c++) {
                    $number = $letter . ($c + 1);
                    $status = in_array($number, $disabledSeats) ? 'disabled' : 'available';
                    $layout[] = [
                        'id' => "seat-{$r}-{$c}",
                        'number' => $number,
                        'row' => $r,
                        'column' => $c,
                        'status' => $status,
                    ];
                }
            }
            return $layout;
        };

        // Bus 1: Lanka Express — 10 rows x 4 cols, aisle between col 2 & 3 (no disabled)
        $layout1 = $generateSeatLayout(10, 4);
        $bus1 = Bus::create([
            'provider_id' => $provider1->id,
            'bus_type_id' => $luxury->id,
            'registration_number' => 'WP-NC-1234',
            'name' => 'Lanka Express Gold',
            'total_seats' => collect($layout1)->where('status', 'available')->count(),
            'seat_layout' => json_encode($layout1),
            'amenities' => json_encode(['AC', 'WiFi', 'USB Charging', 'GPS Tracking']),
            'status' => 'active',
        ]);

        // Bus 2: Lanka Express — 8 rows x 4 cols, some disabled
        $layout2 = $generateSeatLayout(8, 4, ['A3', 'H4']);
        $bus2 = Bus::create([
            'provider_id' => $provider1->id,
            'bus_type_id' => $semiLuxury->id,
            'registration_number' => 'WP-KA-5678',
            'name' => 'Lanka Express Silver',
            'total_seats' => collect($layout2)->where('status', 'available')->count(),
            'seat_layout' => json_encode($layout2),
            'amenities' => json_encode(['AC', 'GPS Tracking']),
            'status' => 'active',
        ]);

        // Bus 3: Hill Country Motors — 12 rows x 4 cols
        $layout3 = $generateSeatLayout(12, 4, ['A3', 'L4']);
        $bus3 = Bus::create([
            'provider_id' => $provider2->id,
            'bus_type_id' => $luxury->id,
            'registration_number' => 'CP-KD-9012',
            'name' => 'Hill Rider Premium',
            'total_seats' => collect($layout3)->where('status', 'available')->count(),
            'seat_layout' => json_encode($layout3),
            'amenities' => json_encode(['AC', 'WiFi', 'USB Charging', 'Water Bottle']),
            'status' => 'active',
        ]);

        // Bus 4: Hill Country Motors — normal bus
        $layout4 = $generateSeatLayout(10, 4);
        $bus4 = Bus::create([
            'provider_id' => $provider2->id,
            'bus_type_id' => $normal->id,
            'registration_number' => 'CP-AB-3456',
            'name' => 'Hill Rider Standard',
            'total_seats' => collect($layout4)->where('status', 'available')->count(),
            'seat_layout' => json_encode($layout4),
            'amenities' => null,
            'status' => 'active',
        ]);

        // ──────────────────────────────────────────────
        // 6. ROUTES
        // ──────────────────────────────────────────────

        $route1 = Route::create([
            'origin_id' => $colombo->id,
            'destination_id' => $kandy->id,
            'distance' => 115.00,
            'estimated_duration' => 210, // 3h 30m
            'status' => 'active',
        ]);

        $route2 = Route::create([
            'origin_id' => $colombo->id,
            'destination_id' => $galle->id,
            'distance' => 126.00,
            'estimated_duration' => 180, // 3h
            'status' => 'active',
        ]);

        $route3 = Route::create([
            'origin_id' => $kandy->id,
            'destination_id' => $nuwaraEliya->id,
            'distance' => 77.00,
            'estimated_duration' => 150, // 2h 30m
            'status' => 'active',
        ]);

        $route4 = Route::create([
            'origin_id' => $colombo->id,
            'destination_id' => $jaffna->id,
            'distance' => 398.00,
            'estimated_duration' => 480, // 8h
            'status' => 'active',
        ]);

        $route5 = Route::create([
            'origin_id' => $galle->id,
            'destination_id' => $matara->id,
            'distance' => 46.00,
            'estimated_duration' => 60, // 1h
            'status' => 'active',
        ]);

        // ──────────────────────────────────────────────
        // 7. SCHEDULES
        // ──────────────────────────────────────────────

        // Lanka Express: Colombo → Kandy (morning)
        $schedule1 = Schedule::create([
            'route_id' => $route1->id,
            'bus_id' => $bus1->id,
            'departure_time' => '06:30:00',
            'arrival_time' => '10:00:00',
            'price' => 1500.00,
            'status' => 'active',
        ]);

        // Lanka Express: Colombo → Kandy (afternoon)
        $schedule2 = Schedule::create([
            'route_id' => $route1->id,
            'bus_id' => $bus2->id,
            'departure_time' => '14:00:00',
            'arrival_time' => '17:30:00',
            'price' => 1200.00,
            'status' => 'active',
        ]);

        // Lanka Express: Colombo → Galle
        $schedule3 = Schedule::create([
            'route_id' => $route2->id,
            'bus_id' => $bus1->id,
            'departure_time' => '08:00:00',
            'arrival_time' => '11:00:00',
            'price' => 1400.00,
            'status' => 'active',
        ]);

        // Hill Country: Kandy → Nuwara Eliya
        $schedule4 = Schedule::create([
            'route_id' => $route3->id,
            'bus_id' => $bus3->id,
            'departure_time' => '07:00:00',
            'arrival_time' => '09:30:00',
            'price' => 800.00,
            'status' => 'active',
        ]);

        // Hill Country: Colombo → Jaffna
        $schedule5 = Schedule::create([
            'route_id' => $route4->id,
            'bus_id' => $bus4->id,
            'departure_time' => '20:00:00',
            'arrival_time' => '04:00:00',
            'price' => 3500.00,
            'status' => 'active',
        ]);

        // Hill Country: Galle → Matara
        $schedule6 = Schedule::create([
            'route_id' => $route5->id,
            'bus_id' => $bus3->id,
            'departure_time' => '09:00:00',
            'arrival_time' => '10:00:00',
            'price' => 500.00,
            'status' => 'active',
        ]);

        // ──────────────────────────────────────────────
        // 8. SCHEDULE DATES (today + next 7 days)
        // ──────────────────────────────────────────────

        $schedules = [$schedule1, $schedule2, $schedule3, $schedule4, $schedule5, $schedule6];
        $busMap = [
            $schedule1->id => $bus1,
            $schedule2->id => $bus2,
            $schedule3->id => $bus1,
            $schedule4->id => $bus3,
            $schedule5->id => $bus4,
            $schedule6->id => $bus3,
        ];

        $scheduleDates = [];
        foreach ($schedules as $schedule) {
            $bus = $busMap[$schedule->id];
            for ($day = 0; $day <= 7; $day++) {
                $date = now()->addDays($day)->toDateString();
                $sd = ScheduleDate::create([
                    'schedule_id' => $schedule->id,
                    'departure_date' => $date,
                    'available_seats' => $bus->total_seats,
                    'status' => 'scheduled',
                ]);
                $scheduleDates[$schedule->id][$day] = $sd;
            }
        }

        // ──────────────────────────────────────────────
        // 9. DRIVERS
        // ──────────────────────────────────────────────

        $driver1 = Driver::create([
            'user_id' => $driverUser1->id,
            'provider_id' => $provider1->id,
            'license_number' => 'DL-2024-78452',
            'phone' => '0761234567',
            'status' => 'active',
        ]);

        $driver2 = Driver::create([
            'user_id' => $driverUser2->id,
            'provider_id' => $provider2->id,
            'license_number' => 'DL-2023-45123',
            'phone' => '0762345678',
            'status' => 'active',
        ]);

        // ──────────────────────────────────────────────
        // 10. DRIVER ASSIGNMENTS (today + tomorrow)
        // ──────────────────────────────────────────────

        // Driver 1 assigned to schedule 1 (Colombo→Kandy morning) today
        $assignment1 = DriverAssignment::create([
            'driver_id' => $driver1->id,
            'schedule_date_id' => $scheduleDates[$schedule1->id][0]->id,
            'status' => 'assigned',
        ]);

        // Driver 1 assigned to schedule 1 tomorrow
        DriverAssignment::create([
            'driver_id' => $driver1->id,
            'schedule_date_id' => $scheduleDates[$schedule1->id][1]->id,
            'status' => 'assigned',
        ]);

        // Driver 2 assigned to schedule 4 (Kandy→NuwaraEliya) today
        $assignment2 = DriverAssignment::create([
            'driver_id' => $driver2->id,
            'schedule_date_id' => $scheduleDates[$schedule4->id][0]->id,
            'status' => 'assigned',
        ]);

        // Driver 2 assigned to schedule 5 (Colombo→Jaffna) tomorrow
        DriverAssignment::create([
            'driver_id' => $driver2->id,
            'schedule_date_id' => $scheduleDates[$schedule5->id][1]->id,
            'status' => 'assigned',
        ]);

        // ──────────────────────────────────────────────
        // 11. BOOKINGS + SEAT BOOKINGS + PAYMENTS
        // ──────────────────────────────────────────────

        // --- Booking 1: Customer 1 books 2 seats on Colombo→Kandy (today) — CONFIRMED & PAID ---
        $todaySD1 = $scheduleDates[$schedule1->id][0];
        $booking1 = Booking::create([
            'booking_number' => 'BK' . strtoupper(Str::random(8)),
            'user_id' => $customer1->id,
            'schedule_date_id' => $todaySD1->id,
            'total_passengers' => 2,
            'total_amount' => $schedule1->price * 2,
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);

        SeatBooking::create([
            'booking_id' => $booking1->id,
            'seat_number' => 'A1',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);
        SeatBooking::create([
            'booking_id' => $booking1->id,
            'seat_number' => 'A2',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);

        Payment::create([
            'booking_id' => $booking1->id,
            'payment_method' => 'payhere',
            'transaction_id' => 'PH-' . strtoupper(Str::random(10)),
            'amount' => $booking1->total_amount,
            'currency' => 'LKR',
            'status' => 'completed',
            'payment_date' => now()->subHours(2),
            'payment_details' => json_encode(['method' => 'VISA', 'card_no' => '************4567']),
        ]);

        $todaySD1->decrement('available_seats', 2);

        // --- Booking 2: Customer 2 books 3 seats on Colombo→Galle (tomorrow) — CONFIRMED & PAID ---
        $tomorrowSD3 = $scheduleDates[$schedule3->id][1];
        $booking2 = Booking::create([
            'booking_number' => 'BK' . strtoupper(Str::random(8)),
            'user_id' => $customer2->id,
            'schedule_date_id' => $tomorrowSD3->id,
            'total_passengers' => 3,
            'total_amount' => $schedule3->price * 3,
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);

        SeatBooking::create([
            'booking_id' => $booking2->id,
            'seat_number' => 'B1',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);
        SeatBooking::create([
            'booking_id' => $booking2->id,
            'seat_number' => 'B2',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);
        SeatBooking::create([
            'booking_id' => $booking2->id,
            'seat_number' => 'B3',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);

        Payment::create([
            'booking_id' => $booking2->id,
            'payment_method' => 'payhere',
            'transaction_id' => 'PH-' . strtoupper(Str::random(10)),
            'amount' => $booking2->total_amount,
            'currency' => 'LKR',
            'status' => 'completed',
            'payment_date' => now()->subHour(),
            'payment_details' => json_encode(['method' => 'MASTERCARD', 'card_no' => '************8901']),
        ]);

        $tomorrowSD3->decrement('available_seats', 3);

        // --- Booking 3: Customer 1 books 1 seat on Kandy→NuwaraEliya (day after tomorrow) — PENDING ---
        $dayAfterSD4 = $scheduleDates[$schedule4->id][2];
        $booking3 = Booking::create([
            'booking_number' => 'BK' . strtoupper(Str::random(8)),
            'user_id' => $customer1->id,
            'schedule_date_id' => $dayAfterSD4->id,
            'total_passengers' => 1,
            'total_amount' => $schedule4->price,
            'payment_status' => 'pending',
            'booking_status' => 'pending',
        ]);

        SeatBooking::create([
            'booking_id' => $booking3->id,
            'seat_number' => 'C1',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);

        $dayAfterSD4->decrement('available_seats', 1);

        // --- Booking 4: Customer 2 cancelled booking on Colombo→Kandy (tomorrow) ---
        $tomorrowSD1 = $scheduleDates[$schedule1->id][1];
        $booking4 = Booking::create([
            'booking_number' => 'BK' . strtoupper(Str::random(8)),
            'user_id' => $customer2->id,
            'schedule_date_id' => $tomorrowSD1->id,
            'total_passengers' => 1,
            'total_amount' => $schedule1->price,
            'payment_status' => 'pending',
            'booking_status' => 'cancelled',
        ]);

        SeatBooking::create([
            'booking_id' => $booking4->id,
            'seat_number' => 'D1',
            'ticket_number' => 'TK' . strtoupper(Str::random(8)),
        ]);
        // Note: available_seats NOT decremented for cancelled booking

        // ──────────────────────────────────────────────
        // 12. NOTIFICATIONS
        // ──────────────────────────────────────────────

        // Admin notifications
        Notification::create([
            'user_id' => $admin->id,
            'title' => 'New Customer Registered',
            'message' => 'Amaya Fernando has registered as a new customer.',
            'type' => 'new_customer',
            'related_id' => $customer1->id,
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $admin->id,
            'title' => 'New Customer Registered',
            'message' => 'Dilshan Wickramasinghe has registered as a new customer.',
            'type' => 'new_customer',
            'related_id' => $customer2->id,
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $admin->id,
            'title' => 'New Provider Registered',
            'message' => 'Lanka Express Travels has submitted a provider application.',
            'type' => 'new_provider',
            'related_id' => $provider1->id,
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $admin->id,
            'title' => 'New Provider Registered',
            'message' => 'Hill Country Motors has submitted a provider application.',
            'type' => 'new_provider',
            'related_id' => $provider2->id,
            'is_read' => true,
        ]);

        // Provider 1 notifications
        Notification::create([
            'user_id' => $providerUser1->id,
            'title' => 'Provider Approved',
            'message' => 'Your provider application for Lanka Express Travels has been approved.',
            'type' => 'provider_approved',
            'related_id' => $provider1->id,
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $providerUser1->id,
            'title' => 'New Booking Received',
            'message' => "Booking #{$booking1->booking_number} — 2 seats on Colombo → Kandy.",
            'type' => 'new_booking',
            'related_id' => $booking1->id,
            'is_read' => false,
        ]);

        // Provider 2 notifications
        Notification::create([
            'user_id' => $providerUser2->id,
            'title' => 'Provider Approved',
            'message' => 'Your provider application for Hill Country Motors has been approved.',
            'type' => 'provider_approved',
            'related_id' => $provider2->id,
            'is_read' => true,
        ]);

        // Customer 1 notifications
        Notification::create([
            'user_id' => $customer1->id,
            'title' => 'Booking Created',
            'message' => "Your booking #{$booking1->booking_number} for Colombo to Kandy has been created.",
            'type' => 'booking_created',
            'related_id' => $booking1->id,
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $customer1->id,
            'title' => 'Payment Successful',
            'message' => "Payment of LKR " . number_format($booking1->total_amount, 2) . " for booking #{$booking1->booking_number} was successful.",
            'type' => 'payment_success',
            'related_id' => $booking1->id,
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $customer1->id,
            'title' => 'Booking Created',
            'message' => "Your booking #{$booking3->booking_number} for Kandy to Nuwara Eliya has been created. Please complete payment.",
            'type' => 'booking_created',
            'related_id' => $booking3->id,
            'is_read' => false,
        ]);

        // Customer 2 notifications
        Notification::create([
            'user_id' => $customer2->id,
            'title' => 'Booking Created',
            'message' => "Your booking #{$booking2->booking_number} for Colombo to Galle has been created.",
            'type' => 'booking_created',
            'related_id' => $booking2->id,
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $customer2->id,
            'title' => 'Payment Successful',
            'message' => "Payment of LKR " . number_format($booking2->total_amount, 2) . " for booking #{$booking2->booking_number} was successful.",
            'type' => 'payment_success',
            'related_id' => $booking2->id,
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $customer2->id,
            'title' => 'Booking Cancelled',
            'message' => "Your booking #{$booking4->booking_number} for Colombo to Kandy has been cancelled.",
            'type' => 'booking_cancelled',
            'related_id' => $booking4->id,
            'is_read' => false,
        ]);

        // Driver notifications
        Notification::create([
            'user_id' => $driverUser1->id,
            'title' => 'New Trip Assigned',
            'message' => 'You have been assigned to Colombo → Kandy on ' . now()->format('d M Y') . '.',
            'type' => 'driver_assigned',
            'related_id' => $scheduleDates[$schedule1->id][0]->id,
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $driverUser1->id,
            'title' => 'New Trip Assigned',
            'message' => 'You have been assigned to Colombo → Kandy on ' . now()->addDay()->format('d M Y') . '.',
            'type' => 'driver_assigned',
            'related_id' => $scheduleDates[$schedule1->id][1]->id,
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $driverUser2->id,
            'title' => 'New Trip Assigned',
            'message' => 'You have been assigned to Kandy → Nuwara Eliya on ' . now()->format('d M Y') . '.',
            'type' => 'driver_assigned',
            'related_id' => $scheduleDates[$schedule4->id][0]->id,
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $driverUser2->id,
            'title' => 'New Trip Assigned',
            'message' => 'You have been assigned to Colombo → Jaffna on ' . now()->addDay()->format('d M Y') . '.',
            'type' => 'driver_assigned',
            'related_id' => $scheduleDates[$schedule5->id][1]->id,
            'is_read' => false,
        ]);
    }
}
