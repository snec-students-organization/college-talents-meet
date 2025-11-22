<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
{
    $events = Event::query();

    if ($request->stage_type) {
        $events->where('stage_type', $request->stage_type);
    }

    $events = $events->latest()->get();

    return view('events.index', compact('events'));
}


    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
{
    $type = $request->forced_type ?: $request->type;

    Event::create([
        'name'       => $request->name,
        'section'    => $request->section,
        'category'   => $request->category,
        'type'       => $type, // GENERAL ALWAYS = group
        'stage_type' => $request->stage_type
    ]);

    return redirect()->route('events.index')->with('success', 'Event Added');
}
public function edit($id)
{
    $event = Event::findOrFail($id);
    return view('events.edit', compact('event'));
}

public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $event->update([
        'name'       => $request->name,
        'section'    => $request->section,
        'category'   => $request->category,
        'type'       => $request->type,
        'stage_type' => $request->stage_type,
    ]);

    return redirect()->route('events.index')->with('success', 'Event updated successfully');
}

public function destroy($id)
{
    Event::findOrFail($id)->delete();

    return redirect()->route('events.index')->with('success', 'Event deleted successfully');
}



}

