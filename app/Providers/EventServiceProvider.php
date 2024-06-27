<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\KeuanganCreated;
use App\Listeners\HitungTotalKeuangan;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        "App\Events\KeuanganCreated" => ["App\Listeners\HitungTotalKeuangan"],
        "Illuminate\Auth\Events\Registered" => [
            "Illuminate\Auth\Listeners\SendEmailVerificationNotification",
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Registrasi Event Listener
        Event::listen(KeuanganCreated::class, HitungTotalKeuangan::class);
    }
}
