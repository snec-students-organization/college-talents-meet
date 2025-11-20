<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
    'event_id',
    'name',
    'team',
    'chest_no'
];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function score()
    {
        return $this->hasOne(Score::class);
    }
}
