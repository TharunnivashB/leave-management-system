@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-teal text-white rounded-top-4">
                    <h5 class="mb-0 text-warning">Request Leave</h5>
                </div>

                <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('employee.leave-requests.store') }}">
                        @csrf

                        {{-- Leave Type --}}
                        <div class="mb-3">
                            <label for="leave_type_id" class="form-label fw-semibold">Leave Type</label>
                            <select name="leave_type_id" id="leave_type_id" class="form-select" required>
                                <option value="">Select Leave Type</option>
                                @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}" data-max-days="{{ $type->max_days_per_year }}">
                                    {{ $type->name }} (Max {{ $type->max_days_per_year }} days/year)
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Start Date --}}
                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-semibold">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        {{-- End Date --}}
                        <div class="mb-3">
                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>

                        {{-- Reason --}}
                        <div class="mb-4">
                            <label for="reason" class="form-label fw-semibold">
                                Reason <small class="text-muted">(optional)</small>
                            </label>
                            <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Provide additional context if needed..."></textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-outline-success px-4">
                                <i class="fas fa-paper-plane me-1"></i> Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Date Validation Script --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        const today = new Date().toISOString().split('T')[0];
        startDate.min = today;

        startDate.addEventListener('change', () => {
            endDate.min = startDate.value;
        });
    });
</script>
@endpush
@endsection