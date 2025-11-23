<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Event;
use App\Models\Score;
use App\Models\FixedParticipant;

class ParticipantController extends Controller
{
    // ---------------------------------------------------------
    // INDEX
    // ---------------------------------------------------------
    public function index()
    {
        $participants = Participant::with('event')->get();
        return view('participants.index', compact('participants'));
    }

    // ---------------------------------------------------------
    // CREATE PAGE
    // ---------------------------------------------------------
    public function create()
    {
        $events = Event::all();
        $fixed  = FixedParticipant::all(); // use model, not DB::table

        return view('participants.create', compact('events', 'fixed'));
    }

    // ---------------------------------------------------------
    // STORE PARTICIPANTS
    // ---------------------------------------------------------
   public function store(Request $request)
{
    $event = Event::findOrFail($request->event_id);

    // GROUP / GENERAL EVENT
    if ($event->type == 'group' || $event->section == 'general') {

        // User enters group name manually
        $groupName = trim($request->group_name);

        if (!$groupName) {
            return back()->with('error', 'Please enter a Group Name!');
        }

        if (!$request->members || count($request->members) == 0) {
            return back()->with('error', 'No members selected!');
        }

        foreach ($request->members as $fixedId) {

            $fixed = FixedParticipant::findOrFail($fixedId);

            Participant::create([
                'name'       => $fixed->name,
                'team'       => $fixed->team,
                'chest_no'   => $fixed->chest_no,
                'event_id'   => $event->id,
                'group_name' => $groupName,  // ONLY STORE group_name
                   // not used
            ]);
        }

        return back()->with('success', "Group '$groupName' added successfully.");
    }

    // INDIVIDUAL
    Participant::create([
        'name'       => $request->name,
        'team'       => $request->team,
        'chest_no'   => $request->chest_no,
        'event_id'   => $event->id,
        'group_name' => null,
    ]);

    return back()->with('success', 'Participant Added');
}



    // ---------------------------------------------------------
    // DELETE
    // ---------------------------------------------------------
    public function destroy($id)
    {
        Participant::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Participant removed.');
    }

    // ---------------------------------------------------------
    // SUMMARY FOR ONE PARTICIPANT
    // ---------------------------------------------------------
   public function summary($chest_no)
{
    // Find participant by chest number
    $participant = Participant::where('chest_no', $chest_no)->firstOrFail();

    // Load all scores for this chest number (group OR individual)
    $scores = Score::whereIn(
        'participant_id',
        Participant::where('chest_no', $chest_no)->pluck('id')
    )
    ->with('event')
    ->get();

    // Total events
    $totalEvents = $scores->count();

    // Total Marks (out of 10 each)
    $totalMarks = $scores->sum('mark');

    // Percentage
    $percentage = ($totalEvents > 0)
        ? round(($totalMarks / ($totalEvents * 10)) * 100)
        : 0;

    // Total Points (Rank + Grade points)
    $totalPoints = $scores->sum('points');

    return view('participants.summary', compact(
        'participant',
        'scores',
        'totalEvents',
        'totalMarks',
        'percentage',
        'totalPoints'
    ));
}


    // ---------------------------------------------------------
    // PARTICIPANT RANKING (BY PERCENTAGE)
    // ---------------------------------------------------------
    public function ranking()
{
    // Load fixed participants list
    $fixed = \DB::table('fixed_participants')->get();

    // Load scores grouped by chest_no
    $allScores = Participant::with('score', 'event')
                    ->join('scores', 'participants.id', '=', 'scores.participant_id')
                    ->get()
                    ->groupBy('chest_no');

    $ranking = $fixed->map(function ($fp) use ($allScores) {

        $scores = $allScores->get($fp->chest_no, collect());

        $eventCount = $scores->count();

        $totalMarks = $scores->sum('mark');
        $totalPoints = $scores->sum('points');

        $percentage = ($eventCount > 0)
            ? round(($totalMarks / ($eventCount * 10)) * 100)
            : 0;

        return (object)[
            'name'       => $fp->name,
            'team'       => $fp->team,
            'chest_no'   => $fp->chest_no,
            'percentage' => $percentage,
            'points'     => $totalPoints,
        ];
    })
    ->sortByDesc('percentage')
    ->values();

    return view('participants.ranking', compact('ranking'));
}

}
