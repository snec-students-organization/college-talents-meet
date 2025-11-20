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

        // Filters
        if ($request->stage_type) {
            $events = $events->where('stage_type', $request->stage_type);
        }

        if ($request->section) {
            $events = $events->where('section', $request->section);
        }

        // Add computed status for event completion
        foreach ($events as $event) {
            $total = $event->participants->count();
            $completed = $event->participants
                                ->whereNotNull('score.mark')
                                ->whereNotNull('score.grade')
                                ->whereNotNull('score.rank')
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
        
        $participantId = $request->participant_id;

        $participant = Participant::with('event')->find($participantId);
        $event = $participant->event;

        $mark  = $request->mark;
        $grade = $request->grade;
        $rank  = $request->rank;

        // --------------------------------
        //  CATEGORY RANK POINTS
        // --------------------------------
        $category = $event->category;
        $rankPoints = 0;

        if ($category == 'A') {
            $rankPoints = [1 => 10, 2 => 7, 3 => 5][$rank] ?? 0;
        }
        elseif ($category == 'B') {
            $rankPoints = [1 => 7, 2 => 5, 3 => 3][$rank] ?? 0;
        }
        elseif ($category == 'C') {
            $rankPoints = [1 => 5, 2 => 3, 3 => 1][$rank] ?? 0;
        }
        elseif ($category == 'D') {
            $rankPoints = [1 => 20, 2 => 15, 3 => 10][$rank] ?? 0;
        }

        // --------------------------------
        //  GRADE POINTS
        // --------------------------------
        $gradePoints = 0;

        if ($grade == 'A+' || $grade == 'A') $gradePoints = 5;
        if ($grade == 'B') $gradePoints = 3;
        if ($grade == 'C') $gradePoints = 1;
        if ($grade == 'D') $gradePoints = 0;  // optional
        if ($grade == 'NG') $gradePoints = 0;

        // --------------------------------
        //  FINAL TEAM POINTS
        // --------------------------------
        $totalPoints = $rankPoints + $gradePoints;

        // --------------------------------
        //  SAVE / UPDATE SCORE
        // --------------------------------
        Score::updateOrCreate(
            ['participant_id' => $participantId],
            [
                'mark'   => $mark,
                'grade'  => $grade,
                'rank'   => $rank,
                'points' => $totalPoints
            ]
        );

        return back()->with('success', 'Score updated successfully!');
    }


}
