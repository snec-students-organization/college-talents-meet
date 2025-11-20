@extends('layouts.admin')

@section('content')
<div class="card w-50 mx-auto mt-5">
    <div class="card-header bg-dark text-white">
        <h4>Enter Password</h4>
    </div>

    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('secure.login') }}">
            @csrf

            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>

            <button class="btn btn-primary mt-3 w-100">Enter</button>
        </form>
    </div>
</div>
@endsection
