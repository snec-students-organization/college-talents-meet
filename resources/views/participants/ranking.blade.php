@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="text-center mb-4">
        <h2 class="fw-bold">Participant Ranking</h2>
        <p class="text-muted">Ranked by Percentage (Marks out of 10 → 100%)</p>
    </div>

    <a href="{{ route('participants.index') }}" class="btn btn-secondary mb-3">
        ← Back to Participants
    </a>

    <div class="card shadow">
        <div class="card-header text-center bg-dark text-white">
            <h4 class="mb-0">Overall Performance Ranking</h4>
        </div>

        <div class="card-body p-0">

            <table class="table table-bordered table-striped text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Chest No</th>
                        <th>Name</th>
                        <th>Team</th>
                        <th>Total Points</th>
                        <th>Percentage</th>
                    </tr>
                </thead>

                <tbody>
                @php $rank = 1; @endphp

                @foreach($ranking as $r)
                    <tr>
                        {{-- RANK BADGE --}}
                        <td class="fw-bold">
                            @if($rank == 1)
                                🥇 <span class="text-warning">{{ $rank }}</span>
                            @elseif($rank == 2)
                                🥈 <span class="text-secondary">{{ $rank }}</span>
                            @elseif($rank == 3)
                                🥉 <span class="text-brown">{{ $rank }}</span>
                            @else
                                {{ $rank }}
                            @endif
                        </td>

                        <td>{{ $r->chest_no }}</td>
                        <td class="fw-bold">{{ $r->name }}</td>

                        <td>
                            @if($r->team == 'Thuras')
                                <span class="badge bg-primary">{{ $r->team }}</span>
                            @else
                                <span class="badge bg-success">{{ $r->team }}</span>
                            @endif
                        </td>

                        <td><strong>{{ $r->points }}</strong></td>

                        <td class="fw-bold">
                            {{ $r->percentage }}%
                        </td>

                    </tr>

                    @php $rank++; @endphp
                @endforeach

                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection
