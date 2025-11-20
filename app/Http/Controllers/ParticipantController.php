<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Participant;
use App\Models\Event;
use App\Models\Score;


class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with('event')->get();
        return view('participants.index', compact('participants'));
    }


    public function create()
    {
        $events = Event::all();
        $fixed  = DB::table('fixed_participants')->get();

        return view('participants.create', compact('events', 'fixed'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fixed_id' => 'required',
            'event_id' => 'required',
        ]);

        // Fetch the fixed participant
        $fixed = DB::table('fixed_participants')->where('id', $request->fixed_id)->first();

        if (!$fixed) {
            return back()->withErrors(['fixed_id' => 'Participant not found in fixed list.']);
        }

        // Create participant entry linked to event
        Participant::create([
            'name'      => $fixed->name,
            'team'      => $fixed->team,
            'chest_no'  => $fixed->chest_no,
            'event_id'  => $request->event_id,
        ]);

        return redirect()->back()->with('success', 'Participant added successfully!');
    }


    public function destroy($id)
    {
        Participant::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Participant removed.');
    }
    public function summary($chest_no)
{
    // Get all event entries for this participant
    $records = Participant::where('chest_no', $chest_no)
                ->with('event')
                ->get();

    // Calculate scores
    $totalScored = 0;
    $totalPossible = 0;

    foreach ($records as $rec) {
        $score = Score::where('participant_id', $rec->id)->first();

        if ($score) {
            $totalScored += $score->mark; // scored out of 10
            $totalPossible += 10;         // each event = 10 mark max
        }
    }

    // Final percentage
    $percentage = ($totalPossible > 0)
                    ? ($totalScored / $totalPossible) * 100
                    : 0;

    return view('participants.summary', [
        'records'      => $records,
        'totalScored'  => $totalScored,
        'totalPossible'=> $totalPossible,
        'percentage'   => $percentage,
        'chest_no'     => $chest_no
    ]);
}
public function ranking()
{
    // Get all participants grouped by chest number
    $grouped = Participant::with('event')->get()->groupBy('chest_no');

    $ranking = [];

    foreach ($grouped as $chest => $items) 
    {
        $name = $items->first()->name;
        $team = $items->first()->team;

        // Score calculation
        $totalScored = 0;
        $totalPossible = 0;

        foreach ($items as $p) {
            $score = Score::where('participant_id', $p->id)->first();
            
            if ($score) {
                $totalScored += $score->mark; // out of 10
                $totalPossible += 10;
            }
        }

        $percentage = ($totalPossible > 0)
                        ? ($totalScored / $totalPossible) * 100
                        : 0;

        $ranking[] = [
            'name'       => $name,
            'chest_no'   => $chest,
            'team'       => $team,
            'scored'     => $totalScored,
            'possible'   => $totalPossible,
            'percentage' => $percentage,
            'events'     => $items,
        ];
    }

    // Sort by percentage (highest first)
    $ranking = collect($ranking)->sortByDesc('percentage')->values();

    return view('participants.ranking', compact('ranking'));
}


}
