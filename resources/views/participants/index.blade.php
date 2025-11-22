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
            // Group by chest number
            $grouped = $participants->groupBy('chest_no');

            // Split teams
            $thuras = $grouped->filter(fn($g) => $g->first()->team === 'Thuras');
            $aqeeda = $grouped->filter(fn($g) => $g->first()->team === 'Aqeeda');

            // Helper: filter by section only (NO stage/offstage filter)
            function filterBySection($collection, $section) {
                return $collection->filter(function($group) use ($section) {
                    return $group->first()->event->section === $section;
                });
            }
        @endphp


        <!-- ========================================================= -->
        <!--                         THURAS TEAM                        -->
        <!-- ========================================================= -->
        <h2 class="text-primary fw-bold mt-4 mb-3">THURAS TEAM</h2>

        @php
            $t_junior  = filterBySection($thuras, 'junior');
            $t_senior  = filterBySection($thuras, 'senior');
            $t_general = filterBySection($thuras, 'general');
        @endphp

        @include('participants.part_table', ['title' => 'Junior',  'data' => $t_junior])
        @include('participants.part_table', ['title' => 'Senior',  'data' => $t_senior])
        @include('participants.part_table', ['title' => 'General', 'data' => $t_general])




        <!-- ========================================================= -->
        <!--                         AQEEDA TEAM                       -->
        <!-- ========================================================= -->
        <h2 class="text-success fw-bold mt-5 mb-3">AQEEDA TEAM</h2>

        @php
            $a_junior  = filterBySection($aqeeda, 'junior');
            $a_senior  = filterBySection($aqeeda, 'senior');
            $a_general = filterBySection($aqeeda, 'general');
        @endphp

        @include('participants.part_table', ['title' => 'Junior',  'data' => $a_junior])
        @include('participants.part_table', ['title' => 'Senior',  'data' => $a_senior])
        @include('participants.part_table', ['title' => 'General', 'data' => $a_general])

    </div>
</div>

@endsection
