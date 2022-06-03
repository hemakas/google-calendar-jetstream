<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAssignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignee_id',
        'event_id'
    ];
}
