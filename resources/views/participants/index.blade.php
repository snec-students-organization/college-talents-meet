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
            // Group all participants by chest number
            $grouped = $participants->groupBy('chest_no');

            // Split by team
            $thuras = $grouped->filter(fn($g) => $g->first()->team === 'Thuras');
            $aqeeda = $grouped->filter(fn($g) => $g->first()->team === 'Aqeeda');
        @endphp


        <!-- ============================================= -->
        <!--                     THURAS                    -->
        <!-- ============================================= -->
        <h2 class="text-primary fw-bold mt-4 mb-3">THURAS TEAM</h2>

        @include('participants.part_table', [
            'title' => 'Thuras Team',
            'data'  => $thuras
        ])


        <!-- ============================================= -->
        <!--                     AQEEDA                    -->
        <!-- ============================================= -->
        <h2 class="text-success fw-bold mt-5 mb-3">AQEEDA TEAM</h2>

        @include('participants.part_table', [
            'title' => 'Aqeeda Team',
            'data'  => $aqeeda
        ])

    </div>

</div>

@endsection
