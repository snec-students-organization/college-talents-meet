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
            // Individual event = event.type = "individual" AND section != "general"
            $isGroupLike = ($event->type === 'group' || $event->section === 'general');
        @endphp


        {{-- ========================================================= --}}
        {{--   STANDARD TABLE STRUCTURE FOR ALL EVENTS (Unified)       --}}
        {{-- ========================================================= --}}
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 80px;">Rank</th>
                    <th style="width: 200px;">Group / Participant</th>
                    <th style="width: 120px;">Team</th>
                    <th>Members</th>
                    <th style="width: 100px;">Mark</th>
                    <th style="width: 100px;">Grade</th>
                    <th style="width: 100px;">Points</th>
                </tr>
            </thead>

            <tbody>

            {{-- ========================================================= --}}
            {{--                 GROUP + GENERAL EVENTS                    --}}
            {{-- ========================================================= --}}
            @if($isGroupLike)

                @php
                    // Group by TEAM + GROUP NAME
                    $groups = $participants->groupBy(function($p){
                        return $p->team . '__' . ($p->group_name ?: 'General Group');
                    });
                @endphp

                @foreach($groups as $key => $group)
                    @php
                        [$teamName, $groupName] = explode('__', $key);
                        $score = $group->first()->score;
                    @endphp

                    <tr>

                        {{-- RANK --}}
                        <td>
                            @if(optional($score)->rank == 1) 🥇 1st
                            @elseif(optional($score)->rank == 2) 🥈 2nd
                            @elseif(optional($score)->rank == 3) 🥉 3rd
                            @else —
                            @endif
                        </td>

                        {{-- GROUP NAME --}}
                        <td class="fw-bold">{{ $groupName }}</td>

                        {{-- TEAM --}}
                        <td>
                            <span class="badge {{ $teamName == 'Thuras' ? 'bg-primary' : 'bg-success' }}">
                                {{ $teamName }}
                            </span>
                        </td>

                        {{-- MEMBERS --}}
                        <td class="text-start">
                            @foreach($group as $m)
                                • {{ $m->name }} ({{ $m->chest_no }}) <br>
                            @endforeach
                        </td>

                        {{-- MARK --}}
                        <td>{{ optional($score)->mark ?? '-' }}</td>

                        {{-- GRADE --}}
                        <td>{{ optional($score)->grade ?? '-' }}</td>

                        {{-- POINTS --}}
                        <td><strong>{{ optional($score)->points ?? 0 }}</strong></td>
                    </tr>
                @endforeach


            {{-- ========================================================= --}}
            {{--                    INDIVIDUAL EVENTS                     --}}
            {{-- ========================================================= --}}
            @else

                @foreach($participants as $p)
                    @php $score = $p->score; @endphp

                    <tr>

                        {{-- RANK --}}
                        <td>
                            @if(optional($score)->rank == 1) 🥇 1st
                            @elseif(optional($score)->rank == 2) 🥈 2nd
                            @elseif(optional($score)->rank == 3) 🥉 3rd
                            @else —
                            @endif
                        </td>

                        {{-- ONLY PARTICIPANT NAME (NO GROUP NAME HERE) --}}
                        <td class="fw-bold">{{ $p->name }}</td>

                        {{-- TEAM --}}
                        <td>
                            <span class="badge {{ $p->team == 'Thuras' ? 'bg-primary' : 'bg-success' }}">
                                {{ $p->team }}
                            </span>
                        </td>

                        {{-- MEMBERS → only the individual --}}
                        <td class="text-start">
                            • {{ $p->name }} ({{ $p->chest_no }})
                        </td>

                        {{-- MARK --}}
                        <td>{{ optional($score)->mark ?? '-' }}</td>

                        {{-- GRADE --}}
                        <td>{{ optional($score)->grade ?? '-' }}</td>

                        {{-- POINTS --}}
                        <td><strong>{{ optional($score)->points ?? 0 }}</strong></td>

                    </tr>

                @endforeach

            @endif

            </tbody>
        </table>

    </div>
</div>

@endsection
