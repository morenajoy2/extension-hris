<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turnover extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'orientation_date',
        'first_day',
        'last_day',
        'exit_day',
        'worked_hours_required',

        'recommended_employee_id',
        'recommended_employee_name',
        'turned_over_tasks',

        'company_accounts_transferred',
        'credentials_handed_over',

        'team_leader_id',
        'team_leader_name',
        'corporate_leader_id',
        'corporate_leader_name',

        'esignature_turnover_file',
    ];

    // Optional: If you want to relate turnover to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
