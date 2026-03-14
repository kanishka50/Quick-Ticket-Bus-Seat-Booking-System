<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Receipt - {{ $booking->booking_number }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        .page-wrapper {
            padding: 40px;
        }

        /* Header */
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .header-table {
            width: 100%;
        }

        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .logo-icon {
            color: #f59e0b;
        }

        .receipt-title {
            font-size: 11px;
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-align: right;
        }

        .receipt-number {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
            margin-top: 2px;
        }

        .receipt-date {
            font-size: 10px;
            color: #64748b;
            text-align: right;
            margin-top: 2px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-confirmed {
            background-color: #ecfdf5;
            color: #059669;
        }

        .status-pending {
            background-color: #fffbeb;
            color: #d97706;
        }

        .status-cancelled {
            background-color: #fef2f2;
            color: #dc2626;
        }

        /* Section */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 12px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info-label {
            color: #64748b;
            font-size: 11px;
            width: 140px;
        }

        .info-value {
            color: #1e293b;
            font-size: 11px;
            font-weight: 600;
        }

        /* Two Column Layout */
        .two-col {
            width: 100%;
        }

        .two-col td {
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }

        .two-col td:last-child {
            padding-right: 0;
            padding-left: 15px;
        }

        /* Seat Table */
        .seat-table {
            width: 100%;
            border-collapse: collapse;
        }

        .seat-table th {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .seat-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 11px;
            color: #1e293b;
        }

        .seat-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        /* Amount Box */
        .amount-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 15px;
            margin-top: 20px;
        }

        .amount-table {
            width: 100%;
            border-collapse: collapse;
        }

        .amount-table td {
            padding: 4px 0;
            font-size: 11px;
        }

        .amount-label {
            color: #64748b;
        }

        .amount-value {
            text-align: right;
            color: #1e293b;
        }

        .total-row td {
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }

        .total-label {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
        }

        .total-value {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
            text-align: right;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
            line-height: 1.6;
        }

        .footer-brand {
            font-size: 10px;
            color: #64748b;
            font-weight: bold;
            text-align: center;
            margin-bottom: 4px;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px dashed #e2e8f0;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td>
                        <div class="logo-text">
                            <span class="logo-icon">Quick</span>Ticket
                        </div>
                    </td>
                    <td>
                        <div class="receipt-title">Payment Receipt</div>
                        <div class="receipt-number">#{{ $booking->booking_number }}</div>
                        <div class="receipt-date">Issued: {{ now()->format('d M Y, h:i A') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Booking Status -->
        <div style="margin-bottom: 20px;">
            <span class="status-badge {{ $booking->booking_status == 'confirmed' ? 'status-confirmed' : ($booking->booking_status == 'cancelled' ? 'status-cancelled' : 'status-pending') }}">
                {{ ucfirst($booking->booking_status) }}
            </span>
            @if($booking->payment && $booking->payment->status == 'completed')
                <span class="status-badge status-confirmed" style="margin-left: 5px;">
                    Paid
                </span>
            @endif
        </div>

        <!-- Two Column: Trip + Payment -->
        <table class="two-col">
            <tr>
                <td>
                    <div class="section">
                        <div class="section-title">Trip Details</div>
                        <table class="info-table">
                            <tr>
                                <td class="info-label">Route</td>
                                <td class="info-value">{{ $booking->scheduleDate->schedule->route->origin->name }} &rarr; {{ $booking->scheduleDate->schedule->route->destination->name }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Departure Date</td>
                                <td class="info-value">{{ \Carbon\Carbon::parse($booking->scheduleDate->departure_date)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Departure Time</td>
                                <td class="info-value">{{ \Carbon\Carbon::parse($booking->scheduleDate->schedule->departure_time)->format('h:i A') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Arrival Time</td>
                                <td class="info-value">{{ \Carbon\Carbon::parse($booking->scheduleDate->schedule->arrival_time)->format('h:i A') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Bus</td>
                                <td class="info-value">{{ $booking->scheduleDate->schedule->bus->name ?? $booking->scheduleDate->schedule->bus->registration_number }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Reg. Number</td>
                                <td class="info-value">{{ $booking->scheduleDate->schedule->bus->registration_number }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Bus Type</td>
                                <td class="info-value">{{ $booking->scheduleDate->schedule->bus->busType->name }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div class="section">
                        <div class="section-title">Payment Details</div>
                        <table class="info-table">
                            @if($booking->payment)
                            <tr>
                                <td class="info-label">Transaction ID</td>
                                <td class="info-value">{{ $booking->payment->transaction_id }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Payment Date</td>
                                <td class="info-value">{{ $booking->payment->payment_date }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Payment Status</td>
                                <td class="info-value" style="color: {{ $booking->payment->status == 'completed' ? '#059669' : '#d97706' }};">{{ ucfirst($booking->payment->status) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="info-label">Passengers</td>
                                <td class="info-value">{{ $booking->total_passengers }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Customer Info -->
                    <div class="section">
                        <div class="section-title">Customer</div>
                        <table class="info-table">
                            <tr>
                                <td class="info-label">Name</td>
                                <td class="info-value">{{ $booking->user->name ?? Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Email</td>
                                <td class="info-value">{{ $booking->user->email ?? Auth::user()->email }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        <!-- Seat Details -->
        <div class="section">
            <div class="section-title">Seat Details</div>
            <table class="seat-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">#</th>
                        <th style="width: 35%;">Seat Number</th>
                        <th style="width: 50%;">Passenger</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->seatBookings as $index => $seat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight: 600;">{{ $seat->seat_number }}</td>
                        <td>{{ $booking->user->name ?? Auth::user()->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Amount Summary -->
        <div class="amount-box">
            <table class="amount-table">
                <tr>
                    <td class="amount-label">Price per seat</td>
                    <td class="amount-value">LKR {{ number_format($booking->scheduleDate->schedule->price ?? ($booking->total_amount / max($booking->total_passengers, 1)), 2) }}</td>
                </tr>
                <tr>
                    <td class="amount-label">Number of seats</td>
                    <td class="amount-value">&times; {{ $booking->total_passengers }}</td>
                </tr>
                <tr class="total-row">
                    <td class="total-label">Total Amount</td>
                    <td class="total-value">LKR {{ number_format($booking->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">QuickTicket - Bus Ticket Booking</div>
            <div class="footer-text">
                Thank you for choosing QuickTicket. For support, please contact us at support@quickticket.lk<br>
                This is a computer-generated receipt and does not require a signature.<br>
                &copy; {{ date('Y') }} QuickTicket. All Rights Reserved.
            </div>
        </div>
    </div>
</body>
</html>
