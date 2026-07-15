<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::where('user_id', Auth::id());

        if ($request->filled('status') && $request->string('status') !== 'all') {
            $query->where('status', $request->string('status'));
        }

        $events = $query->orderBy('event_date')->get();

        return view('events.index', [
            'events' => $events,
            'activeStatus' => $request->get('status', 'all'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_name' => ['required', 'string', 'max:150'],
            'event_type' => ['required', 'in:wedding,corporate,social,other'],
            'event_date' => ['required', 'date'],
            'guest_count' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,sourcing,ordered,delivered,closed'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['notes'] = $validated['notes'] ?: 'No additional notes provided.';

        Event::create($validated);

        return back()->with('success', 'Event created successfully.');
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorizeOwner($event);

        $validated = $request->validate([
            'event_name' => ['required', 'string', 'max:150'],
            'event_type' => ['required', 'in:wedding,corporate,social,other'],
            'event_date' => ['required', 'date'],
            'guest_count' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,sourcing,ordered,delivered,closed'],
            'notes' => ['nullable', 'string'],
        ]);

        $event->update($validated);

        return back()->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorizeOwner($event);

        $event->delete();

        return back()->with('success', 'Event deleted.');
    }

    public function startSourcing(Event $event): RedirectResponse
    {
        $this->authorizeOwner($event);

        $event->update(['status' => 'sourcing']);

        return back()->with('success', 'Sourcing started for '.$event->event_name);
    }

    private function authorizeOwner(Event $event): void
    {
        abort_unless($event->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
    }
}
