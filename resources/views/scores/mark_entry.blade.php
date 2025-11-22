@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>
            Mark Entry - {{ $event->name }}
            ({{ ucfirst($event->section) }}) – 
            {{ ucfirst($event->stage_type) }} – 
            Category {{ $event->category }}
        </h4>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ========================================================= --}}
        {{-- 🔵 GENERAL SECTION AUTOMATICALLY BECOMES GROUP EVENT       --}}
        {{-- ========================================================= --}}
        @php
            $isGroupEvent = ($event->type === 'group' || $event->section === 'general');
        @endphp

        @if(!$isGroupEvent)

        {{-- ========================================================= --}}
        {{--                INDIVIDUAL EVENTS                          --}}
        {{-- ========================================================= --}}
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Chest No</th>
                    <th>Name</th>
                    <th>Team</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Rank</th>
                    <th>Save</th>
                </tr>
            </thead>

            <tbody>
            @foreach($participants as $p)
                <tr>
                    <form action="{{ route('scores.save') }}" method="POST">
                        @csrf

                        <input type="hidden" name="participant_id" value="{{ $p->id }}">
                        <input type="hidden" name="is_group" value="0">

                        <td>{{ $p->chest_no }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->team }}</td>

                        <td>
                            <input type="number" name="mark" class="form-control"
                                   value="{{ $p->score->mark ?? '' }}" min="0" max="100">
                        </td>

                        <td>
                            <select name="grade" class="form-control">
                                @foreach(['A+','A','B','C','D','NG'] as $g)
                                    <option value="{{ $g }}"
                                        {{ ($p->score->grade ?? '') == $g ? 'selected' : '' }}>
                                        {{ $g }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select name="rank" class="form-control">
                                <option value="">--</option>
                                <option value="1" {{ ($p->score->rank ?? 0)==1?'selected':'' }}>1st</option>
                                <option value="2" {{ ($p->score->rank ?? 0)==2?'selected':'' }}>2nd</option>
                                <option value="3" {{ ($p->score->rank ?? 0)==3?'selected':'' }}>3rd</option>
                                <option value="0" {{ ($p->score->rank ?? 0)==0?'selected':'' }}>No Rank</option>
                            </select>
                        </td>

                        <td>
                            <button class="btn btn-success btn-sm">Save</button>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>

        @else

        {{-- ========================================================= --}}
        {{--                  GROUP & GENERAL EVENTS                   --}}
        {{-- ========================================================= --}}
        @php
            $groups = $participants->groupBy('group_id');
        @endphp

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Group ID</th>
                    <th>Members</th>
                    <th>Teams Involved</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Rank</th>
                    <th>Save</th>
                </tr>
            </thead>

            <tbody>

            @foreach($groups as $gid => $groupMembers)

                @php
                    $first = $groupMembers->first();
                    $score = $first->score;

                    // Detect mixed teams:
                    $teams = $groupMembers->pluck('team')->unique()->join(', ');
                @endphp

                <tr>
                    <form action="{{ route('scores.save') }}" method="POST">
                        @csrf

                        <input type="hidden" name="is_group" value="1">
                        <input type="hidden" name="group_id" value="{{ $gid }}">
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        {{-- Group ID --}}
                        <td class="fw-bold">Group {{ $gid }}</td>

                        {{-- Members --}}
                        <td class="text-start">
                            @foreach($groupMembers as $gm)
                                • {{ $gm->name }} ({{ $gm->chest_no }}) <br>
                            @endforeach
                        </td>

                        {{-- Mixed team support --}}
                        <td class="fw-bold">{{ $teams }}</td>

                        {{-- Mark --}}
                        <td>
                            <input type="number" name="mark" class="form-control"
                                   value="{{ $score->mark ?? '' }}" min="0" max="100">
                        </td>

                        {{-- Grade --}}
                        <td>
                            <select name="grade" class="form-control">
                                @foreach(['A+','A','B','C','D','NG'] as $g)
                                    <option value="{{ $g }}"
                                        {{ ($score->grade ?? '') == $g ? 'selected' : '' }}>
                                        {{ $g }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        {{-- Rank --}}
                        <td>
                            <select name="rank" class="form-control">
                                <option value="">--</option>
                                <option value="1" {{ ($score->rank ?? 0)==1?'selected':'' }}>1st</option>
                                <option value="2" {{ ($score->rank ?? 0)==2?'selected':'' }}>2nd</option>
                                <option value="3" {{ ($score->rank ?? 0)==3?'selected':'' }}>3rd</option>
                                <option value="0" {{ ($score->rank ?? 0)==0?'selected':'' }}>No Rank</option>
                            </select>
                        </td>

                        {{-- Save --}}
                        <td>
                            <button class="btn btn-success btn-sm">Save</button>
                        </td>

                    </form>
                </tr>

            @endforeach

            </tbody>
        </table>

        @endif

    </div>
</div>

@endsection
