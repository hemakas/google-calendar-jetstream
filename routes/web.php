<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// controllers
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// event routes
Route::get('/events', [EventController::class, 'index'])->name('events');

Route::get('/calendar', function () {
    
    //create a new event
    $event = new Event;

    $event->name = 'A new event';
    $event->description = 'Event description';
    $event->startDateTime = Carbon\Carbon::now();
    $event->endDateTime = Carbon\Carbon::now()->addHour();
    $event->addAttendee([
        'email' => 'hemaka404@gmail.com',
        'name' => 'Hemaka Ranasinghe',
        'comment' => 'Lorum ipsum',
    ]);
    $event->addAttendee(['email' => 'hemaka91@gmail.com']);

    $event->save();
});
