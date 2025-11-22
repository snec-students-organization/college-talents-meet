@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header text-center bg-dark text-white">
        <h4 class="fw-bold">
            Results – {{ $event->name }}
            ({{ ucfirst($event->section) }} | {{ ucfirst($event->stage_type) }} | Category {{ $event->category }})
        </h4>
    </div>

    <div class="card-body">

        <a href="{{ route('results.index') }}" class="btn btn-secondary mb-3">
            ← Back to Events
        </a>

        @php
            $isGroupEvent = ($event->type === 'group');
            $isGeneral    = ($event->section === 'general');
        @endphp

        {{-- ====================================================== --}}
        {{--       GENERAL EVENTS → SHOW AS INDIVIDUAL ROWS         --}}
        {{-- ====================================================== --}}
        @if($isGeneral)

            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Chest No</th>
                        <th>Participant</th>
                        <th>Team</th>
                        <th>Mark</th>
                        <th>Grade</th>
                        <th>Points</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($participants as $p)
                        @php $score = $p->score; @endphp

                        <tr>
                            <td>
                                @if(optional($score)->rank == 1) 🥇 1st
                                @elseif(optional($score)->rank == 2) 🥈 2nd
                                @elseif(optional($score)->rank == 3) 🥉 3rd
                                @else —
                                @endif
                            </td>

                            <td>{{ $p->chest_no }}</td>
                            <td>{{ $p->name }}</td>

                            <td>
                                <span class="badge {{ $p->team == 'Thuras' ? 'bg-primary' : 'bg-success' }}">
                                    {{ $p->team }}
                                </span>
                            </td>

                            <td>{{ optional($score)->mark ?? '-' }}</td>
                            <td>{{ optional($score)->grade ?? '-' }}</td>
                            <td><strong>{{ optional($score)->points ?? 0 }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @php return; @endphp

        @endif



        {{-- ====================================================== --}}
        {{--                 INDIVIDUAL EVENTS                     --}}
        {{-- ====================================================== --}}
        @if(!$isGroupEvent)

            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Chest No</th>
                        <th>Participant</th>
                        <th>Team</th>
                        <th>Mark</th>
                        <th>Grade</th>
                        <th>Points</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($participants as $p)
                        @php $score = $p->score; @endphp

                        <tr>
                            <td>
                                @if(optional($score)->rank == 1) 🥇 1st
                                @elseif(optional($score)->rank == 2) 🥈 2nd
                                @elseif(optional($score)->rank == 3) 🥉 3rd
                                @else —
                                @endif
                            </td>

                            <td>{{ $p->chest_no }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->team }}</td>
                            <td>{{ optional($score)->mark ?? '-' }}</td>
                            <td>{{ optional($score)->grade ?? '-' }}</td>
                            <td><strong>{{ optional($score)->points ?? 0 }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else



        {{-- ====================================================== --}}
        {{--                    GROUP EVENTS                       --}}
        {{-- ====================================================== --}}
        @php
            $groups = $participants->groupBy('group_id');
        @endphp

        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Group</th>
                    <th>Teams Involved</th>
                    <th>Members</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Points</th>
                </tr>
            </thead>

            <tbody>

            @foreach($groups as $gid => $group)

                @php
                    $first = $group->first();
                    $score = $first->score;
                    $teamList = $group->pluck('team')->unique()->join(', ');
                @endphp

                <tr>
                    <td>
                        @if(optional($score)->rank == 1) 🥇 1st
                        @elseif(optional($score)->rank == 2) 🥈 2nd
                        @elseif(optional($score)->rank == 3) 🥉 3rd
                        @else —
                        @endif
                    </td>

                    <td class="fw-bold">Group {{ $gid }}</td>

                    <td><strong>{{ $teamList }}</strong></td>

                    <td class="text-start">
                        @foreach($group as $m)
                            • {{ $m->name }} ({{ $m->chest_no }}) <br>
                        @endforeach
                    </td>

                    <td>{{ optional($score)->mark ?? '-' }}</td>
                    <td>{{ optional($score)->grade ?? '-' }}</td>
                    <td><strong>{{ optional($score)->points ?? 0 }}</strong></td>
                </tr>

            @endforeach

            </tbody>
        </table>

        @endif

    </div>
</div>

@endsection
