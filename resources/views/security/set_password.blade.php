@extends('layouts.admin')

@section('content')
<div class="card w-50 mx-auto mt-5">
    <div class="card-header bg-primary text-white">
        <h4>Set Admin Password</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('secure.set') }}">
            @csrf

            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required>

            <button class="btn btn-success mt-3 w-100">Save Password</button>
        </form>
    </div>
</div>
@endsection
