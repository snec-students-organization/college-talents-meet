@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Participant Ranking (By Percentage)</h4>

        <a href="{{ route('participants.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Chest No</th>
                    <th>Team</th>
                    <th>Total Mark</th>
                    <th>Percentage</th>
                    <th>Programs</th>
                </tr>
            </thead>

            <tbody>
                @foreach($ranking as $rank => $p)
                <tr>
                    <td><strong>{{ $rank+1 }}</strong></td>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['chest_no'] }}</td>
                    <td>{{ $p['team'] }}</td>
                    <td>{{ $p['scored'] }} / {{ $p['possible'] }}</td>
                    <td><strong>{{ number_format($p['percentage'], 2) }}%</strong></td>

                    <td>
                        <ul class="mb-0">
                            @foreach($p['events'] as $e)
                            <li>
                                {{ $e->event->name }}
                                <span class="badge bg-dark">{{ ucfirst($e->event->stage_type) }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
