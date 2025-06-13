<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Http\Requests\StoreLeaveRequest;
use Illuminate\Http\Request;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;


class LeaveRequestController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $leaveRequests = Auth::user()->leaveRequests()->latest()->get();
        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('leave-requests.create', compact('leaveTypes'));
    }


    public function show(LeaveRequest $leaveRequest)
    {
        $this->authorize('view', $leaveRequest);
        return view('leave-requests.show', compact('leaveRequest'));
    }
    public function store(StoreLeaveRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $leaveRequest = LeaveRequest::create($data);


        event(new \App\Events\LeaveRequestCreated($leaveRequest));

        return redirect()->route('employee.leave-requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }
}
