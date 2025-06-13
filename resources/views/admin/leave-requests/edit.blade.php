@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-teal text-white rounded-top-4">
                    <h5 class="mb-0 text-warning">Review Leave Request</h5>
                </div>

                <div class="card-body px-4 py-4">
                    {{-- Employee Details --}}
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label fw-semibold">Employee:</label>
                        <div class="col-md-8 pt-2">
                            {{ $leaveRequest->user->name }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label fw-semibold">Leave Type:</label>
                        <div class="col-md-8 pt-2">
                            {{ $leaveRequest->leaveType->name }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label fw-semibold">Dates:</label>
                        <div class="col-md-8 pt-2">
                            {{ $leaveRequest->start_date->format('M d, Y') }} to {{ $leaveRequest->end_date->format('M d, Y') }}
                            <span class="text-muted">({{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} days)</span>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label fw-semibold">Current Status:</label>
                        <div class="col-md-8 pt-2">
                            @php
                            $badgeClass = match($leaveRequest->status) {
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'warning'
                            };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($leaveRequest->status) }}</span>
                        </div>
                    </div>

                    @if($leaveRequest->reason)
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label fw-semibold">Employee Reason:</label>
                        <div class="col-md-8 pt-2">
                            {{ $leaveRequest->reason }}
                        </div>
                    </div>
                    @endif

                    {{-- Admin Action Form --}}
                    <form method="POST" action="{{ route('admin.leave-requests.update', $leaveRequest) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Select Action</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="approved" {{ old('status', $leaveRequest->status) === 'approved' ? 'selected' : '' }}>Approve</option>
                                <option value="rejected" {{ old('status', $leaveRequest->status) === 'rejected' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </div>

                        <div class="mb-3" id="remarks-group" @if(old('status', $leaveRequest->status) !== 'rejected') style="display: none;" @endif>
                            <label for="admin_remarks" class="form-label">Remarks <small class="text-danger">(Required for Rejection)</small></label>
                            <textarea name="admin_remarks" id="admin_remarks" class="form-control" rows="3" placeholder="Mention reason for rejection">{{ old('admin_remarks', $leaveRequest->admin_remarks) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-teal">
                                <i class="fas fa-check-circle me-1"></i> Submit Decision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS for Remarks toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const remarksGroup = document.getElementById('remarks-group');

        statusSelect.addEventListener('change', function() {
            if (this.value === 'rejected') {
                remarksGroup.style.display = 'block';
            } else {
                remarksGroup.style.display = 'none';
            }
        });
    });
</script>
@endsection