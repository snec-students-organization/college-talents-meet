@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="fw-bold">Event Results</h4>
        <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm">← Back to Events</a>
    </div>

    <div class="card-body">

        {{-- ============================================ --}}
        {{--                   FILTER FORM                 --}}
        {{-- ============================================ --}}
        <form method="GET" class="mb-4">
            <div class="row g-3">

                {{-- EVENT NAME SEARCH --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Search Event</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Event name..."
                           value="{{ request('search') }}">
                </div>

                {{-- SECTION --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">Section</label>
                    <select name="section" class="form-control">
                        <option value="">All</option>
                        <option value="junior"  {{ request('section')=='junior'?'selected':'' }}>Junior</option>
                        <option value="senior"  {{ request('section')=='senior'?'selected':'' }}>Senior</option>
                        <option value="general" {{ request('section')=='general'?'selected':'' }}>General</option>
                    </select>
                </div>

                {{-- CATEGORY --}}
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

                {{-- STAGE TYPE --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">Stage Type</label>
                    <select name="stage_type" class="form-control">
                        <option value="">All</option>
                        <option value="stage"    {{ request('stage_type')=='stage'?'selected':'' }}>Stage</option>
                        <option value="offstage" {{ request('stage_type')=='offstage'?'selected':'' }}>Offstage</option>
                    </select>
                </div>

                {{-- EVENT TYPE --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">Type</label>
                    <select name="type" class="form-control">
                        <option value="">All</option>
                        <option value="individual" {{ request('type')=='individual'?'selected':'' }}>Individual</option>
                        <option value="group"      {{ request('type')=='group'?'selected':'' }}>Group</option>
                    </select>
                </div>

                {{-- FILTER BUTTON --}}
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-dark w-100">Filter</button>
                </div>

            </div>
        </form>



        {{-- ============================================ --}}
        {{--                EVENTS TABLE                 --}}
        {{-- ============================================ --}}
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Stage/Offstage</th>
                    <th>Type</th>
                    <th>View Results</th>
                </tr>
            </thead>

            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->name }}</td>
                    <td>{{ ucfirst($event->section) }}</td>
                    <td>{{ $event->category }}</td>
                    <td>{{ ucfirst($event->stage_type) }}</td>
                    <td>{{ ucfirst($event->type) }}</td>

                    <td>
                        <a href="{{ route('results.event', $event->id) }}"
                           class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
