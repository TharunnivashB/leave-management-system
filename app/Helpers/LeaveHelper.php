<?php

namespace App\Helpers;

use App\Models\LeaveRequest;
use Carbon\Carbon;

class LeaveHelper
{
    public static function checkDateOverlap($userId, $startDate, $endDate, $excludeId = null)
    {
        $query = LeaveRequest::where('user_id', $userId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->whereIn('status', ['pending', 'approved']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
