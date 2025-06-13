<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('approve leave');
    }

    public function rules()
    {
        return [
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'required_if:status,rejected|nullable|string|max:500',
        ];
    }
}
