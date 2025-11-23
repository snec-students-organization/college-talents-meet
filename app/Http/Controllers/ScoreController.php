<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // ================================
    // SHOW EVENT LIST
    // ================================
    public function index(Request $request)
{
    $events = Event::query();

    // Filter by stage_type
    if ($request->stage_type) {
        $events->where('stage_type', $request->stage_type);
    }

    // Filter by section
    if ($request->section) {
        $events->where('section', $request->section);
    }

    // Get filtered (or all) results
    $events = $events->orderBy('name')->get();

    return view('scores.index', compact('events'));
}


    // ================================
    // SHOW MARK ENTRY PAGE
    // ================================
    public function showEventParticipants($event_id)
    {
        $event = Event::findOrFail($event_id);

        // GENERAL → Always treat as group event
        if ($event->section === "general") {
            $event->type = "group";
        }

        $participants = Participant::where('event_id', $event_id)
                                  ->with('score')
                                  ->orderBy('team')
                                  ->orderBy('group_name')
                                  ->get();

        return view('scores.mark_entry', compact('event', 'participants'));
    }

    // ================================
    // SAVE MARK (ROUTER)
    // ================================
    public function saveMark(Request $request)
    {
        if ($request->is_group == 1) {
            return $this->saveGroupScore($request);
        }

        return $this->saveIndividualScore($request);
    }

    // ================================
    // SAVE INDIVIDUAL SCORE
    // ================================
    private function saveIndividualScore(Request $request)
    {
        $participant = Participant::with('event')->findOrFail($request->participant_id);

        $rank  = $request->rank;
        $grade = $request->grade;

        $points = $this->calculatePoints($participant->event->category, $rank, $grade);

        Score::updateOrCreate(
            ['participant_id' => $participant->id],
            [
                'event_id'      => $participant->event_id,
                'team'          => $participant->team,
                'group_name'    => null,
                'mark'          => $request->mark,
                'grade'         => $grade,
                'rank'          => $rank,
                'points'        => $points,
            ]
        );

        return back()->with('success', 'Individual Score Saved');
    }

    // ================================
    // SAVE GROUP SCORE
    // ================================
    private function saveGroupScore(Request $request)
    {
        $event_id  = $request->event_id;
        $groupName = $request->group_name;

        if (!$groupName) {
            return back()->with('error', 'Group Name Missing');
        }

        // Find members based on manual group name
        $members = Participant::where('event_id', $event_id)
                              ->where('group_name', $groupName)
                              ->get();

        if ($members->count() == 0) {
            return back()->with('error', 'No members found for group: '.$groupName);
        }

        $rank  = $request->rank;
        $grade = $request->grade;

        // Calculate points
        $event = Event::findOrFail($event_id);
        $points = $this->calculatePoints($event->category, $rank, $grade);

        // Remove old scores for this group
        Score::whereIn('participant_id', $members->pluck('id'))->delete();

        // Save score for each group member
        foreach ($members as $m) {
            Score::create([
                'event_id'      => $event_id,
                'team'          => $m->team,
                'participant_id'=> $m->id,
                'group_name'    => $groupName,
                'mark'          => $request->mark,
                'grade'         => $grade,
                'rank'          => $rank,
                'points'        => $points,
            ]);
        }

        return back()->with('success', "Score saved for group: $groupName");
    }

    // ================================
    // POINT CALCULATION
    // ================================
    private function calculatePoints($category, $rank, $grade)
    {
        $rankPointsTable = [
            'A' => [1 => 10, 2 => 7, 3 => 5],
            'B' => [1 => 7,  2 => 5, 3 => 3],
            'C' => [1 => 5,  2 => 3, 3 => 1],
            'D' => [1 => 20, 2 => 15, 3 => 10],
        ];

        $gradePoints = [
            'A+' => 5,
            'A'  => 5,
            'B'  => 3,
            'C'  => 1,
            'D'  => 1,
            'NG' => 0,
        ];

        $rp = $rankPointsTable[$category][$rank] ?? 0;
        $gp = $gradePoints[$grade] ?? 0;

        return $rp + $gp;
    }
}
