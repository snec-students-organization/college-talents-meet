<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ChestSummaryController;
use App\Models\Score;   // ✔ Required for team calculation

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/', function () {

    // 🔐 Security Check
    if (!session('authenticated')) {
        return redirect('/secure');
    }

    // Fetch all scores with participant data
    $scores = Score::with('participant')->get();

    $thurasScore = 0;
    $aqeedaScore = 0;

    foreach ($scores as $score) {

        // Skip if participant record missing
        if (!$score->participant) continue;

        // Add to correct team
        if ($score->participant->team === 'Thuras') {
            $thurasScore += $score->points;   // Rank Points + Grade Points
        } 
        else {
            $aqeedaScore += $score->points;
        }
    }

    // Show home page with team totals
    return view('home', compact('thurasScore', 'aqeedaScore'));
    
})->name('home');



// 🔐 SECURITY ROUTES
Route::get('/secure', [SecurityController::class, 'check']);
Route::post('/secure/set', [SecurityController::class, 'storePassword'])->name('secure.set');
Route::post('/secure/login', [SecurityController::class, 'verify'])->name('secure.login');

Route::get('/secure/change-password', [SecurityController::class, 'changePasswordForm'])->name('secure.change.form');
Route::post('/secure/change-password', [SecurityController::class, 'changePassword'])->name('secure.change');


// ------------------------------
// EVENTS
// ------------------------------
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events/store', [EventController::class, 'store'])->name('events.store');


// ------------------------------
// PARTICIPANTS
// ------------------------------
Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
Route::get('/participants/create', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/participants/store', [ParticipantController::class, 'store'])->name('participants.store');


// ------------------------------
// MARK ENTRY
// ------------------------------
Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
Route::get('/scores/event/{id}', [ScoreController::class, 'showEventParticipants'])->name('scores.event');
Route::post('/scores/save', [ScoreController::class, 'saveMark'])->name('scores.save');


// ------------------------------
// FINAL RESULTS (RANK + TEAM POINTS)
// ------------------------------
Route::get('/results', [ResultController::class, 'index'])->name('results.index');
Route::get('/results/event/{id}', [ResultController::class, 'showEventResults'])->name('results.event');

Route::get('/matrix-results', [ResultController::class, 'matrix'])->name('results.matrix');


// ------------------------------
// CHEST SUMMARY
// ------------------------------
Route::get('/chest-summary', [ChestSummaryController::class, 'search'])->name('chest.summary.search');
Route::post('/chest-summary/result', [ChestSummaryController::class, 'result'])->name('chest.summary.result');


// ------------------------------
// PARTICIPANT SUMMARY & RANKING
// ------------------------------
Route::get('/participant/summary/{chest_no}', 
    [ParticipantController::class, 'summary'])->name('participant.summary');

Route::get('/participants/ranking', 
    [ParticipantController::class, 'ranking'])->name('participants.ranking');
