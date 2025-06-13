<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class LeaveStatusUpdatedMail extends Mailable
{
    use Queueable;

    public function __construct(public LeaveRequest $leaveRequest) {}

    public function envelope()
    {
        $status = ucfirst($this->leaveRequest->status);
        return new Envelope(
            subject: "Leave Request {$status}",
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.status_update',
        );
    }
}
