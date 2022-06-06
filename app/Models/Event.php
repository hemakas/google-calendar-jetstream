<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start',
        'end'
    ];
    
    // protected $with = ["assigneeList"];
    
    public function assigneeList()
    {
        return $this->belongsToMany(Assignee::class, 'event_assignees');
    }

}
