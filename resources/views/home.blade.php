@extends('layouts.admin')

@section('content')

@php
    // Determine Winner
    $winner = null;

    if ($thurasScore > $aqeedaScore) $winner = 'Thuras';
    if ($aqeedaScore > $thurasScore) $winner = 'Aqeeda';
@endphp

<div class="container">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">College Fest Result Management System</h2>
        <p class="text-muted">Manage Events, Participants, Scoring & Final Results</p>
    </div>

    <!-- MAIN MENU CARDS -->
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <a href="/events" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Events</h5>
                        <p class="text-muted">Add & Manage Events</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="/participants" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Participants</h5>
                        <p class="text-muted">Add Participants to Events</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="/scores" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Mark Entry</h5>
                        <p class="text-muted">Enter Marks & Grades</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="/results" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Final Results</h5>
                        <p class="text-muted">Rankings & Team Scores</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- EXTRA ACTION BUTTONS -->
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <a href="/matrix-results" class="btn btn-outline-primary w-100 py-3 fw-bold">
                📊 Matrix Results
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="/chest-summary" class="btn btn-outline-info w-100 py-3 fw-bold">
                🔍 Chest Number Summary
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('secure.change.form') }}" class="btn btn-outline-warning w-100 py-3 fw-bold">
                🔐 Change Password
            </a>
        </div>

    </div>

    <!-- TEAM SCOREBOARD -->
    <div class="row mt-4">

        <!-- THURAS -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm 
                @if($winner == 'Thuras') border border-warning border-3 @endif">
                <div class="card-body text-center bg-primary text-white rounded">
                    <h4>Thuras</h4>
                    <h1 class="fw-bold">{{ $thurasScore }}</h1>
                    <p>Total Points</p>
                </div>
            </div>
        </div>

        <!-- AQEEDA -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm 
                @if($winner == 'Aqeeda') border border-warning border-3 @endif">
                <div class="card-body text-center bg-success text-white rounded">
                    <h4>Aqeeda</h4>
                    <h1 class="fw-bold">{{ $aqeedaScore }}</h1>
                    <p>Total Points</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
 