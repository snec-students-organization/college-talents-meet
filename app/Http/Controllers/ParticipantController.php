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
  public function ranking()
{
    // 1️⃣ Load fixed participant list
    $fixed = \DB::table('fixed_participants')->get();

    // 2️⃣ Load only INDIVIDUAL event scores (group_name = null)
    $allScores = Participant::whereNotNull('chest_no')
        ->join('scores', 'participants.id', '=', 'scores.participant_id')
        ->whereNull('scores.group_name') // only individual events
        ->select(
            'participants.*',
            'scores.mark',
            'scores.points',
            \DB::raw('COALESCE(scores.negative_mark, 0) as negative_mark') // ⭐ SAFE
        )
        ->get()
        ->groupBy('chest_no');

    // 3️⃣ Build ranking list
    $ranking = $fixed->map(function ($fp) use ($allScores) {

        $scores = $allScores->get($fp->chest_no, collect());

        $eventCount   = $scores->count();
        $totalMarks   = $scores->sum('mark');                    // original marks
        $negativeMark = $scores->sum('negative_mark');           // ⭐ safe always number
        $finalMarks   = $totalMarks - $negativeMark;             // ⭐ final marks
        $totalPoints  = $scores->sum('points');                  // points unchanged

        // Avoid division by zero
        $percentage = ($eventCount > 0)
            ? round(($finalMarks / ($eventCount * 10)) * 100)
            : 0;

        return (object)[
            'name'          => $fp->name,
            'team'          => $fp->team,
            'chest_no'      => $fp->chest_no,
            'event_count'   => $eventCount,
            'total_marks'   => $totalMarks,
            'negative_mark' => $negativeMark,
            'final_marks'   => $finalMarks,
            'points'        => $totalPoints,
            'percentage'    => $percentage,
        ];
    })
    ->sortByDesc('percentage')
    ->values();

    return view('participants.ranking', compact('ranking'));
}


public function summary($chest_no)
{
    // Find participant
    $participant = Participant::where('chest_no', $chest_no)->firstOrFail();

    // Load ONLY individual scores
    $scores = Score::whereIn(
        'participant_id',
        Participant::where('chest_no', $chest_no)
            ->whereNull('group_name')   // ✅ IGNORE group events
            ->pluck('id')
    )
    ->with('event')
    ->get();

    // Total individual events
    $totalEvents = $scores->count();

    // Total marks
    $totalMarks = $scores->sum('mark');

    // Percentage out of 10 per event
    $percentage = ($totalEvents > 0)
        ? round(($totalMarks / ($totalEvents * 10)) * 100)
        : 0;

    // Rank + Grade points
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

public function saveNegativeMark(Request $request)
{
    $request->validate([
        'chest_no'       => 'required',
        'negative_mark'  => 'required|integer'
    ]);

    // Get all individual event scores for this chest number
    $scores = Score::whereIn('participant_id',
                Participant::where('chest_no', $request->chest_no)->pluck('id')
            )
            ->whereNull('group_name') // apply only to individual scores
            ->get();

    foreach ($scores as $score) {
        $score->negative_mark = $request->negative_mark;
        $score->save();
    }

    return back()->with('success', 'Negative mark updated successfully!');
}






}
