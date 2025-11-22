@extends('layouts.admin')

@section('content')

<div class="card w-75 mx-auto">

    <div class="card-header text-center">
        <h3 class="fw-bold">Participant Summary</h3>
        <p class="mb-0">Chest No: <strong>{{ $participant->chest_no }}</strong></p>
        <p class="mb-0">Name: <strong>{{ $participant->name }}</strong></p>
        <p class="mb-0">Team: <strong>{{ $participant->team }}</strong></p>
    </div>

    <div class="card-body">

        <h5>Total Events: <strong>{{ $totalEvents }}</strong></h5>
        <h5>Total Marks: <strong>{{ $totalMarks }}</strong></h5>
        <h5>Percentage: <strong>{{ $percentage }}%</strong></h5>
        <h5>Total Points (Rank + Grade): <strong>{{ $totalPoints }}</strong></h5>

        <hr>

        <h4 class="mt-4 mb-3">Event-wise Performance</h4>

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Event</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Rank</th>
                    <th>Points</th>
                </tr>
            </thead>

            <tbody>
            @foreach($scores as $s)
                <tr>
                    <td>{{ $s->event->name }}</td>
                    <td>{{ $s->mark }}</td>
                    <td>{{ $s->grade }}</td>
                    <td>
                        @if($s->rank == 1) 🥇 1st
                        @elseif($s->rank == 2) 🥈 2nd
                        @elseif($s->rank == 3) 🥉 3rd
                        @else — @endif
                    </td>
                    <td><strong>{{ $s->points }}</strong></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
