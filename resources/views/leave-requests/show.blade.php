@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Leave Request Details</h5>
                </div>

                <div class="card-body px-4 py-4">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Leave Type:</div>
                        <div class="col-md-8">{{ $leaveRequest->leaveType->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Dates:</div>
                        <div class="col-md-8">
                            {{ $leaveRequest->start_date->format('M d, Y') }} to {{ $leaveRequest->end_date->format('M d, Y') }}
                            <span class="text-muted">({{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} day(s))</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Status:</div>
                        <div class="col-md-8">
                            @php
                            $statusClass = match($leaveRequest->status) {
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'warning'
                            };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($leaveRequest->status) }}
                            </span>
                        </div>
                    </div>

                    @if($leaveRequest->reason)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Reason:</div>
                        <div class="col-md-8">{{ $leaveRequest->reason }}</div>
                    </div>
                    @endif

                    @if($leaveRequest->admin_remarks)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Admin Remarks:</div>
                        <div class="col-md-8">{{ $leaveRequest->admin_remarks }}</div>
                    </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4 fw-semibold text-secondary">Submitted On:</div>
                        <div class="col-md-8">{{ $leaveRequest->created_at->format('M d, Y • h:i A') }}</div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('employee.leave-requests.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection