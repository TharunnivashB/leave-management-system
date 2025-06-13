<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\LeaveRequestStatusChanged;
use App\Listeners\SendLeaveStatusNotification;
use App\Events\LeaveRequestCreated;
use App\Listeners\SendLeaveRequestNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LeaveRequestStatusChanged::class => [
            SendLeaveStatusNotification::class,
        ],
        LeaveRequestCreated::class => [
            SendLeaveRequestNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
