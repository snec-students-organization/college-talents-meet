@extends('layouts.admin')

@section('content')
<div class="card w-50 mx-auto mt-5">
    <div class="card-header bg-info text-white">
        <h4>Change Password</h4>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('secure.change') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">Update Password</button>
        </form>

    </div>
</div>
@endsection
