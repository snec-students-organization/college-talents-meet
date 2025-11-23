<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'section',
    'category',
    'type',
    'stage_type'
];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
    public function getScoreCompletedAttribute()
{
    // total participants in this event
    $totalParticipants = \App\Models\Participant::where('event_id', $this->id)->count();

    // total scores assigned for this event
    $totalScores = \App\Models\Score::join('participants', 'scores.participant_id', '=', 'participants.id')
                    ->where('participants.event_id', $this->id)
                    ->count();

    // if all participants (or groups) received marks → score complete
    return $totalParticipants > 0 && $totalParticipants == $totalScores;
}

}
