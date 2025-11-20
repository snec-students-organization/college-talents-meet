@extends('layouts.admin')

@section('content')

<div class="card w-50 mx-auto mt-5">
    <div class="card-header bg-primary text-white">
        <h4>Chest Number Summary</h4>
    </div>

    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('chest.summary.result') }}">
            @csrf

            <label class="form-label">Enter Chest Number</label>
            <input type="text" name="chest_no" class="form-control" required>

            <button class="btn btn-success mt-3 w-100">View Summary</button>
        </form>
    </div>
</div>

@endsection
