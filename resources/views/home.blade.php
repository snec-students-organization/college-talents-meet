@extends('layouts.admin')

@section('content')

<div class="container">

    <!-- WELCOME HEADER -->
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-1">College Fest Result Management System</h2>
        <p class="text-muted">Manage Events, Participants, Scores & Final Results Efficiently</p>
    </div>

    <!-- MAIN ACTION CARDS -->
    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <a href="/events" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Events</h5>
                        <p class="text-muted mb-0">Add & Manage Events</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/participants" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Participants</h5>
                        <p class="text-muted mb-0">Add Students to Events</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/scores" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Mark Entry</h5>
                        <p class="text-muted mb-0">Enter Marks & Grades</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/results" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Final Results</h5>
                        <p class="text-muted mb-0">View Ranks & Team Scores</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- EXTRA OPTIONS -->
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <a href="/matrix-results" class="btn btn-outline-primary w-100 py-3 fw-bold shadow-sm">
                📊 Matrix Results
            </a>
        </div>

        <div class="col-md-4">
            <a href="/participants/ranking" class="btn btn-outline-dark w-100 py-3 fw-bold shadow-sm">
                🏆 Participant Ranking
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('secure.change.form') }}" class="btn btn-outline-warning w-100 py-3 fw-bold shadow-sm">
                🔐 Change Password
            </a>
        </div>

    </div>

    <!-- TEAM SCOREBOARD -->
    <h3 class="fw-bold mt-4 mb-3">🏅 Team Scoreboard</h3>

    <div class="row g-4">

        <div class="col-md-6">
            <div class="card shadow-lg border-0 text-white" style="background: #007bff;">
                <div class="card-body text-center py-5">
                    <h3 class="fw-bold">Team Thuras</h3>
                    <h1 class="fw-bold display-3">{{ $thurasScore }}</h1>
                    <p class="mb-0">Total Points</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg border-0 text-white" style="background: #28a745;">
                <div class="card-body text-center py-5">
                    <h3 class="fw-bold">Team Aqeeda</h3>
                    <h1 class="fw-bold display-3">{{ $aqeedaScore }}</h1>
                    <p class="mb-0">Total Points</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
