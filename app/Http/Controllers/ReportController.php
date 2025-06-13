<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeaveRequestsExport;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct()
    {

        $this->middleware('can:generate reports');
    }



    public function generate(Request $request)
    {
        $query = LeaveRequest::with(['user', 'leaveType']);

        if ($request->has('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        if ($request->has('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $leaveRequests = $query->get();
        $users = User::all();

        return view('reports.results', compact('leaveRequests', 'users'));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);
        $pdf = Pdf::loadView('reports.pdf', $data);
        return $pdf->download('leave-report.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LeaveRequestsExport($request), 'leave-report.xlsx');
    }


    public function index(Request $request)
    {
        $query = LeaveRequest::with(['user', 'leaveType']);

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter: Employee
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter: From Date
        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        // Filter: To Date
        if ($request->filled('to_date')) {
            $query->whereDate('end_date', '<=', $request->to_date);
        }

        $leaveRequests = $query->orderBy('start_date', 'desc')->get();

        return view('reports.results', compact('leaveRequests'));
    }

    protected function getReportData($request)
    {
        $query = LeaveRequest::with(['user', 'leaveType']);

        if ($request->has('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        if ($request->has('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return [
            'leaveRequests' => $query->get(),
            'filters' => $request->all()
        ];
    }
}
