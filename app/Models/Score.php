<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
    'participant_id',
    'mark',
    'grade',
    'rank',
    'points'
];


    public function participant()
{
    return $this->belongsTo(Participant::class);
}

public function event()
{
    return $this->hasOneThrough(
        Event::class,
        Participant::class,
        'id',        // participant PK
        'id',        // event PK
        'participant_id', // FK in scores
        'event_id'        // FK in participants
    );
}

}
