@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>
            Mark Entry - {{ $event->name }}  
            ({{ ucfirst($event->section) }}) - 
            {{ ucfirst($event->stage_type) }} - 
            Category {{ $event->category }}
        </h4>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Chest No</th>
                    <th>Name</th>
                    <th>Team</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Save</th>
                </tr>
            </thead>

            <tbody>
                @foreach($participants as $participant)
                <tr>
                    <form action="{{ route('scores.save') }}" method="POST">
                        @csrf

                        <input type="hidden" name="participant_id" value="{{ $participant->id }}">

                        <td>{{ $participant->chest_no }}</td>
                        <td>{{ $participant->name }}</td>
                        <td>{{ $participant->team }}</td>

                        <!-- MARK INPUT -->
                        <td style="width:120px;">
                            <input type="number"
                                   name="mark"
                                   value="{{ $participant->score->mark ?? '' }}"
                                   class="form-control"
                                   min="0" max="100">
                        </td>

                        <!-- GRADE SELECT DROPDOWN -->
                        <td style="width:150px;">
                            <select name="grade" class="form-control" required>
                                <option value="A+" {{ ($participant->score->grade ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A"  {{ ($participant->score->grade ?? '') == 'A'  ? 'selected' : '' }}>A</option>
                                <option value="B"  {{ ($participant->score->grade ?? '') == 'B'  ? 'selected' : '' }}>B</option>
                                <option value="C"  {{ ($participant->score->grade ?? '') == 'C'  ? 'selected' : '' }}>C</option>
                                <option value="D"  {{ ($participant->score->grade ?? '') == 'D'  ? 'selected' : '' }}>D</option>
                                <option value="NG" {{ ($participant->score->grade ?? '') == 'NG' ? 'selected' : '' }}>NG</option>
                            </select>
                        </td>

                        <td>
                            <button class="btn btn-success btn-sm">Save</button>
                        </td>
                    </form>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
