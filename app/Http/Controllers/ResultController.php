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

    if ($request->stage_type) {
        $events->where('stage_type', $request->stage_type);
    }

    $events = $events->get();

    return view('results.index', compact('events'));
}


    public function showEventResults($event_id)
{
    $event = Event::findOrFail($event_id);

    $participants = Participant::with('score')
        ->where('event_id', $event_id)
        ->get();

    // Sort participants by marks (high → low)
    $sorted = $participants->sortByDesc(function ($p) {
        return $p->score->mark ?? 0;
    })->values();

    // Assign ranks manually
    foreach ($sorted as $index => $p) {
        $p->rank = $index + 1;
    }

    // Team points calculation
    $teamPoints = [
        'Thuras' => 0,
        'Aqeeda' => 0,
    ];

    foreach ($sorted as $p) {
        $rankPoints  = $this->rankPoints($event->category, $p->rank);
        $gradePoints = $this->gradePoints($p->score->grade ?? 'NG');

        $totalPoints = $rankPoints + $gradePoints;

        $p->rank_points  = $rankPoints;
        $p->grade_points = $gradePoints;
        $p->total_points = $totalPoints;

        // Add to team total
        $teamPoints[$p->team] += $totalPoints;
    }

    return view('results.event_result', compact('event', 'sorted', 'teamPoints'));
}
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
private function gradePoints($grade)
{
    return match ($grade) {
        
        'A'  => 5,
        'B'  => 3,
        'C'  => 1,
        default => 0,
    };
}

public function matrix()
{
    // Load all events with participants and scores
    $events = Event::with(['participants.score'])->get();

    // Group by sections and stage types
    $groups = [
        'Junior - Stage'     => $events->where('section', 'junior')->where('stage_type', 'stage'),
        'Junior - Offstage'  => $events->where('section', 'junior')->where('stage_type', 'offstage'),
        'Senior - Stage'     => $events->where('section', 'senior')->where('stage_type', 'stage'),
        'Senior - Offstage'  => $events->where('section', 'senior')->where('stage_type', 'offstage'),
    ];

    // For each event calculate team points
    foreach ($events as $event) {

        $event->thuras_points = 0;
        $event->aqeeda_points = 0;

        // sort participants by mark desc
        $sorted = $event->participants->sortByDesc(function ($p) {
            return $p->score->mark ?? 0;
        })->values();

        // assign rank
        foreach ($sorted as $idx => $p) {
            $p->rank = $idx + 1;
        }

        // calculate points
        foreach ($sorted as $p) {

            $rankPoints  = $this->rankPoints($event->category, $p->rank);
            $gradePoints = $this->matrixGradePoints($p->score->grade ?? 'NG');
            $totalPoints = $rankPoints + $gradePoints;

            if ($p->team === 'Thuras') {
                $event->thuras_points += $totalPoints;
            } else {
                $event->aqeeda_points += $totalPoints;
            }
        }

        // Winner
        if ($event->thuras_points > $event->aqeeda_points) {
            $event->winner = 'Thuras';
        } elseif ($event->aqeeda_points > $event->thuras_points) {
            $event->winner = 'Aqeeda';
        } else {
            $event->winner = 'Tie';
        }
    }

    return view('results.matrix', compact('groups'));
}

// Grade points for matrix
private function matrixGradePoints($grade)
{
    return match ($grade) {
        'A+' => 5,
        'A'  => 5,
        'B'  => 3,
        'C'  => 1,
        'D'  => 0,
        default => 0,
    };
}




}

