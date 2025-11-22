@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Events</h4>
        <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
            + Add Event
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            // Group events by section & stage
            $junior_stage     = $events->where('section', 'junior')->where('stage_type', 'stage');
            $junior_offstage  = $events->where('section', 'junior')->where('stage_type', 'offstage');

            $senior_stage     = $events->where('section', 'senior')->where('stage_type', 'stage');
            $senior_offstage  = $events->where('section', 'senior')->where('stage_type', 'offstage');

            $general_events   = $events->where('section', 'general');
        @endphp


        <!-- ========================= -->
        <!--     TABLE COMPONENT       -->
        <!-- ========================= -->
        @php
            function eventTable($title, $data) {
                if ($data->count() == 0) {
                    echo "<h5 class='mt-4'>$title</h5><p class='text-muted'>No events available.</p>";
                    return;
                }
                
                echo "
                <h5 class='mt-4 fw-bold'>$title</h5>
                <table class='table table-bordered table-striped'>
                    <thead class='table-dark'>
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Section</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Stage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
                
                $i = 1;
                foreach ($data as $event) {
                    echo "
                        <tr>
                            <td>{$i}</td>
                            <td>{$event->name}</td>
                            <td>" . ucfirst($event->section) . "</td>
                            <td>{$event->category}</td>
                            <td>" . ucfirst($event->type) . "</td>
                            <td>" . ucfirst($event->stage_type) . "</td>
                            <td>
                                <a href='" . route('events.edit', $event->id) . "' class='btn btn-warning btn-sm'>Edit</a>

                                <form action='" . route('events.destroy', $event->id) . "' method='POST' class='d-inline'>
                                    " . csrf_field() . method_field('DELETE') . "
                                    <button class='btn btn-danger btn-sm'
                                            onclick='return confirm(\"Delete this event?\")'>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    ";
                    $i++;
                }

                echo "</tbody></table>";
            }
        @endphp



        <!-- ========================= -->
        <!--        JUNIOR EVENTS      -->
        <!-- ========================= -->
        <h3 class="text-primary fw-bold mt-4">JUNIOR SECTION</h3>

        {{ eventTable('Stage Events', $junior_stage) }}
        {{ eventTable('Offstage Events', $junior_offstage) }}



        <!-- ========================= -->
        <!--        SENIOR EVENTS      -->
        <!-- ========================= -->
        <h3 class="text-success fw-bold mt-4">SENIOR SECTION</h3>

        {{ eventTable('Stage Events', $senior_stage) }}
        {{ eventTable('Offstage Events', $senior_offstage) }}



        <!-- ========================= -->
        <!--        GENERAL EVENTS     -->
        <!-- ========================= -->
        <h3 class="text-warning fw-bold mt-4">GENERAL EVENTS</h3>

        {{ eventTable('All General Events', $general_events) }}


    </div>
</div>

@endsection
