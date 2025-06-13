@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-teal text-white rounded-top-4">
                    <h5 class="mb-0 text-warning">Leave Report Results</h5>
                </div>

                <div class="card-body px-4 py-4">

                    <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <a href="{{ route('reports.export-pdf', request()->all()) }}" class="btn btn-outline-danger">
                                <i class="fas fa-file-pdf me-1"></i> Export as PDF
                            </a>
                            <a href="{{ route('reports.export-excel', request()->all()) }}" class="btn btn-outline-success">
                                <i class="fas fa-file-excel me-1"></i> Export as Excel
                            </a>
                        </div>
                        <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Report Generator
                        </a>
                    </div>

                    @if($leaveRequests->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>Date Range</th>
                                    <th>Days</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <th>Admin Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveRequests as $request)
                                <tr>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->leaveType->name }}</td>
                                    <td>{{ $request->start_date->format('M d, Y') }} – {{ $request->end_date->format('M d, Y') }}</td>
                                    <td>{{ $request->start_date->diffInDays($request->end_date) + 1 }}</td>
                                    <td>
                                        <span class="badge bg-{{ $request->status === 'approved' ? 'success' : ($request->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->reason ?? '—' }}</td>
                                    <td>{{ $request->admin_remarks ?? '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info mt-4">
                        No leave records found for the selected filters.
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection