@if($data->count() > 0)

    <h4 class="mt-4 mb-2 fw-bold">{{ $title }}</h4>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th style="width:60px">#</th>
                <th style="width:180px">Name</th>
                <th style="width:100px">Chest No</th>
                <th>Programs</th>
                <th style="width:160px">Action</th>
            </tr>
        </thead>

        <tbody>
            @php $i = 1; @endphp

            @foreach($data as $chestNo => $group)
                @php $first = $group->first(); @endphp

                <tr>
                    <td>{{ $i++ }}</td>

                    <td>{{ $first->name }}</td>

                    <td>{{ $first->chest_no }}</td>

                    <td>
                        <ul class="mb-0">
                            @foreach($group as $p)
                                <li>
                                    {{ $p->event->name }}
                                    <span class="badge bg-secondary ms-2">
                                        {{ ucfirst($p->event->stage_type) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    <td class="text-center">

                        <!-- SUMMARY BUTTON -->
                        <a href="{{ route('participant.summary', $first->chest_no) }}"
                           class="btn btn-info btn-sm mb-1">
                            Summary
                        </a>

                        <!-- DELETE BUTTON -->
                        <form action="{{ route('participants.destroy', $first->id) }}"
                              method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Delete this participant from ALL events?')"
                                    class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@else

    <p class="text-muted"><em>No participants found in {{ $title }}.</em></p>

@endif
