# 🚌 QuickTicket — Bus Ticket Booking System

A full-featured **bus ticket booking platform** built with Laravel 12, featuring real-time bus tracking, online payments, an AI-powered chatbot, and multi-role access for customers, providers, admins, and drivers.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-Build_Tool-646CFF?style=for-the-badge&logo=vite&logoColor=white)

---

## ✨ Features

### 🎫 Booking & Travel
- Search buses by origin, destination & date
- Interactive seat selection with real-time availability
- Booking management with ticket generation
- Schedule browsing with provider & pricing details

### 📍 Real-Time Tracking
- Live bus location tracking via **WebSocket** (Laravel Reverb)
- Interactive maps with **Leaflet.js + OpenStreetMap**
- Driver GPS broadcasting every 15 seconds
- Real-time notifications for trip updates

### 💳 Payments
- Secure online payments via **PayHere** (LKR)
- Payment history and transaction tracking

### 🤖 AI Chatbot
- FAQ chatbot powered by **OpenAI GPT-4o-mini**
- Floating widget with conversation history
- Instant answers to common travel questions

### 👥 Multi-Role System

| Role | Capabilities |
|------|-------------|
| **Customer** | Search, book, pay, track buses, chat with AI bot |
| **Provider** | Manage buses, routes, schedules, drivers, view bookings |
| **Admin** | Manage all users, providers, bookings, locations, routes |
| **Driver** | View assignments, start/end trips, broadcast live location |

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8.2, Laravel 12 |
| **Frontend** | Blade Templates, Tailwind CSS v4, Vite |
| **Database** | MySQL 8.0 |
| **Real-Time** | Laravel Reverb (WebSocket), Laravel Echo |
| **Maps** | Leaflet.js, OpenStreetMap |
| **Payments** | PayHere Payment Gateway |
| **AI** | OpenAI API (GPT-4o-mini) |
| **Mail** | Gmail SMTP |
| **Auth** | Laravel Auth with Email Verification |

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2.x (Thread Safe)
- Composer 2.x
- Node.js 18+ (LTS)
- MySQL 8.0+

### Installation

```bash
# Clone the repository
git clone https://github.com/your-username/bus-ticket-booking-system.git
cd bus-ticket-booking-system

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env
# DB_DATABASE=bus_ticket_booking
# DB_USERNAME=root
# DB_PASSWORD=your_password

# Run migrations & seed
php artisan migrate
php artisan db:seed
php artisan storage:link

# Build assets & start server
npm run build
php artisan serve
```

### Test Accounts
> Password for all accounts: `password`

| Role | Email |
|------|-------|
| Admin | admin@quickticket.lk |
| Provider | provider1@quickticket.lk |
| Customer | customer1@quickticket.lk |
| Driver | driver1@quickticket.lk |

---

## 📁 Project Structure

```
├── app/
│   ├── Events/            # BusLocationUpdated (WebSocket broadcast)
│   ├── Http/
│   │   ├── Controllers/   # Auth, Booking, Provider, Admin, Driver, Chatbot
│   │   └── Middleware/     # Role-based access (Admin, Provider, Driver)
│   └── Models/            # 15 Eloquent models
├── resources/
│   ├── views/             # Blade templates (layouts, partials, pages)
│   ├── css/               # Tailwind CSS v4 with custom theme
│   └── js/                # Laravel Echo, WebSocket listeners
├── routes/
│   ├── web.php            # All route definitions
│   └── channels.php       # WebSocket channel authorization
└── database/
    ├── migrations/        # 17 clean migration files
    └── seeders/           # Test data seeder
```

---

## 🎨 Design

Built with a modern **Indigo + Amber** color scheme featuring clean card-based layouts, subtle glassmorphism effects, and responsive design across all devices.

---

## 📄 License

This project is open-sourced for educational purposes.
