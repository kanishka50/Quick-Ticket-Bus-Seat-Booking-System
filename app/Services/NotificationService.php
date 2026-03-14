<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    // Customer notification types
    const BOOKING_CREATED = 'booking_created';
    const BOOKING_CONFIRMED = 'booking_confirmed';
    const BOOKING_CANCELLED = 'booking_cancelled';
    const PAYMENT_SUCCESS = 'payment_success';
    const PAYMENT_FAILED = 'payment_failed';
    const SCHEDULE_CHANGE = 'schedule_change';

    // Provider notification types
    const NEW_BOOKING = 'new_booking';
    const BOOKING_CANCELLED_PROVIDER = 'booking_cancelled_provider';

    // Driver notification types
    const DRIVER_ASSIGNED = 'driver_assigned';
    const DRIVER_UNASSIGNED = 'driver_unassigned';

    // Admin notification types
    const CANCELLATION_REQUEST = 'cancellation_request';
    const NEW_CUSTOMER = 'new_customer';
    const NEW_PROVIDER = 'new_provider';
    const PROVIDER_APPROVED = 'provider_approved';
    const PROVIDER_REJECTED = 'provider_rejected';

    /**
     * Send a notification to a user.
     */
    public static function send(int $userId, string $type, string $title, string $message, ?int $relatedId = null): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'related_id' => $relatedId,
        ]);
    }
}
