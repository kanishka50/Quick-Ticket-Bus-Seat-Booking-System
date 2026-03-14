# Bus Ticket Booking System

## Project Overview

Laravel 12 bus ticket booking platform with four user roles: **Customer**, **Provider**, **Admin**, **Driver**.
- Database: MySQL (`bus_ticket_booking`)
- Payment: PayHere (LKR) — credentials in `.env`
- Mail: Gmail SMTP
- Real-time: Laravel Reverb (WebSocket) + Laravel Echo
- Maps: Leaflet.js + OpenStreetMap (free, no API key)
- Frontend: Vite + Tailwind CSS v4 (`@tailwindcss/vite` plugin)
- AI Chatbot: OpenAI `gpt-4o-mini` (FAQ only, no DB)

---

## Layouts

| Layout | Used By | CSS |
|--------|---------|-----|
| `layouts/app.blade.php` | All authenticated pages (Customer, Provider, Admin, Driver) | `@vite()` |
| `home.blade.php` | Standalone landing page (no layout) | `@vite()` |

Each user type has a sidebar partial: `partials/user-sidebar.blade.php`, `partials/provider-sidebar.blade.php`, `partials/admin-sidebar.blade.php`, `partials/driver-sidebar.blade.php`.

---

## Design Theme (Indigo + Amber + Glassmorphism)

Defined in `resources/css/app.css` via `@theme` directive (Tailwind v4).

| Token | Value | Usage |
|-------|-------|-------|
| `--color-primary` | `#4f46e5` (indigo-600) | Buttons, links, focus rings |
| `--color-primary-light` | `#6366f1` (indigo-500) | Hover states, highlights |
| `--color-primary-dark` | `#3730a3` (indigo-800) | Active/pressed states |
| `--color-accent` | `#f59e0b` (amber-500) | CTA buttons, badges, highlights |
| `--color-accent-dark` | `#d97706` (amber-600) | Accent hover states |
| `--color-surface` | `#f8fafc` (slate-50) | Page backgrounds |
| `--color-surface-dark` | `#0f172a` (slate-900) | Dark sections, navbar, footer |

**Style Rules:**
- Border radius: minimal (`rounded-md` / `rounded-lg`) — modern rectangle with slight curves
- Cards: `bg-white border border-slate-100 shadow-sm` — clean, no heavy shadows
- Hover: `hover:shadow-md hover:-translate-y-0.5 transition-all duration-300`
- Glass effect (dark sections): `bg-white/10 backdrop-blur-lg`
- Navbar: `bg-slate-900/95 backdrop-blur-md`
- Section labels: `text-xs font-semibold text-primary uppercase tracking-wider`
- Text: `text-slate-900` (headings), `text-slate-500` (body), `text-slate-400` (muted)
- Status colors: `emerald-500` (success), `rose-500` (error), `amber-500` (warning)

---

## Completed Features

- Vite + Tailwind v4 migration (from CDN)
- Real-time bus tracking (Reverb WebSocket, 15s interval, no polling)
- Booking time validation (departed schedules blocked)
- Date picker local timezone fix
- Seat layout auto-calculation
- Schedule management (bus change/delete protection)
- Admin booking management (cancel any booking)
- Provider cancellation request flow
- Booking detail: provider name/contact, driver name/phone, bus reg no, arrival time
- Schedules page: provider company name ("Operated by")
- Static pages: About, Contact, Privacy, Terms (with footer links)
- FAQ Chatbot (OpenAI, floating widget, conversation history)
- UI Modernization: All pages updated to unified Indigo/Slate theme (all user types use `layouts/app.blade.php`)
- Driver notifications: `driver_assigned` and `driver_unassigned` types
- Admin/Driver dedicated notification pages with mark-read functionality

---

## Database Schema

All migrations are clean, one-per-table files matching the actual MySQL database schema exactly.

### Tables (in migration order)

| # | Table | Key Columns | Foreign Keys |
|---|-------|-------------|--------------|
| 1 | `password_reset_tokens` | email (indexed), token, created_at | — |
| 2 | `users` | id, name, email (unique), password, phone_number, address, profile_image, user_type ENUM(customer,admin,provider,driver) | — |
| 3 | `cache` / `cache_locks` | key (PK), value, expiration | — |
| 4 | `providers` | id, company_name, company_logo, business_registration_number (unique, 50), contact_number (20), address, description, status ENUM, reason | user_id → users |
| 5 | `locations` | id, name (indexed), district, province, latitude decimal(10,6), longitude decimal(10,6), status ENUM | — |
| 6 | `bus_types` | id, name, description, features JSON | — |
| 7 | `buses` | id, registration_number (unique), name, total_seats, seat_layout JSON, amenities JSON, status ENUM | provider_id → providers, bus_type_id → bus_types |
| 8 | `routes` | id, distance decimal(10,2), estimated_duration INT, status ENUM, unique(origin_id, destination_id) | origin_id → locations, destination_id → locations |
| 9 | `schedules` | id, departure_time TIME, arrival_time TIME, price decimal(10,2), status ENUM | route_id → routes, bus_id → buses |
| 10 | `schedule_dates` | id, departure_date DATE, available_seats INT, status ENUM, actual_departure/arrival_time DATETIME, delay_reason, unique(schedule_id, departure_date) | schedule_id → schedules |
| 11 | `bookings` | id, booking_number (unique), total_passengers UNSIGNED INT, total_amount decimal(10,2), payment_status ENUM, booking_status ENUM, booking_date TIMESTAMP | user_id → users, schedule_date_id → schedule_dates |
| 12 | `seat_bookings` | id, seat_number, ticket_number (unique), unique(booking_id, seat_number) | booking_id → bookings |
| 13 | `payments` | id, payment_method (50), transaction_id, amount decimal(10,2), currency (10) default 'LKR', status ENUM, payment_date, payment_details JSON | booking_id → bookings |
| 14 | `notifications` | id, title, message TEXT, type VARCHAR(50), related_id UNSIGNED BIGINT nullable, is_read BOOLEAN default false | user_id → users |
| 15 | `drivers` | id, license_number, phone (20), status ENUM(active,inactive) | user_id → users, provider_id → providers |
| 16 | `driver_assignments` | id, status ENUM(assigned,active,completed), unique(driver_id, schedule_date_id) | driver_id → drivers, schedule_date_id → schedule_dates |
| 17 | `bus_locations` | id, latitude decimal(10,6), longitude decimal(10,6), location_name, speed decimal(5,1), recorded_at TIMESTAMP, driver_id (unique) | driver_id → drivers, schedule_date_id → schedule_dates |

### Migration Cleanup (Done)

Consolidated 20 migration files (including 3 fix/alter migrations) into 17 clean one-per-table files. Migrations match the actual MySQL database schema exactly. Legacy `owner` table was dropped (not part of the system). Model fillable arrays were fixed to match actual DB columns.

---

## Project Setup (New Device)

### Requirements
- PHP 8.2.x (Thread Safe) — **NOT 8.5** (has deprecation issues with Laravel 12)
- Composer 2.x
- Node.js 18+ (LTS)
- MySQL 8.0+

### Setup Commands
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed
npm run build
php artisan serve
```

### .env Configuration
Update `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` for MySQL.

### Seeder Test Accounts (password: `password`)
- Admin: admin@quickticket.lk
- Provider: provider1@quickticket.lk, provider2@quickticket.lk
- Customer: customer1@quickticket.lk, customer2@quickticket.lk
- Driver: driver1@quickticket.lk, driver2@quickticket.lk
