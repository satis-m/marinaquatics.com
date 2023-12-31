<?php

namespace App\Providers;

use App\Events\NewOrder;
use App\Events\CancelOrder;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendCancelledOrderNotification;
use App\Models\Banner;
use App\Models\Slider;
use App\Observers\BannerObserver;
use App\Observers\SliderObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewOrder::class => [
            SendNewOrderNotification::class,
        ],
        CancelOrder::class => [
            SendCancelledOrderNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Slider::observe(SliderObserver::class);
        Banner::observe(BannerObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
