<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
    'event_id',
    'team',
    'participant_id',
    'group_name',
    'mark',
    'grade',
    'rank',
    'points',
];


    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    // For individual score
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    // Group score may not have participant_id
    public function groupMembers()
    {
        return Participant::where('group_id', $this->group_id)
            ->where('event_id', $this->event_id)
            ->get();
    }

    // Correct event relation
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
