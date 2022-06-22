<?php

namespace App\Http\Controllers;

use App\Models\LocalEvent;
use App\Models\User;
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
        
        if (Auth::user()->level > 1) {
            $localEvents = LocalEvent::where('created_by', Auth::user()->id)->OrderBy('created_at', 'DESC')->get();
        } else {
            $localEvents = LocalEvent::OrderBy('created_at', 'DESC')->get();
        }

        $userLevel = Auth::user()->level;

        return Inertia::render('Events/Index', [
            'events' => $localEvents,
            'userLevel' => $userLevel
        ]);
    }

    // render local event create page
    public function create()
    {
        $assignees = User::where('level', 3)->orderBy('name', 'ASC')->get();
        $userLevel = Auth::user()->level;

        return Inertia::render('Events/Create', [
            'assignees' => $assignees,
            'userLevel' => $userLevel
        ]);
    }

    // save new local event
    public function store(Request $request)
    {
        $this->validate(
            $request, [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after:startDate', // end date should be after start date
            ]
        );

        $start = date('Y-m-d H:i:s', strtotime("$request->startDate $request->startTime"));
        $end = date('Y-m-d H:i:s', strtotime("$request->endDate $request->endTime"));

        // save event on google
        $event = Event::create([
            'name' => $request->title,
            'description' => $request->description,
            'startDateTime' => new Carbon($start, 'Asia/Colombo'),
            'endDateTime' => new Carbon($end, 'Asia/Colombo')
        ]);

        // get google event id
        $googleEventId = $event->id;

        // save event on local db
        $localEvent = LocalEvent::create([
            'google_id' => $googleEventId,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $start,
            'end' => $end,
            'created_by' => Auth::user()->id
        ]);

        $localEventId = $localEvent->id;
        $selectedAssignees = $request->selectedAssignees;

        // check if the event is created by an admin and invitations have sent
        if (!empty($selectedAssignees)) {
            
            foreach ($selectedAssignees as $selectedAssignee) {
                $assigneeInfo = explode('-', $selectedAssignee);
                $assigneeId = $assigneeInfo[2];

                $localEvent = LocalEvent::find($localEventId);
                $localEvent->users()->attach($assigneeId, [
                    'creator' => Auth::user()->id
                ]);
            }
        } else {
            // check if the event is created by an employee
            if (Auth::user()->level == 3) {
                $localEvent = LocalEvent::find($localEventId);
                $localEvent->users()->attach(Auth::user()->id, [
                    'creator' => Auth::user()->id
                ]);
            }
        }

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
        $userLevel = Auth::user()->level;

        foreach ($localEvent->users as $user) {
            $selectedAssignees[] = $user;
        }

        return Inertia::render('Events/Edit', [
            'event' => $localEvent,
            'allAssignees' => $allAssignees,
            'selectedAssignees' => $selectedAssignees,
            'userLevel' => $userLevel
        ]);
    }

    // update event
    public function update(Request $request, $id)
    {
        
        $this->validate(
            $request, [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after:startDate', // end date should be after start date
            ]
        );

        $start = date('Y-m-d H:i:s', strtotime("$request->startDate $request->startTime"));
        $end = date('Y-m-d H:i:s', strtotime("$request->endDate $request->endTime"));

        // update local event
        $localEvent = LocalEvent::find($id);
        $localEvent->title = $request->title;
        $localEvent->description = $request->description;
        $localEvent->start = $start;
        $localEvent->end = $end;
        $localEvent->created_by = Auth::user()->id;
        $localEvent->update();

        // update google event
        // $event = Event::find($localEvent->google_id);
        // $event->title = $data['title'];
        // $event->description = $data['description'];
        // $event->start = new Carbon($startJson, 'Asia/Colombo');
        // $event->end = new Carbon($endJson, 'Asia/Colombo');
        // $event->save();

        $newSelectedAssignees = $request->newSelectedAssignees;

        // delete all assignees from the event
        $localEvent->users()->detach();

        if (!empty($newSelectedAssignees)) {
            // one to many assignees are in the array
            foreach ($newSelectedAssignees as $newSelectedAssignee) {
                $assigneeInfo = explode('-', $newSelectedAssignee);
                $assigneeId = $assigneeInfo[2];

                $localEvent = LocalEvent::find($id);
                $localEvent->users()->attach($assigneeId, [
                    'creator' => Auth::user()->id
                ]);
            }
        } else {
            // check if the event is created by an employee
            if (Auth::user()->level == 3) {
                $localEvent = LocalEvent::find($localEventId);
                $localEvent->users()->attach(Auth::user()->id, [
                    'creator' => Athu::user()->id
                ]);
            }
        }

        return redirect()->route('events')->banner('Event updated successfully.');
    }

    // delete event
    public function destroy($id)
    {

        $localEvent = LocalEvent::find($id);
        
        // delete all assignees from the event
        $localEvent->users()->detach();

        // delete google event
        $event = Event::find($localEvent->google_id);
        $event->delete();
        
        // delete local event
        $localEvent->delete();

        return redirect()->route('events')->banner('Event deleted successfully.');
    }
}
