@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h4>Summary for Chest No: {{ $participants->first()->chest_no }}</h4>
        </div>

        <div class="card-body">
            <h5><strong>Name:</strong> {{ $participants->first()->name }}</h5>
            <h5><strong>Team:</strong> {{ $participants->first()->team }}</h5>
            <h5><strong>Total Programs:</strong> {{ $totalPrograms }}</h5>
            <h5><strong>Total Points Earned:</strong> {{ $totalPoints }}</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5>Program Details</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>Category</th>
                        <th>Rank</th>
                        <th>Grade</th>
                        <th>Rank Points</th>
                        <th>Grade Points</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($participants as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->event->name }}</td>
                        <td>{{ $p->event->category }}</td>
                        <td>{{ $p->score->rank ?? '-' }}</td>
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

</div>

@endsection
