@extends('layouts.admin')

@section('content')

<div class="container">

    {{-- --------------------------------------------- --}}
    {{--                HEADER TITLE                   --}}
    {{-- --------------------------------------------- --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold">College Fest Result System</h2>
        <p class="text-muted">Manage Events, Participants, Marks & Final Scores</p>
    </div>

    {{-- --------------------------------------------- --}}
    {{--                TOP MENU CARDS                 --}}
    {{-- --------------------------------------------- --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <a href="{{ route('events.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-left-primary h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Events</h5>
                        <p class="text-muted m-0">Add & Manage Events</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('participants.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-left-success h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Participants</h5>
                        <p class="text-muted m-0">Manage Participants</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('scores.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-left-warning h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Mark Entry</h5>
                        <p class="text-muted m-0">Enter Marks & Grades</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('results.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-left-danger h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Final Results</h5>
                        <p class="text-muted m-0">View Rankings & Scores</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- --------------------------------------------- --}}
    {{--                 EXTRA BUTTONS                 --}}
    {{-- --------------------------------------------- --}}
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <a href="{{ route('results.matrix') }}" class="btn btn-outline-primary w-100 py-3 fw-bold">
                📊 Matrix Results
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('chest.summary') }}" class="btn btn-outline-info w-100 py-3 fw-bold">
                🔍 Chest Summary
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('secure.change.form') }}" class="btn btn-outline-warning w-100 py-3 fw-bold">
                🔐 Change Password
            </a>
        </div>

    </div>


</div>

@endsection
