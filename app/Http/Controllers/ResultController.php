<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
{
    $events = Event::query();

    if ($request->search) {
        $events->where('name', 'LIKE', '%' . $request->search . '%');
    }

    if ($request->section) {
        $events->where('section', $request->section);
    }

    if ($request->category) {
        $events->where('category', $request->category);
    }

    if ($request->stage_type) {
        $events->where('stage_type', $request->stage_type);
    }

    if ($request->type) {
        $events->where('type', $request->type);
    }

    $events = $events->orderBy('name')->get();

    return view('results.index', compact('events'));
}



    public function showEventResults($eventId)
{
    $event = Event::findOrFail($eventId);

    $participants = Participant::leftJoin('scores', 'scores.participant_id', '=', 'participants.id')
        ->where('participants.event_id', $eventId) // FIXED HERE
        ->orderByRaw("
            CASE 
                WHEN scores.rank = 1 THEN 1
                WHEN scores.rank = 2 THEN 2
                WHEN scores.rank = 3 THEN 3
                ELSE 4
            END
        ")
        ->select('participants.*')
        ->with('score')
        ->get();

    return view('results.event_results', compact('event', 'participants'));
}



    // ---------------------------
    // Matrix Page (FINAL VERSION)
    // ---------------------------
    public function matrixResults()
    {
        // Load all events + participants + score
        $events = Event::with(['participants.score'])->get();

        return view('results.matrix', compact('events'));
    }



    /* Rank Points */
    private function rankPoints($category, $rank)
    {
        $table = [
            'A' => [1 => 10, 2 => 7, 3 => 5],
            'B' => [1 => 7,  2 => 5, 3 => 3],
            'C' => [1 => 5,  2 => 3, 3 => 1],
            'D' => [1 => 20, 2 => 15, 3 => 10],
        ];

        return $table[$category][$rank] ?? 0;
    }

    /* Grade Points */
    private function gradePoints($grade)
    {
        return match ($grade) {
            'A+' => 5,
            'A'  => 5,
            'B'  => 3,
            'C'  => 1,
            default => 0,
        };
    }
    
}
