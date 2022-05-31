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
        $events = Event::all();

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

        if (!empty($request->selectedAssignees)) {
            
            $selectedAssignees = $request->selectedAssignees;

            foreach ($selectedAssignees as $selectedAssignee) {

                $selectedAss = explode('-', $request->selectedAssignee);
                
                echo $selectedAss;
                
                // $assigneeId = $selectedAssignee[1];

                // dd($assigneeId);

                EventAssignee::create([
                    'assignee_id' => $assigneeId,
                    'event_id' => $eventId
                ]);
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
