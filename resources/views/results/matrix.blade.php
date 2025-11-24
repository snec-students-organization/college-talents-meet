@extends('layouts.admin')

@section('content')

<div class="container">

    {{-- ========================= --}}
    {{--     PAGE HEADING          --}}
    {{-- ========================= --}}
    <h2 class="fw-bold mb-4 text-center">Matrix Results (All Sections)</h2>

    <a href="{{ route('results.index') }}" class="btn btn-secondary mb-3">
        ← Back to Events
    </a>


    {{-- ========================= --}}
    {{--   TEAM TOTALS (FIXED)     --}}
    {{-- ========================= --}}
    @php
        use App\Models\Score;
        use App\Models\Penalty;

        // INDIVIDUAL POINTS
        $thurasIndividual = Score::where('team', 'Thuras')
            ->whereNull('group_name')
            ->sum('points');

        $aqeedaIndividual = Score::where('team', 'Aqeeda')
            ->whereNull('group_name')
            ->sum('points');

        // GROUP / GENERAL POINTS (COUNT ONCE PER GROUP)
        $thurasGroup = Score::where('team', 'Thuras')
            ->whereNotNull('group_name')
            ->select('group_name')
            ->distinct()
            ->sum('points');

        $aqeedaGroup = Score::where('team', 'Aqeeda')
            ->whereNotNull('group_name')
            ->select('group_name')
            ->distinct()
            ->sum('points');

        // PENALTIES
        $penThuras = Penalty::where('team', 'Thuras')->sum('points');
        $penAqeeda = Penalty::where('team', 'Aqeeda')->sum('points');

        // FINAL TOTAL
        $thurasScore = $thurasIndividual + $thurasGroup + $penThuras;
        $aqeedaScore = $aqeedaIndividual + $aqeedaGroup + $penAqeeda;
    @endphp

    <div class="row mb-4">

        <div class="col-md-6 mb-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <h4>Thuras</h4>
                    <h1 class="fw-bold">{{ $thurasScore }}</h1>
                    <p>Total Points (After Penalties)</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <h4>Aqeeda</h4>
                    <h1 class="fw-bold">{{ $aqeedaScore }}</h1>
                    <p>Total Points (After Penalties)</p>
                </div>
            </div>
        </div>

    </div>



    {{-- ========================= --}}
    {{--     FILTER FORM           --}}
    {{-- ========================= --}}
    <form method="GET" class="mb-4">
        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label fw-bold">Section</label>
                <select name="section" class="form-control">
                    <option value="">All Sections</option>
                    <option value="junior"  {{ request('section')=='junior'?'selected':'' }}>Junior</option>
                    <option value="senior"  {{ request('section')=='senior'?'selected':'' }}>Senior</option>
                    <option value="general" {{ request('section')=='general'?'selected':'' }}>General</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Stage Type</label>
                <select name="stage_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="stage" {{ request('stage_type')=='stage'?'selected':'' }}>Stage</option>
                    <option value="offstage" {{ request('stage_type')=='offstage'?'selected':'' }}>Offstage</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Category</label>
                <select name="category" class="form-control">
                    <option value="">All</option>
                    <option value="A" {{ request('category')=='A'?'selected':'' }}>A</option>
                    <option value="B" {{ request('category')=='B'?'selected':'' }}>B</option>
                    <option value="C" {{ request('category')=='C'?'selected':'' }}>C</option>
                    <option value="D" {{ request('category')=='D'?'selected':'' }}>D</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Search Event</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Event name..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-dark w-100">Filter</button>
            </div>

        </div>
    </form>



    {{-- ========================= --}}
    {{--     FILTERED EVENTS       --}}
    {{-- ========================= --}}
    @php
        $events = $events->filter(function($e){

            if(request('section') && $e->section != request('section')) return false;
            if(request('stage_type') && $e->stage_type != request('stage_type')) return false;
            if(request('category') && $e->category != request('category')) return false;
            if(request('search') && stripos($e->name, request('search')) === false) return false;

            return true;
        });
    @endphp



    {{-- ========================= --}}
    {{--       EVENT LIST          --}}
    {{-- ========================= --}}
    @foreach($events as $event)

        @php
            $isGroupLike = ($event->type === 'group' || $event->section === 'general');
        @endphp

        <div class="card shadow mb-4">

            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ $event->name }} —
                    {{ ucfirst($event->section) }} |
                    {{ ucfirst($event->stage_type) }} |
                    Category {{ $event->category }}
                </h5>
            </div>


            {{-- ========================================= --}}
            {{--             PENALTY FORM                  --}}
            {{-- ========================================= --}}
            <div class="p-3 border-bottom">

                <form action="{{ route('results.penalty.add') }}" method="POST" class="row g-2">
                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div class="col-md-3">
                        <select name="team" class="form-control" required>
                            <option value="">Select Team</option>
                            <option value="Thuras">Thuras</option>
                            <option value="Aqeeda">Aqeeda</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="points" class="form-control"
                               placeholder="Penalty (-5)" required>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-danger w-100">Apply Penalty</button>
                    </div>
                </form>

            </div>


            {{-- ========================================= --}}
            {{--             SHOW PENALTIES                --}}
            {{-- ========================================= --}}
            @if($event->penalties->count())
                <div class="alert alert-danger m-3">
                    <strong>Penalties Applied:</strong><br>
                    @foreach($event->penalties as $p)
                        • {{ $p->team }} = {{ $p->points }} points
                        <small class="text-muted">({{ $p->created_at->format('d M, H:i') }})</small>
                        <br>
                    @endforeach
                </div>
            @endif



            {{-- ========================================= --}}
            {{--          RESULT TABLE                     --}}
            {{-- ========================================= --}}
            <div class="card-body p-0">

                <table class="table table-bordered table-striped text-center mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Team</th>
                            <th>Group / Participant</th>
                            <th>Members</th>
                            <th>Mark</th>
                            <th>Grade</th>
                            <th>Rank</th>
                            <th>Points</th>
                        </tr>
                    </thead>

                    <tbody>

                    {{-- ========== GROUP / GENERAL ========== --}}
                    @if($isGroupLike)

                        @php
                            $groups = $event->participants->groupBy(function($p){
                                return $p->team . '__' . ($p->group_name ?: 'General Group');
                            });
                        @endphp

                        @foreach($groups as $key => $group)

                            @php
                                [$teamName, $groupName] = explode('__', $key);
                                $score = $group->first()->score;
                            @endphp

                            <tr>
                                <td>
                                    <span class="badge {{ $teamName=='Thuras'?'bg-primary':'bg-success' }}">
                                        {{ $teamName }}
                                    </span>
                                </td>

                                <td class="fw-bold">{{ $groupName }}</td>

                                <td class="text-start">
                                    @foreach($group as $m)
                                        • {{ $m->name }} ({{ $m->chest_no }}) <br>
                                    @endforeach
                                </td>

                                <td>{{ $score->mark ?? '-' }}</td>
                                <td>{{ $score->grade ?? '-' }}</td>

                                <td>
                                    @if($score?->rank == 1) 🥇 1st
                                    @elseif($score?->rank == 2) 🥈 2nd
                                    @elseif($score?->rank == 3) 🥉 3rd
                                    @else — @endif
                                </td>

                                <td class="fw-bold">{{ $score->points ?? 0 }}</td>
                            </tr>

                        @endforeach

                    {{-- ========== INDIVIDUAL ========== --}}
                    @else

                        @foreach($event->participants as $p)
                            @php $score = $p->score; @endphp

                            <tr>
                                <td>
                                    <span class="badge {{ $p->team=='Thuras'?'bg-primary':'bg-success' }}">
                                        {{ $p->team }}
                                    </span>
                                </td>

                                <td class="fw-bold">{{ $p->name }}</td>

                                <td class="text-start">
                                    • {{ $p->name }} ({{ $p->chest_no }})
                                </td>

                                <td>{{ $score->mark ?? '-' }}</td>
                                <td>{{ $score->grade ?? '-' }}</td>

                                <td>
                                    @if($score?->rank == 1) 🥇 1st
                                    @elseif($score?->rank == 2) 🥈 2nd
                                    @elseif($score?->rank == 3) 🥉 3rd
                                    @else — @endif
                                </td>

                                <td class="fw-bold">{{ $score->points ?? 0 }}</td>
                            </tr>

                        @endforeach

                    @endif

                    </tbody>

                </table>

            </div>

        </div>

    @endforeach

</div>

@endsection
