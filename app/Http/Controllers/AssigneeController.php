<?php

namespace App\Http\Controllers;

use App\Models\Assignee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssigneeController extends Controller
{
    
    // contructor
    public function __construct()
    {
        $this->middleware('auth');
    }

    // show all assignees
    public function index()
    {
        $assignees = Assignee::all();

        return Inertia::render('Assignees/Index', [
            'assignees' => $assignees
        ]);
    }

    // render assignee create page
    public function create()
    {
        return Inertia::render('Assignees/Create');
    }

    // save assignee
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'email' => 'required|email:rfc,dns'
        ]);

        Assignee::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('assignees')->banner('Assignee created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function show(Assignee $assignee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignee $assignee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignee $assignee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignee $assignee)
    {
        //
    }
}
