<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ChestSummaryController extends Controller
{
    public function search()
    {
        return view('chest.summary_search');
    }

    public function result(Request $request)
    {
        $request->validate([
            'chest_no' => 'required'
        ]);

        // Get all events where this chest number participated
        $participants = Participant::with(['event', 'score'])
            ->where('chest_no', $request->chest_no)
            ->get();

        if ($participants->count() == 0) {
            return back()->with('error', 'Chest Number not found or no programs.');
        }

        // Calculate totals
        $totalPrograms = $participants->count();
        $totalPoints = 0;

        foreach ($participants as $p) {
            $rankPoints = $this->rankPoints($p->event->category, $p->score->rank ?? null);
            $gradePoints = $this->gradePoints($p->score->grade ?? 'NG');

            $p->rank_points = $rankPoints;
            $p->grade_points = $gradePoints;
            $p->total_points = $rankPoints + $gradePoints;

            $totalPoints += $p->total_points;
        }

        return view('chest.summary_result', compact('participants', 'totalPrograms', 'totalPoints'));
    }

    private function rankPoints($category, $rank)
    {
        $table = [
            'A' => [1 => 10, 2 => 7, 3 => 5],
            'B' => [1 => 7, 2 => 5, 3 => 3],
            'C' => [1 => 5, 2 => 3, 3 => 1],
            'D' => [1 => 20, 2 => 15, 3 => 10],
        ];

        return $table[$category][$rank] ?? 0;
    }

    private function gradePoints($grade)
    {
        return match($grade) {
            'A+', 'A' => 5,
            'B'       => 3,
            'C'       => 1,
            'D'       => 0,
            default   => 0,
        };
    }
}
