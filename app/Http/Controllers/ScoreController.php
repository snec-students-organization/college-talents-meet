<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index(Request $request)
{
    $events = Event::with('participants.score')->get();

    // Filtering options
    if ($request->stage_type) {
        $events = $events->where('stage_type', $request->stage_type);
    }

    if ($request->section) {
        $events = $events->where('section', $request->section);
    }

    // Add computed property: score_completed
    foreach ($events as $event) {
        $total = $event->participants->count();
        $completed = $event->participants->whereNotNull('score.mark')
                                        ->whereNotNull('score.grade')
                                        ->count();

        $event->score_completed = ($total > 0 && $total == $completed);
    }

    return view('scores.index', compact('events'));
}



    public function showEventParticipants($event_id)
    {
        $event = Event::findOrFail($event_id);
        $participants = Participant::where('event_id', $event_id)
            ->with('score')
            ->get();

        return view('scores.mark_entry', compact('event', 'participants'));
    }

    public function saveMark(Request $request)
{
    $request->validate([
        'participant_id' => 'required',
        'mark'           => 'nullable|numeric',
        'grade'          => 'required|in:A+,A,B,C,D,NG'
    ]);

    Score::updateOrCreate(
        [
            'participant_id' => $request->participant_id,
        ],
        [
            'mark'  => $request->mark,
            'grade' => $request->grade
        ]
    );

    return back()->with('success', 'Mark & Grade Updated Successfully!');
}


    private function calculateGrade($mark)
    {
        if ($mark === null || $mark === '') {
            return 'NG'; // No Grade
        }

        if ($mark >= 90) return 'A+';
        if ($mark >= 80) return 'A';
        if ($mark >= 70) return 'B';
        if ($mark >= 60) return 'C';

        return 'NG';
    }
}
