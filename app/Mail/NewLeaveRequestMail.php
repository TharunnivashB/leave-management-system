<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewLeaveRequestMail extends Mailable
{
    use Queueable;

    public function __construct(public LeaveRequest $leaveRequest) {}

    public function envelope()
    {
        return new Envelope(
            subject: 'New Leave Request Submitted',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.new_leave',
        );
    }
}
