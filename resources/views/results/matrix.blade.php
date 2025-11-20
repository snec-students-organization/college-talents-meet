@extends('layouts.admin')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">Event vs Team Matrix Results</h2>

    @foreach($groups as $title => $events)

        <div class="card mb-5">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>

            <div class="card-body">

                @if($events->count() == 0)
                    <p class="text-muted">No events found.</p>
                    @continue
                @endif

                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Category</th>
                            <th>Thuras Points</th>
                            <th>Aqeeda Points</th>
                            <th>Winner</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->category }}</td>

                            <td><strong>{{ $event->thuras_points }}</strong></td>
                            <td><strong>{{ $event->aqeeda_points }}</strong></td>

                            <td>
                                @if($event->winner == 'Thuras')
                                    <span class="badge bg-primary">Thuras</span>
                                @elseif($event->winner == 'Aqeeda')
                                    <span class="badge bg-success">Aqeeda</span>
                                @else
                                    <span class="badge bg-warning text-dark">Tie</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    @endforeach

</div>

@endsection
