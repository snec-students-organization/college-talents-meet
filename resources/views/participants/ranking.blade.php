@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="text-center mb-4">
        <h2 class="fw-bold">Participant Ranking</h2>
        <p class="text-muted">Only Individual Event Marks & Points are counted. Negative marks reduce only total marks.</p>
    </div>

    <a href="{{ route('participants.index') }}" class="btn btn-secondary mb-3">
        ← Back to Participants
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                        <th>Total Marks</th>
                        <th>Negative Mark</th>
                        <th>Final Marks</th>
                        <th>Individual Events</th>
                        <th>Total Points</th>
                        <th>Percentage</th>
                        <th>Reduce Mark</th> {{-- NEW --}}
                    </tr>
                </thead>

                <tbody>

                @php $rank = 1; @endphp

                @foreach($ranking as $r)
                    <tr>

                        {{-- Rank Badge --}}
                        <td class="fw-bold">
                            @if($rank == 1)
                                🥇 <span class="text-warning">{{ $rank }}</span>
                            @elseif($rank == 2)
                                🥈 <span class="text-secondary">{{ $rank }}</span>
                            @elseif($rank == 3)
                                🥉 <span>{{ $rank }}</span>
                            @else
                                {{ $rank }}
                            @endif
                        </td>

                        <td>{{ $r->chest_no }}</td>
                        <td class="fw-bold">{{ $r->name }}</td>

                        <td>
                            @if($r->team == 'Thuras')
                                <span class="badge bg-primary">Thuras</span>
                            @else
                                <span class="badge bg-success">Aqeeda</span>
                            @endif
                        </td>

                        {{-- Total Marks --}}
                        <td class="fw-bold">{{ $r->total_marks }}</td>

                        {{-- Negative --}}
                        <td class="fw-bold text-danger">-{{ $r->negative_mark }}</td>

                        {{-- Final Marks --}}
                        <td class="fw-bold">{{ $r->final_marks }}</td>

                        <td>{{ $r->event_count }}</td>
                        <td><strong>{{ $r->points }}</strong></td>
                        <td class="fw-bold">{{ $r->percentage }}%</td>

                        {{-- ⭐ Reduce Mark Form --}}
                        <td>
                            <form action="{{ route('participants.negative.mark') }}" method="POST" class="d-flex">
                                @csrf

                                <input type="hidden" name="chest_no" value="{{ $r->chest_no }}">

                                <input type="number"
                                       name="negative_mark"
                                       class="form-control form-control-sm me-2"
                                       style="width: 70px;"
                                       placeholder="-5"
                                       required>

                                <button class="btn btn-danger btn-sm">Save</button>
                            </form>
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
