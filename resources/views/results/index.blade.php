@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Select Event to View Final Results</h4>
    </div>

    <div class="card-body">

        <!-- FILTER FORM -->
        <form method="GET" class="mb-4">
            <div class="row">

                <!-- Stage / Offstage Filter -->
                <div class="col-md-3">
                    <label class="form-label">Stage Type</label>
                    <select name="stage_type" class="form-control">
                        <option value="">All (Stage + Offstage)</option>
                        <option value="stage" {{ request('stage_type') == 'stage' ? 'selected' : '' }}>Stage</option>
                        <option value="offstage" {{ request('stage_type') == 'offstage' ? 'selected' : '' }}>Offstage</option>
                    </select>
                </div>

                <!-- Section Filter (Junior / Senior / General) -->
                <div class="col-md-3">
                    <label class="form-label">Section</label>
                    <select name="section" class="form-control">
                        <option value="">All Sections</option>
                        <option value="junior" {{ request('section') == 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="senior" {{ request('section') == 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="general" {{ request('section') == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <option value="A" {{ request('category') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ request('category') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ request('category') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ request('category') == 'D' ? 'selected' : '' }}>D</option>
                    </select>
                </div>

                <!-- FILTER BUTTON -->
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-dark w-100">Filter</button>
                </div>

            </div>
        </form>

        <!-- EVENTS LIST -->
        <div class="list-group">
            @forelse($events as $event)
                <a href="{{ route('results.event', $event->id) }}" 
                   class="list-group-item list-group-item-action">

                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $event->name }}</strong>
                            <br>
                            <small>
                                Section: {{ ucfirst($event->section) }} | 
                                Category: {{ $event->category }} | 
                                Type: {{ ucfirst($event->type) }} | 
                                {{ ucfirst($event->stage_type) }}
                            </small>
                        </div>

                        <span class="badge bg-primary align-self-center">View Result</span>
                    </div>

                </a>
            @empty
                <div class="alert alert-warning text-center mt-3">
                    No events found for the selected filter.
                </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
