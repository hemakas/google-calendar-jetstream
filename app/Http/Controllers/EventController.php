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
    public function edit($id)
    {
        $event = Event::find($id);  
        $allAssignees = Assignee::orderBy('name', 'ASC')->get();
        $selectedAssignees = [];

        foreach ($event->assigneeList as $assignee) {
            $selectedAssignees[] = $assignee;
        }
        
        return Inertia::render('Events/Edit', [
            'event' => $event,
            'allAssignees' => $allAssignees,
            'selectedAssignees' => $selectedAssignees
        ]);
    }

    // update event
    public function update(Request $request, $id)
    {
        $this->validate($request , [
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate'
        ]);

        $start = date('Y-m-d H:i:s', strtotime("$request->startDate $request->startTime"));
        $end = date('Y-m-d H:i:s', strtotime("$request->endDate $request->endTime"));

        $event = Event::find($id);
        
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start = $start;
        $event->end = $end;

        $event->update();

        $newSelectedAssignees = $request->newSelectedAssignees;

        // delete all assignees from the event
        $eventAssignees = EventAssignee::where('event_id', $id)->delete();

        // add new assignees to the event
        if (!empty($newSelectedAssignees)) {     

            foreach ($newSelectedAssignees as $newSelectedAssignee) {
                $assigneeInfo = explode('-', $newSelectedAssignee);
                $assigneeId = $assigneeInfo[2];

                EventAssignee::create([
                    'assignee_id' => $assigneeId,
                    'event_id' => $id
                ]);
            }
        }

        return redirect()->route('events')->banner('Event updated successfully.');
    }

    // delete event
    public function destroy(Event $id)
    {
        Event::destroy($id);

        return redirect()->route('events')->banner('Event deleted successfully.');
    }
}
