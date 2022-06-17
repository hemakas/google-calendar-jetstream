<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// controllers
use App\Http\Controllers\LocalEventController;
use App\Http\Controllers\AssigneeController;
use App\Http\Controllers\CustomLoginController;

// / page 
// Route::redirect('/', '/login');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/events', function () {
    return Inertia::render('Events/Index');
})->name('events');


// custom login -- not completed
Route::get('/custom_login', [CustomLoginController::class, 'index'])->name('custom_login');
Route::post('/custom_login/validate', [CustomLoginController::class, 'validate'])->name('custom_login.validate');

// event routes
Route::get('/events', [LocalEventController::class, 'index'])->name('events');
Route::get('/events/create', [LocalEventController::class, 'create'])->name('events.create');
Route::post('/events/store', [LocalEventController::class, 'store'])->name('events.store');
Route::get('/events/{event}/edit', [LocalEventController::class, 'edit'])->name('events.edit');
Route::patch('/events/{event}', [LocalEventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [LocalEventController::class, 'destroy'])->name('events.destroy');

// assignees routes
Route::get('/assignees', [AssigneeController::class, 'index'])->name('assignees');
Route::get('/assignees/create', [AssigneeController::class, 'create'])->name('assignees.create');
Route::post('/assignees/store', [AssigneeController::class, 'store'])->name('assignees.store');
Route::get('/assignees/{assignees}/edit', [AssigneeController::class, 'edit'])->name('assignees.edit');
Route::put('/assignees/{assignee}', [AssigneeController::class, 'update'])->name('assignees.update');
Route::delete('/assignees/{assignee}', [AssigneeController::class, 'destroy'])->name('assignees.destroy');

// Route::get('/calendar', function () {
    
//     //create a new event
//     $event = new Event;

//     $event->name = 'A new event';
//     $event->description = 'Event description';
//     $event->startDateTime = Carbon\Carbon::now();
//     $event->endDateTime = Carbon\Carbon::now()->addHour();
//     // $event->addAttendee([
//     //     'email' => 'hemaka404@gmail.com',
//     //     'name' => 'Hemaka Ranasinghe',
//     //     'comment' => 'Lorum ipsum',
//     // ]);
//     // $event->addAttendee(['email' => 'hemaka91@gmail.com']);

//     $event->save();
// });
