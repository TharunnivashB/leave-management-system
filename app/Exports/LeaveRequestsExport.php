<?php


namespace App\Exports;

use App\Models\LeaveRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveRequestsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = LeaveRequest::with(['user', 'leaveType']);

        if (isset($this->filters['month'])) {
            $query->whereMonth('start_date', $this->filters['month']);
        }

        if (isset($this->filters['year'])) {
            $query->whereYear('start_date', $this->filters['year']);
        }

        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (isset($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Leave Type',
            'Start Date',
            'End Date',
            'Duration (Days)',
            'Status',
            'Reason',
            'Admin Remarks',
            'Request Date'
        ];
    }

    public function map($leaveRequest): array
    {
        return [
            $leaveRequest->user->name,
            $leaveRequest->leaveType->name,
            $leaveRequest->start_date->format('Y-m-d'),
            $leaveRequest->end_date->format('Y-m-d'),
            $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1,
            ucfirst($leaveRequest->status),
            $leaveRequest->reason ?? 'N/A',
            $leaveRequest->admin_remarks ?? 'N/A',
            $leaveRequest->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
