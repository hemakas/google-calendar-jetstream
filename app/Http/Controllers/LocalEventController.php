<?php

namespace App\Http\Controllers;

use App\Models\LocalEvent;
use App\Models\User;
use App\Models\LocalEventAssignee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

// google calendar plugin
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class LocalEventController extends Controller
{

    // contructor
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // show all events
    public function index()
    {
        $localEvents = LocalEvent::OrderBy('created_at', 'DESC')->get();

        return Inertia::render('Events/Index', [
            'events' => $localEvents
        ]);
    }

    // render local event create page
    public function create()
    {
        $assignees = User::where('level', 3)->orderBy('name', 'ASC')->get();

        return Inertia::render('Events/Create', [
            'assignees' => $assignees
        ]);
    }

    // save new local event
    public function store(Request $request)
    {
        $this->validate($request , [
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate'
        ]);

        $start = date('Y-m-d H:i:s', strtotime("$request->startDate $request->startTime"));
        $end = date('Y-m-d H:i:s', strtotime("$request->endDate $request->endTime"));

        $localEvent = LocalEvent::create([
            'title' => $request->title,
            'description' => $request->descriLocalEventAssigneeption,
            'start' => $start,
            'end' => $end
        ]);

        $localEventId = $localEvent->id;
        $selectedAssignees = $request->selectedAssignees;

        if (!empty($selectedAssignees)) {     

            foreach ($selectedAssignees as $selectedAssignee) {
                $assigneeInfo = explode('-', $selectedAssignee);
                $assigneeId = $assigneeInfo[2];

                LocalEventAssignee::create([
                    'assignee_id' => $assigneeId,
                    'local_event_id' => $localEventId,
                    'user_id' => Auth::user()->id,
                ]);
            }
        }

        // save event on google calendar
        $event = Event::create([
            'name' => $request->title,
            'description' => $request->description,
            'startDateTime' => new Carbon($start),
            'endDateTime' => new Carbon($end)
        ]);

        return redirect()->route('events')->banner('Event created successfully.');
    }
    
    public function show(LocalEvent $localEvent)
    {
        //
    }

    // render edit page
    public function edit($id)
    {
        $localEvent = LocalEvent::find($id);  
        $allAssignees = User::where('level', 3)->orderBy('name', 'ASC')->get();
        $selectedAssignees = [];

        foreach ($localEvent->assigneeList as $assignee) {
            $selectedAssignees[] = $assignee;
        }

        return Inertia::render('Events/Edit', [
            'event' => $localEvent,
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

        $localEvent = LocalEvent::find($id);
        
        $localEvent->title = $request->title;
        $localEvent->description = $request->description;
        $localEvent->start = $start;
        $localEvent->end = $end;

        $localEvent->update();

        $newSelectedAssignees = $request->newSelectedAssignees;

        // delete all assignees from the event
        $LocalEventAssignees = LocalEventAssignee::where('local_event_id', $id)->delete();

        // add new assignees to the event
        if (!empty($newSelectedAssignees)) {     

            foreach ($newSelectedAssignees as $newSelectedAssignee) {
                $assigneeInfo = explode('-', $newSelectedAssignee);
                $assigneeId = $assigneeInfo[2];

                LocalEventAssignee::create([
                    'assignee_id' => $assigneeId,
                    'local_event_id' => $id
                ]);
            }
        }

        return redirect()->route('events')->banner('Event updated successfully.');
    }

    // delete event
    public function destroy($id)
    {
        
        // delete all assignees from the event
        $LocalEventAssignee = LocalEventAssignee::where('local_event_id', $id)->delete();
        
        LocalEvent::destroy($id);

        return redirect()->route('events')->banner('Event deleted successfully.');
    }
}
