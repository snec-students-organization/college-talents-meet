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

        @php
            // Treat GENERAL events as GROUP events always
            $isGroupEvent = ($event->type === 'group' || $event->section === 'general');
        @endphp


        {{-- ========================================================= --}}
        {{--                     INDIVIDUAL EVENTS                     --}}
        {{-- ========================================================= --}}
        @if(!$isGroupEvent)

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
                                <option value="1" {{ ($p->score->rank ?? '')==1?'selected':'' }}>1st</option>
                                <option value="2" {{ ($p->score->rank ?? '')==2?'selected':'' }}>2nd</option>
                                <option value="3" {{ ($p->score->rank ?? '')==3?'selected':'' }}>3rd</option>
                                <option value="0" {{ ($p->score->rank ?? '')==0?'selected':'' }}>No Rank</option>
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
        {{--                    GROUP / GENERAL EVENTS                 --}}
        {{-- ========================================================= --}}

        @php
            /*
                Group key = TEAM + GROUP_NAME

                Example:
                    Thuras__A1
                    Thuras__A2
                    Aqeeda__B1
            */

            $groups = $participants->groupBy(function($p){
                // If missing, keep it empty (not Unnamed!)
                $gname = trim($p->group_name);
                return $p->team . '__' . $gname;
            });
        @endphp

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Team</th>
                    <th>Group Name</th>
                    <th>Members</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Rank</th>
                    <th>Save</th>
                </tr>
            </thead>

            <tbody>

            @foreach($groups as $key => $members)

                @php
                    [$teamName, $groupName] = explode('__', $key);
                    $groupName = $groupName ?: '(No Group Name)';
                    $score = $members->first()->score;
                @endphp

                <tr>
                <form action="{{ route('scores.save') }}" method="POST">
                    @csrf

                    <input type="hidden" name="is_group" value="1">
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="team" value="{{ $teamName }}">
                    <input type="hidden" name="group_name" value="{{ $groupName }}">

                    {{-- TEAM --}}
                    <td>
                        @if($teamName == 'Thuras')
                            <span class="badge bg-primary">{{ $teamName }}</span>
                        @else
                            <span class="badge bg-success">{{ $teamName }}</span>
                        @endif
                    </td>

                    {{-- GROUP NAME --}}
                    <td class="fw-bold">{{ $groupName }}</td>

                    {{-- MEMBERS --}}
                    <td class="text-start">
                        @foreach($members as $m)
                            • {{ $m->name }} ({{ $m->chest_no }}) <br>
                        @endforeach
                    </td>

                    {{-- MARK --}}
                    <td>
                        <input type="number" name="mark" class="form-control"
                            value="{{ $score->mark ?? '' }}" min="0" max="100">
                    </td>

                    {{-- GRADE --}}
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

                    {{-- RANK --}}
                    <td>
                        <select name="rank" class="form-control">
                            <option value="">--</option>
                            <option value="1" {{ ($score->rank ?? '')==1?'selected':'' }}>1st</option>
                            <option value="2" {{ ($score->rank ?? '')==2?'selected':'' }}>2nd</option>
                            <option value="3" {{ ($score->rank ?? '')==3?'selected':'' }}>3rd</option>
                            <option value="0" {{ ($score->rank ?? '')==0?'selected':'' }}>No Rank</option>
                        </select>
                    </td>

                    {{-- SAVE --}}
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
