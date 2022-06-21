<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_id',
        'title',
        'description',
        'start',
        'end'
    ];
    
    protected $with = ["users"];
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('creator')->withTimestamps();
    }

}
