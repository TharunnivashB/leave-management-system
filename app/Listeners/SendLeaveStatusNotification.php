<?php

namespace App\Listeners;

use App\Events\LeaveRequestStatusChanged;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;

class SendLeaveStatusNotification
{
    public function handle(LeaveRequestStatusChanged $event)
    {
        Mail::to($event->leaveRequest->user->email)
            ->send(new LeaveStatusNotification($event->leaveRequest));
    }
}