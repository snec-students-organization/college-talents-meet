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
        $request->validate([
    'section' => 'required|in:junior,senior,general',
    'category' => 'required',
    'type' => 'required',
    'stage_type' => 'required',
    'name' => 'required'
]);


        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event added!');
    }
}

