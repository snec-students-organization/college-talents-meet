@extends('layouts.admin')

@section('content')

<div class="container">

    <h2 class="fw-bold mb-4 text-center">Matrix Results (All Sections)</h2>

    <a href="{{ route('results.index') }}" class="btn btn-secondary mb-3">
        ← Back to Events
    </a>

    @foreach($events as $event)

        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    {{ $event->name }} —
                    {{ ucfirst($event->section) }} |
                    {{ ucfirst($event->stage_type) }} |
                    Category {{ $event->category }}
                </h5>
            </div>

            <div class="card-body p-0">

                <table class="table table-bordered table-striped text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Team</th>
                            <th>Participant</th>
                            <th>Chest No</th>
                            <th>Mark</th>
                            <th>Grade</th>
                            <th>Rank</th>
                            <th>Points</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($event->participants as $p)

                        @php
                            $score  = $p->score;
                            $mark   = $score->mark   ?? 0;
                            $grade  = $score->grade  ?? 'NG';
                            $rank   = $score->rank   ?? '-';
                            $points = $score->points ?? 0;
                        @endphp

                        <tr>
                            <!-- TEAM -->
                            <td>
                                <span class="badge {{ $p->team == 'Thuras' ? 'bg-primary' : 'bg-success' }}">
                                    {{ $p->team }}
                                </span>
                            </td>

                            <!-- NAME -->
                            <td class="fw-bold">{{ $p->name }}</td>

                            <!-- CHEST -->
                            <td>{{ $p->chest_no }}</td>

                            <!-- MARK -->
                            <td>{{ $mark }}</td>

                            <!-- GRADE -->
                            <td>{{ $grade }}</td>

                            <!-- RANK -->
                            <td>
                                @if($rank == 1) 🥇 1st
                                @elseif($rank == 2) 🥈 2nd
                                @elseif($rank == 3) 🥉 3rd
                                @else — @endif
                            </td>

                            <!-- POINTS -->
                            <td class="fw-bold">{{ $points }}</td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    @endforeach

</div>

@endsection
