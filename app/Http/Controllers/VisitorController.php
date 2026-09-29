<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitorController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::orderBy('event_date', 'desc')
            ->get();

        $visitorQuery = Visitor::query()
            ->when(
                $request->filled('event_id'),
                fn ($query) => $query->where(
                    'event_id',
                    $request->event_id
                )
            );

        $totalVisitors = (clone $visitorQuery)
            ->count();

        $todayVisitors = (clone $visitorQuery)
            ->whereDate(
                'checked_in_at',
                today()
            )
            ->count();

        $visitors = Visitor::with('event')
            ->when(
                $request->filled('event_id'),
                fn ($query) => $query->where(
                    'event_id',
                    $request->event_id
                )
            )
            ->latest('checked_in_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.visitors.index',
            compact(
                'visitors',
                'events',
                'totalVisitors',
                'todayVisitors'
            )
        );
    }

    public function create(): View
    {
        $events = Event::where('is_active', true)
            ->orderBy('event_date', 'desc')
            ->get();

        return view('admin.visitors.create', compact('events'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'purpose' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['checked_in_at'] = now();
        $validated['registration_method'] = 'admin';
        $validated['is_active'] = true;

        Visitor::create($validated);

        return redirect()
            ->route('admin.visitors.index')
            ->with('success', 'Pengunjung berjaya didaftarkan.');
    }

    public function destroy(Visitor $visitor): RedirectResponse
    {
        $visitor->delete();

        return redirect()
            ->route('admin.visitors.index')
            ->with('success', 'Rekod pengunjung berjaya dipadam.');
    }
}
