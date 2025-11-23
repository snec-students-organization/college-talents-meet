<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'team',
    'chest_no',
    'event_id',
    'group_name',
];



    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scores()
{
    return $this->hasMany(\App\Models\Score::class, 'participant_id');
}
public function score()
{
    return $this->hasOne(\App\Models\Score::class, 'participant_id');
}


}
