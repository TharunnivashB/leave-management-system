@component('mail::message')
# Leave Request {{ ucfirst($leaveRequest->status) }}

Your leave request has been {{ $leaveRequest->status }}.

**Leave Type:** {{ $leaveRequest->leaveType->name }}
**Dates:** {{ $leaveRequest->start_date->format('M d, Y') }} to {{ $leaveRequest->end_date->format('M d, Y') }}
**Duration:** {{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} days
**Status:** {{ ucfirst($leaveRequest->status) }}

@if($leaveRequest->admin_remarks)
**Admin Remarks:**
{{ $leaveRequest->admin_remarks }}
@endif

@component('mail::button', ['url' => route('employee.leave-requests.show', $leaveRequest)])
View Details
@endcomponent

Thanks,
@endcomponent