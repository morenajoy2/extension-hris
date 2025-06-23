<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExitClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exit_type',
        'turnover_by',
        'turned_over_tasks',
        'file_leader_confirmation',
        'file_hr_confirmation',
        'esignature_exit_file',
    ];

    // Optional: If you want to load user info with it
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
