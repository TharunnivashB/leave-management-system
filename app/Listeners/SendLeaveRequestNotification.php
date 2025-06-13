<?php

namespace App\Listeners;

use App\Events\LeaveRequestCreated;
use App\Mail\NewLeaveRequestNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class SendLeaveRequestNotification
{
    public function handle(LeaveRequestCreated $event)
    {
        $admins = User::role('admin')->get();
        
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NewLeaveRequestNotification($event->leaveRequest));
            }
        }
    }