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
        'end',
        'created_by'
    ];
    
    protected $with = ["users", "creator"];
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('creator')->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
