<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email'
    ];

    // protected $with = ["eventsList"];

    public function eventsList()
    {
        return $this->belongsToMany(Event::class, 'event_assignees');
    }
}
