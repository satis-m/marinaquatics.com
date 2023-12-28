<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Mail\NewOrderEmail;
use Illuminate\Support\Facades\Mail;

class SendNewOrderNotification
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
    public function handle(NewOrder $event): void
    {
        $orderInfo = $event->orderInfo;

        //send email here
        Mail::to(env('ADMIN_MAIL'))->send(new NewOrderEmail($orderInfo));
    }
}
