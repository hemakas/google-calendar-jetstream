<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Assignee;
use App\Models\User;

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
        $assignees = User::where('level', 3)->orderBy('name', 'ASC')->get();

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

        User::create([
            'name' => ucwords($request->name),
            'email' => $request->email,
            'password' => Hash::make('123@company'),
            'level' => $request->level,
        ]);

        return redirect()->route('assignees')->banner('Assignee created successfully.');

    }

    public function show(Assignee $assignee)
    {
        //
    }

    // render edit page
    public function edit($id)
    {
        $assignee = User::find($id);
        
        return Inertia::render('Assignees/Edit', [
            'assignee' => $assignee
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'email' => 'required|email:rfc,dns'
        ]);

        $assignee = User::find($id);

        $assignee->name = $request->name;
        $assignee->email = $request->email;

        $assignee->update();

        return redirect()->route('assignees')->banner('Assignee updated successfully.');

    }

    // delete assignee
    public function destroy($id)
    {
        // try {
        //     User::destroy($id);
        //     return redirect()->route('assignees')->banner('Assignee deleted successfully.', 'danger');
        // } catch (\Exception $exception) {     
        //     session()->flash('flash.banner', 'Assignee Cannot be deleted as he/she already signed with an event!');
        //     session()->flash('flash.bannerStyle', 'danger');
        // }

        $user = User::find($id);

        $user->localEvents()->detach();

        User::destroy($id);

        return redirect()->route('assignees')->banner('Assignee deleted successfully.');

    }
}
