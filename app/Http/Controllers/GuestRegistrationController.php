<?php

namespace App\Http\Controllers;

use App\Events\DisplayUpdated;
use App\Models\Event;
use App\Models\Visitor;
use App\Models\VisitorComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestRegistrationController extends Controller
{
    public function show(Event $event): View
    {
        abort_unless($event->is_active, 404);

        return view('guest.register', compact('event'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->is_active, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'purpose' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        $visitor = Visitor::create([
            'event_id' => $event->id,
            'name' => $validated['name'],
            'organization' => $validated['organization'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'purpose' => $validated['purpose'] ?? null,
            'checked_in_at' => now(),
            'registration_method' => 'qr',
            'is_active' => true,
        ]);

        VisitorComment::create([
            'event_id' => $event->id,
            'visitor_id' => $visitor->id,
            'name' => $visitor->name,
            'organization' => $visitor->organization,
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
            'status' => 'published',
            'published_at' => now(),
        ]);

        DisplayUpdated::dispatch($event);

        return redirect()
            ->route('guest.register', $event)
            ->with(
                'success',
                'Terima kasih. Pendaftaran, rating dan komen anda berjaya dihantar.'
            );
    }
}