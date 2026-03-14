<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    private $merchant_id;
    private $merchant_secret;

    public function __construct()
    {
        $this->merchant_id = env('PAYHERE_MERCHANT_ID');
        $this->merchant_secret = env('PAYHERE_MERCHANT_SECRET');
        $this->middleware('auth')->except(['processPayHerePayment']);
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $scheduleDate = $booking->scheduleDate;
        $schedule = $scheduleDate->schedule;
        $route = $schedule->route;
        $origin = $route->origin;
        $destination = $route->destination;

        $order_id = $booking->booking_number;
        $amount = number_format($booking->total_amount, 2, '.', '');
        $currency = 'LKR';
        $hash = strtoupper(md5($this->merchant_id . $order_id . $amount . $currency . strtoupper(md5($this->merchant_secret))));

        return view('booking.payment', array_merge(compact(
            'booking',
            'scheduleDate',
            'schedule',
            'route',
            'origin',
            'destination'
        ), [
            'merchant_id' => $this->merchant_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'hash' => $hash
        ]));
    }

    public function processPayHerePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required',
            'order_id' => 'required',
            'payhere_amount' => 'required|numeric',
            'payhere_currency' => 'required',
            'status_code' => 'required',
            'md5sig' => 'required'
        ]);

        if ($validator->fails()) {
            Log::error('PayHere validation failed', ['errors' => $validator->errors()]);
            return response('Invalid request parameters', 400);
        }

        $merchant_id = $request->input('merchant_id');
        $order_id = $request->input('order_id');
        $payhere_amount = $request->input('payhere_amount');
        $payhere_currency = $request->input('payhere_currency');
        $status_code = $request->input('status_code');

        $generated_hash = strtoupper(md5(
            $merchant_id .
            $order_id .
            $payhere_amount .
            $payhere_currency .
            $status_code .
            strtoupper(md5($this->merchant_secret))
        ));

        if ($request->input('md5sig') !== $generated_hash) {
            Log::error('PayHere hash verification failed', ['order_id' => $order_id]);
            return response('Invalid hash', 400);
        }

        $booking = Booking::where('booking_number', $order_id)->first();

        if (!$booking) {
            Log::error('Booking not found for PayHere payment', ['order_id' => $order_id]);
            return response('Booking not found', 404);
        }

        DB::beginTransaction();

        try {
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->payment_method = 'payhere';
            $payment->transaction_id = $request->input('payment_id', 'N/A');
            $payment->amount = $payhere_amount;
            $payment->currency = $payhere_currency;
            $payment->status = $status_code == '2' ? 'completed' : 'failed';
            $payment->payment_date = now();
            $payment->payment_details = json_encode($request->all());
            $payment->save();

            if ($status_code == '2') {
                $booking->payment_status = 'paid';
                $booking->booking_status = 'confirmed';
                $booking->save();

                // Notify customer: payment success
                NotificationService::send(
                    $booking->user_id,
                    NotificationService::PAYMENT_SUCCESS,
                    'Booking Confirmed',
                    "Your booking #{$booking->booking_number} has been confirmed.",
                    $booking->id
                );

                // Notify provider: new booking on their bus
                $booking->load('scheduleDate.schedule.bus.provider', 'scheduleDate.schedule.route.origin', 'scheduleDate.schedule.route.destination');
                $providerUserId = $booking->scheduleDate->schedule->bus->provider->user_id ?? null;
                if ($providerUserId) {
                    $origin = $booking->scheduleDate->schedule->route->origin->name ?? '';
                    $destination = $booking->scheduleDate->schedule->route->destination->name ?? '';
                    NotificationService::send(
                        $providerUserId,
                        NotificationService::NEW_BOOKING,
                        'New Booking',
                        "New booking #{$booking->booking_number} on {$origin} to {$destination} route.",
                        $booking->id
                    );
                }
            }

            DB::commit();

            return response('Payment processed', 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PayHere payment processing error: ' . $e->getMessage());
            return response('Error processing payment', 500);
        }
    }

    public function paymentReturn(Request $request)
    {
        $booking = Booking::where('booking_number', $request->input('order_id'))->first();

        if (!$booking) {
            return redirect()->route('home')->with('error', 'Invalid booking.');
        }

        if ($request->input('status_code') == '2') {
            return redirect()->route('payment.success', $booking->id)
                ->with('success', 'Payment successful!');
        } else {
            return redirect()->route('bookings.index')
                ->with('error', 'Payment failed. Please try again.');
        }
    }

    public function paymentSuccess(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $booking->load([
            'payment',
            'seatBookings',
            'scheduleDate' => function($query) {
                $query->with(['schedule' => function($q) {
                    $q->with(['route' => function($r) {
                        $r->with(['origin', 'destination']);
                    }, 'bus' => function($b) {
                        $b->with('busType');
                    }]);
                }]);
            }
        ]);

        return view('booking.success', compact('booking'));
    }

    public function printReceipt(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $booking->load([
            'user',
            'payment',
            'seatBookings',
            'scheduleDate' => function($query) {
                $query->with(['schedule' => function($q) {
                    $q->with(['route' => function($r) {
                        $r->with(['origin', 'destination']);
                    }, 'bus' => function($b) {
                        $b->with('busType');
                    }]);
                }]);
            }
        ]);

        $pdf = Pdf::loadView('pdf.receipt', compact('booking'));
        $filename = 'receipt_' . $booking->booking_number . '_' . now()->format('YmdHis') . '.pdf';
        Storage::put('receipts/' . $filename, $pdf->output());

        return $pdf->download($filename);
    }
}
