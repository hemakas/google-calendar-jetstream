<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalEventAssignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'assigner_id',
        'assignee_id',
        'local_event_id'
    ];
}
