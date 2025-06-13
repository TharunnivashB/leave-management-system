<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\LeaveRequest;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function getLeaveBalance($leaveTypeId)
    {
        $balances = $this->leave_balances ?? [];
        return $balances[$leaveTypeId] ?? LeaveType::find($leaveTypeId)->max_days_per_year;
    }

    public function updateLeaveBalance($leaveTypeId, $daysUsed)
    {
        $balances = is_array($this->leave_balances)
            ? $this->leave_balances
            : json_decode($this->leave_balances, true) ?? [];

        $currentBalance = (float) $this->getLeaveBalance($leaveTypeId);
        $balances[$leaveTypeId] = $currentBalance - $daysUsed;

        $this->leave_balances = $balances;
        $this->save();
    }
}
