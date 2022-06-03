<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Assignee;
use App\Models\EventAssignee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{

    // contructor
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // show all events
    public function index()
    {
        $events = Event::OrderBy('created_at', 'DESC')->get();

        return Inertia::render('Events/Index', [
            'events' => $events
        ]);
    }

    // render event create page
    public function create()
    {
        $assignees = Assignee::orderBy('name', 'ASC')->get();

        return Inertia::render('Events/Create', [
            'assignees' => $assignees
        ]);
    }

    // save new event
    public function store(Request $request)
    {
        $this->validate($request , [
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate'
        ]);

        $start = date('Y-m-d H:i:s', strtotime("$request->startDate $request->startTime"));
        $end = date('Y-m-d H:i:s', strtotime("$request->endDate $request->endTime"));

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $start,
            'end' => $end
        ]);

        $eventId = $event->id;
        $selectedAssignees = $request->selectedAssignees;

        if (!empty($selectedAssignees)) {     

            foreach ($selectedAssignees as $selectedAssignee) {
                $assigneeInfo = explode('-', $selectedAssignee);
                $assigneeId = $assigneeInfo[2];

                EventAssignee::create([
                    'assignee_id' => $assigneeId,
                    'event_id' => $eventId
                ]);
            }
        }

        return redirect()->route('events')->banner('Event created successfully.');
    }
    
    public function show(Event $event)
    {
        //
    }

    // render edit page
    public function edit(Event $id)
    {
        $event = Event::find($id);
        $assignees = Assignee::orderBy('name', 'ASC')->get();
                
        return Inertia::render('Events/Edit', [
            'event' => $event,
            'assignees' => $assignees
        ]);
    }

    public function update(Request $request, Event $event)
    {
        //
    }

    // delete event
    public function destroy(Event $id)
    {
        Event::destroy($id);

        return redirect()->route('events')->banner('Event deleted successfully.');
    }
}
