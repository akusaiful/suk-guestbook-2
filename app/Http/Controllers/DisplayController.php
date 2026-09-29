<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Visitor;
use App\Models\VisitorComment;
use App\Models\Signature;

class DisplayController extends Controller
{
    public function show(Event $event)
    {
        $visitorCount = Visitor::where('event_id', $event->id)
            ->count();

        $commentCount = VisitorComment::where('event_id', $event->id)
            ->where('status', 'published')
            ->count();

        $signatureCount = Signature::whereHas(
            'signingSession',
            function ($query) use ($event) {
                $query->where('event_id', $event->id);
            }
        )->count();

        $averageRating = VisitorComment::where('event_id', $event->id)
            ->where('status', 'published')
            ->whereNotNull('rating')
            ->avg('rating');

        $averageRating = $averageRating
            ? round($averageRating, 1)
            : 0;

        $latestComments = VisitorComment::where('event_id', $event->id)
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        return view('display.show', compact(
            'event',
            'visitorCount',
            'commentCount',
            'signatureCount',
            'averageRating',
            'latestComments'
        ));
    }
}