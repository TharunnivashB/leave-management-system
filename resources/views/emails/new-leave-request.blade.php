@component('mail::message')
# New Leave Request Submitted

A new leave request has been submitted by {{ optional($leaveRequest->user)->name ?? 'Unknown User' }}.

**Leave Type:** {{ optional($leaveRequest->leaveType)->name ?? 'N/A' }}  
**Dates:** {{ $leaveRequest->start_date->format('M d, Y') }} to {{ $leaveRequest->end_date->format('M d, Y') }}  
**Duration:** {{ abs($leaveRequest->start_date->diffInDays($leaveRequest->end_date)) + 1 }} days  
**Reason:** {{ $leaveRequest->reason ?? 'Not provided' }}

@component('mail::button', ['url' => route('admin.leave-requests.edit', $leaveRequest)])
Review Leave Request
@endcomponent

Thanks,  
@endcomponent
