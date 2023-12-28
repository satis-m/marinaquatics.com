<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelOrder
{
    use Dispatchable, SerializesModels;

    public function __construct($orderInfo)
    {
        $this->orderInfo = $orderInfo;
    }
}
