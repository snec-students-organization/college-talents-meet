<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // ================================
    // 🔵 MARK ENTRY INDEX
    // ================================
    public function index(Request $request)
    {
        $events = Event::with('participants.score')->get();

        // Filter (optional)
        if ($request->stage_type) {
            $events = $events->where('stage_type', $request->stage_type);
        }

        if ($request->section) {
            $events = $events->where('section', $request->section);
        }

        // Completed / Pending indicator
        foreach ($events as $event) {
            $total = $event->participants->count();
            $completed = $event->participants->whereNotNull('score.mark')->count();
            $event->score_completed = ($total > 0 && $total == $completed);
        }

        return view('scores.index', compact('events'));
    }

    // ================================
    // 🔵 SHOW PARTICIPANTS
    // ================================
    public function showEventParticipants($event_id)
    {
        $event = Event::findOrFail($event_id);

        // General section ALWAYS group type
        if ($event->section === "general") {
            $event->type = "group";
        }

        $participants = Participant::where('event_id', $event_id)
                                  ->with('score')
                                  ->get();

        return view('scores.mark_entry', compact('event', 'participants'));
    }

    // ================================
    // 🔵 SAVE SCORE (DECIDES MODE)
    // ================================
    public function saveMark(Request $request)
    {
        // is_group is sent from mark_entry.blade.php
        if ($request->is_group == 1) {
            return $this->saveGroupScore($request);
        }

        return $this->saveIndividualScore($request);
    }

    // ================================
    // 🔵 SAVE INDIVIDUAL SCORE
    // ================================
    private function saveIndividualScore(Request $request)
    {
        $participant = Participant::with('event')->findOrFail($request->participant_id);
        $event = $participant->event;

        $rank = $request->rank;
        $grade = $request->grade;

        $points = $this->calculatePoints($event->category, $rank, $grade);

        Score::updateOrCreate(
            ['participant_id' => $participant->id],
            [
                'mark'   => $request->mark,
                'grade'  => $grade,
                'rank'   => $rank,
                'points' => $points,
            ]
        );

        return back()->with('success', 'Individual Score Saved');
    }

    // ================================
    // 🟩 SAVE GROUP SCORE (USING group_id)
    // ================================
    private function saveGroupScore(Request $request)
    {
        $event_id = $request->event_id;
        $group_id = $request->group_id;

        $members = Participant::where('event_id', $event_id)
                              ->where('group_id', $group_id)
                              ->get();

        if ($members->count() == 0) {
            return back()->with('error', 'No group members found.');
        }

        $event = Event::findOrFail($event_id);

        $rank  = $request->rank;
        $grade = $request->grade;

        $points = $this->calculatePoints($event->category, $rank, $grade);

        // Delete old scores for this group (avoid duplicates)
        Score::whereIn('participant_id', $members->pluck('id'))->delete();

        // Save score for ALL group members
        foreach ($members as $m) {
            Score::create([
                'participant_id' => $m->id,
                'mark'           => $request->mark,
                'grade'          => $grade,
                'rank'           => $rank,
                'points'         => $points,
            ]);
        }

        return back()->with('success', 'Group Score Saved');
    }

    // ================================
    // 🔶 POINT CALCULATION
    // ================================
    private function calculatePoints($category, $rank, $grade)
    {
        // Rank points per category
        $rankPointsTable = [
            'A' => [1 => 10, 2 => 7, 3 => 5],
            'B' => [1 => 7,  2 => 5, 3 => 3],
            'C' => [1 => 5,  2 => 3, 3 => 1],
            'D' => [1 => 20, 2 => 15, 3 => 10],
        ];

        $rankPoints = $rankPointsTable[$category][$rank] ?? 0;

        // Grade points
        $gradePoints = [
            'A+' => 5,
            'A'  => 5,
            'B'  => 3,
            'C'  => 1,
            'D'  => 1,
            'NG' => 0
        ];

        $gp = $gradePoints[$grade] ?? 0;

        return $rankPoints + $gp;
    }
}
