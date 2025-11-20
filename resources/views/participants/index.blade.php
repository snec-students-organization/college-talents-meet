@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Participants</h4>

        <div>
            <a href="{{ route('participants.ranking') }}" class="btn btn-warning btn-sm me-2">
                🔥 View Ranking
            </a>

            <a href="{{ route('participants.create') }}" class="btn btn-primary btn-sm">
                + Add Participant
            </a>
        </div>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            // Group by chest number (unique participant)
            $grouped = $participants->groupBy('chest_no');

            // Separate teams
            $thuras = $grouped->filter(fn($g) => $g->first()->team === 'Thuras');
            $aqeeda = $grouped->filter(fn($g) => $g->first()->team === 'Aqeeda');
        @endphp


        <!-- ========================= -->
        <!--        THURAS TABLE       -->
        <!-- ========================= -->
        <h3 class="mt-3 mb-3 text-primary fw-bold">THURAS TEAM</h3>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Chest No</th>
                    <th>Programs (with Stage/Offstage)</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @php $i = 1; @endphp

                @forelse($thuras as $chest => $group)
                    @php $first = $group->first(); @endphp

                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $first->name }}</td>
                        <td>{{ $first->chest_no }}</td>

                        <td>
                            <ul class="mb-0">
                                @foreach($group as $p)
                                <li>
                                    {{ $p->event->name }}
                                    <span class="badge bg-dark ms-2">
                                        {{ ucfirst($p->event->stage_type) }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </td>

                        <td>
                            <a href="{{ route('participant.summary', $first->chest_no) }}" 
                               class="btn btn-info btn-sm">
                                Summary
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr><td colspan="5" class="text-center">No Thuras participants yet.</td></tr>
                @endforelse
            </tbody>
        </table>




        <!-- ========================= -->
        <!--        AQEEDA TABLE       -->
        <!-- ========================= -->
        <h3 class="mt-5 mb-3 text-success fw-bold">AQEEDA TEAM</h3>

        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Chest No</th>
                    <th>Programs (with Stage/Offstage)</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @php $j = 1; @endphp

                @forelse($aqeeda as $chest => $group)
                    @php $first = $group->first(); @endphp

                    <tr>
                        <td>{{ $j++ }}</td>
                        <td>{{ $first->name }}</td>
                        <td>{{ $first->chest_no }}</td>

                        <td>
                            <ul class="mb-0">
                                @foreach($group as $p)
                                <li>
                                    {{ $p->event->name }}
                                    <span class="badge bg-dark ms-2">
                                        {{ ucfirst($p->event->stage_type) }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </td>

                        <td>
                            <a href="{{ route('participant.summary', $first->chest_no) }}" 
                               class="btn btn-info btn-sm">
                                Summary
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr><td colspan="5" class="text-center">No Aqeeda participants yet.</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
