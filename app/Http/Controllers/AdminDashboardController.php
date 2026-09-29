<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Signature;
use App\Models\Visitor;
use App\Models\VisitorComment;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalVisitors = Visitor::whereNotNull('checked_in_at')->count();

        $totalComments = VisitorComment::count();

        $totalSignatures = Signature::count();

        $activeEvents = Event::where('is_active', true)
            ->orderBy('event_date', 'desc')
            ->get();

        $latestComments = VisitorComment::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalVisitors' => $totalVisitors,
            'totalComments' => $totalComments,
            'totalSignatures' => $totalSignatures,
            'activeEvents' => $activeEvents,
            'latestComments' => $latestComments,
        ]);
    }
}
