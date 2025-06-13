@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-teal text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="mb-0 text-warning">My Leave Requests</h5>
                    <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Request Leave
                    </a>
                </div>

                <div class="card-body px-4 py-4">
                    @if($leaveRequests->isEmpty())
                    <div class="alert alert-info text-center mb-0">
                        You haven’t requested any leave yet.
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Dates</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveRequests as $request)
                                <tr class="text-center">
                                    <td class="text-capitalize">{{ $request->leaveType->name }}</td>
                                    <td>
                                        {{ $request->start_date->format('M d, Y') }}
                                        <div class="text-muted small">to</div>
                                        {{ $request->end_date->format('M d, Y') }}
                                    </td>
                                    <td>{{ $request->start_date->diffInDays($request->end_date) + 1 }}</td>
                                    <td>
                                        @php
                                        $statusClass = match($request->status) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning'
                                        };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('employee.leave-requests.show', $request) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1  text-warning"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection