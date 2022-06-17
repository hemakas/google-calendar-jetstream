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
            'end' => $end
        ]);

        $localEventId = $localEvent->id;
        $selectedAssignees = $request->selectedAssignees;

        // check if the event is created by an admin and invitations have sent
        if (!empty($selectedAssignees)) {     

            foreach ($selectedAssignees as $selectedAssignee) {
                $assigneeInfo = explode('-', $selectedAssignee);
                $assigneeId = $assigneeInfo[2];

                LocalEventAssignee::create([
                    'user_id' => $assigneeId,
                    'local_event_id' => $localEventId,
                ]);
            }
        } else {
            // check if the event is created by an employee
            if (Auth::user()->level == 3) {
                LocalEventAssignee::create([
                    'user_id' => Auth::user()->id,
                    'local_event_id' => $localEventId,
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

        // update local event
        $localEvent = LocalEvent::find($id);
        $localEvent->title = $request->title;
        $localEvent->description = $request->description;
        $localEvent->start = $start;
        $localEvent->end = $end;
        $localEvent->update();

        // $data = $request->json()->all();
        
        // $startDate = $data['startDate'];
        // $startTime = $data['startTime'];
        // $endDate = $data['endDate'];
        // $endTime = $data['endTime'];

        // $startJson = date('Y-m-d H:i:s', strtotime("$startDate $startTime"));
        // $endJson = date('Y-m-d H:i:s', strtotime("$endDate $endTime"));
        
        // update google event
        $event = Event::find($localEvent->google_id);
        // $event->title = $data['title'];
        // $event->description = $data['description'];
        // $event->start = new Carbon($startJson, 'Asia/Colombo');
        // $event->end = new Carbon($endJson, 'Asia/Colombo');
        // $event->save();

        $event->update([
            'title' =>  $request->title,
            'description' => $request->description,
            'start' => new Carbon($start, 'Asia/Colombo'),
            'end' => new Carbon($end, 'Asia/Colombo')
        ]);

        $newSelectedAssignees = $request->newSelectedAssignees;

        // delete all assignees from the event
        $LocalEventAssignees = LocalEventAssignee::where('local_event_id', $id)->delete();

        // add new assignees to the event
        if (!empty($newSelectedAssignees)) {

            foreach ($newSelectedAssignees as $newSelectedAssignee) {
                $assigneeInfo = explode('-', $newSelectedAssignee);
                $assigneeId = $assigneeInfo[2];

                LocalEventAssignee::create([
                    'user_id' => $assigneeId,
                    'local_event_id' => $id
                ]);
            }
        } else {
            // check if the event is created by an employee
            if (Auth::user()->level == 3) {
                LocalEventAssignee::create([
                    'user_id' => Auth::user()->id,
                    'local_event_id' => $id,
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

         // delete google event
         $localEvent = LocalEvent::find($id);
         $event = Event::find($localEvent->google_id);
         $event->delete();
        
        // delete local event
        $localEvent->delete();

        return redirect()->route('events')->banner('Event deleted successfully.');
    }
}
