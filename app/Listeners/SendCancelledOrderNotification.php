<?php

namespace App\Listeners;

use App\Events\CancelOrder;
use App\Mail\CancelledOrderEmail;
use Illuminate\Support\Facades\Mail;

class SendCancelledOrderNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CancelOrder $event): void
    {
        $orderInfo = $event->orderInfo;

        //send email here
        Mail::to(env('ADMIN_MAIL'))->send(new CancelledOrderEmail($orderInfo));
    }
}
