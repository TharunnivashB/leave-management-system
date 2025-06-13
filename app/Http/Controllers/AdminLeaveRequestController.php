<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use App\Http\Requests\UpdateLeaveRequest;
use Illuminate\Http\Request;
use App\Events\LeaveRequestStatusChanged;

class AdminLeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['user', 'leaveType'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        }

        $leaveRequests = $query->paginate(10);


        $leaveRequests->appends($request->all());

        $users = User::all();

        return view('admin.leave-requests.index', compact('leaveRequests', 'users'));
    }

    public function edit(LeaveRequest $leaveRequest)
    {
        return view('admin.leave-requests.edit', compact('leaveRequest'));
    }

    public function update(UpdateLeaveRequest $request, LeaveRequest $leaveRequest)
    {
        $data = $request->validated();

        if ($data['status'] === 'approved') {
            $days = $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1;
            $leaveRequest->user->updateLeaveBalance($leaveRequest->leave_type_id, $days);
        }

        $leaveRequest->update($data);

        event(new LeaveRequestStatusChanged($leaveRequest));

        return redirect()->route('admin.leave-requests.index')
            ->with('success', 'Leave request updated successfully.');
    }
}
