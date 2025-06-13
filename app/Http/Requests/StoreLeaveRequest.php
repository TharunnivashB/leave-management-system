<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;

class StoreLeaveRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('request leave');
    }

    public function rules()
    {
        return [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->dateOverlaps()) {
                $validator->errors()->add('date', 'Your leave request overlaps with an existing one.');
            }

            if ($this->exceedsMaxDuration()) {
                $validator->errors()->add('date', 'Leave duration cannot exceed 30 days.');
            }

            if ($this->insufficientBalance()) {
                $validator->errors()->add('leave_type_id', 'Insufficient leave balance for this type.');
            }
        });
    }

    protected function dateOverlaps()
    {
        return LeaveRequest::where('user_id', auth()->id())
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function ($query) {
                        $query->where('start_date', '<=', $this->start_date)
                            ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }

    protected function exceedsMaxDuration()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        return $start->diffInDays($end) > 30;
    }

    protected function insufficientBalance()
    {
        $leaveType = LeaveType::find($this->leave_type_id);
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $daysRequested = $start->diffInDays($end) + 1; // Inclusive of both dates

        return $daysRequested > auth()->user()->getLeaveBalance($this->leave_type_id);
    }
}
