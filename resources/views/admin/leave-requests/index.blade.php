@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-teal text-white rounded-top-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning">Manage Leave Requests</h5>
                    @if($leaveRequests->count() > 0)
                    <a href="{{ route('reports.index', request()->all()) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-file-export me-1"></i> Generate Report
                    </a>
                    @endif
                </div>

                <div class="card-body px-4 py-4">
                    {{-- Filters --}}
                    <form method="GET" action="{{ route('admin.leave-requests.index') }}" class="mb-4" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="user_id" class="form-select">
                                    <option value="">All Employees</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>

                            <div class="col-md-3">
                                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>
                        </div>
                    </form>

                    {{-- Leave Requests Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Employee</th>
                                    <th>Type</th>
                                    <th>Dates</th>
                                    <th>Days</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $request)
                                <tr class="text-center">
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->leaveType->name }}</td>
                                    <td>
                                        {{ $request->start_date->format('M d, Y') }} <br>
                                        <small class="text-muted">to</small> <br>
                                        {{ $request->end_date->format('M d, Y') }}
                                    </td>
                                    <td>{{ $request->start_date->diffInDays($request->end_date) + 1 }}</td>
                                    <td>
                                        @php
                                        $badgeClass = match($request->status) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning'
                                        };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.leave-requests.edit', $request) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i> Review
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No leave requests found for the selected filters.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');

        form.querySelectorAll('select, input[type="date"]').forEach(el => {
            el.addEventListener('change', () => {
                form.submit();
            });
        });
    });
</script>
@endpush