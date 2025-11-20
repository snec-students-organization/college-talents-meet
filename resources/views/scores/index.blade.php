@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Mark Entry - Select Event</h4>
    </div>

    <div class="card-body">

        <!-- FILTER FORM -->
        <form method="GET" class="mb-4">
            <div class="row">

                <div class="col-md-3">
                    <label class="form-label">Stage Type</label>
                    <select name="stage_type" class="form-control">
                        <option value="">All (Stage + Offstage)</option>
                        <option value="stage" {{ request('stage_type') == 'stage' ? 'selected' : '' }}>Stage</option>
                        <option value="offstage" {{ request('stage_type') == 'offstage' ? 'selected' : '' }}>Offstage</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Section</label>
                    <select name="section" class="form-control">
                        <option value="">All Sections</option>
                        <option value="junior" {{ request('section') == 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="senior" {{ request('section') == 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="general" {{ request('section') == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-dark w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- EVENT LIST -->
        <div class="list-group">

            @forelse($events as $event)

                <a href="{{ route('scores.event', $event->id) }}" 
                   class="list-group-item list-group-item-action">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <strong>{{ $event->name }}</strong><br>
                            <small>
                                Section: {{ ucfirst($event->section) }} |
                                Category: {{ $event->category }} |
                                Type: {{ ucfirst($event->type) }} |
                                {{ ucfirst($event->stage_type) }}
                            </small>
                        </div>

                        <div>
                            @if($event->score_completed)
                                <span class="badge bg-success">Score Added</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </div>

                    </div>

                </a>

            @empty
                <div class="alert alert-warning mt-3 text-center">
                    No events found for the selected filters.
                </div>
            @endforelse

        </div>

    </div>
</div>

@endsection
