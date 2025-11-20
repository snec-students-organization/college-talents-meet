@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>
            Final Results - {{ $event->name }} 
            ({{ ucfirst($event->section) }}) 
            - {{ ucfirst($event->stage_type) }} 
            - Category {{ $event->category }}
        </h4>
    </div>

    <div class="card-body">

        <!-- TEAM POINT SUMMARY -->
        <div class="row mb-4">

            <div class="col-md-6">
                <div class="alert alert-primary text-center">
                    <h4 class="fw-bold mb-0">Thuras</h4>
                    <h2 class="fw-bold">{{ $teamPoints['Thuras'] }}</h2>
                    <small>Total Points</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="alert alert-success text-center">
                    <h4 class="fw-bold mb-0">Aqeeda</h4>
                    <h2 class="fw-bold">{{ $teamPoints['Aqeeda'] }}</h2>
                    <small>Total Points</small>
                </div>
            </div>

        </div>

        <!-- FINAL RESULTS TABLE -->
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Chest No</th>
                    <th>Name</th>
                    <th>Team</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Rank Points</th>
                    <th>Grade Points</th>
                    <th>Total Points</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sorted as $p)
                <tr>
                    <td><strong>{{ $p->rank }}</strong></td>
                    <td>{{ $p->chest_no }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->team }}</td>
                    <td>{{ $p->score->mark ?? '-' }}</td>
                    <td>{{ $p->score->grade ?? 'NG' }}</td>
                    <td>{{ $p->rank_points }}</td>
                    <td>{{ $p->grade_points }}</td>
                    <td><strong>{{ $p->total_points }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
