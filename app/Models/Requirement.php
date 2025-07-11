<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'other_type',
        'file',
        'status',
        'upload_date',
        'signed_file',
        'signature_status',
        'signed_date',
        'requires_signature',
    ];

    protected $casts = [
        'upload_date' => 'datetime',
        'signed_date' => 'datetime',
    ];

    
    /**
     * Get the user that owns the requirement.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
