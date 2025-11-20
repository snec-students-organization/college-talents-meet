@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Participant Summary</h4>
    </div>

    <div class="card-body">

        <div class="alert alert-info">
            <h5><strong>Performance Summary (10 Mark System)</strong></h5>

            <p>
                Chest No: <strong>{{ $chest_no }}</strong><br>
                Total Scored Marks: <strong>{{ $totalScored }}</strong><br>
                Total Possible Marks: <strong>{{ $totalPossible }}</strong><br>
                Percentage: 
                <strong>{{ number_format($percentage, 2) }}%</strong>
            </p>
        </div>

        <h5 class="mt-4 mb-2">Event Details</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>Stage/Offstage</th>
                    <th>Mark</th>
                </tr>
            </thead>

            <tbody>
                @foreach($records as $rec)
                    @php 
                        $score = \App\Models\Score::where('participant_id', $rec->id)->first();
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rec->event->name }}</td>
                        <td>{{ ucfirst($rec->event->stage_type) }}</td>
                        <td>
                            @if($score)
                                {{ $score->mark }} / 10
                            @else
                                <span class="text-muted">Not Entered</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
