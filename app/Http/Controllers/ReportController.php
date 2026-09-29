<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Signature;
use App\Models\Visitor;
use App\Models\VisitorComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::orderBy('event_date', 'desc')
            ->orderBy('name')
            ->get();

        $eventId = $request->input('event_id');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        /*
        |--------------------------------------------------------------------------
        | VISITORS
        |--------------------------------------------------------------------------
        */

        $visitorQuery = Visitor::with('event')
            ->when(
                $eventId,
                fn ($query) =>
                    $query->where('event_id', $eventId)
            )
            ->when(
                $dateFrom,
                fn ($query) =>
                    $query->whereDate(
                        'checked_in_at',
                        '>=',
                        $dateFrom
                    )
            )
            ->when(
                $dateTo,
                fn ($query) =>
                    $query->whereDate(
                        'checked_in_at',
                        '<=',
                        $dateTo
                    )
            );

        $visitors = (clone $visitorQuery)
            ->latest('checked_in_at')
            ->get();

        $visitorCount =
            (clone $visitorQuery)->count();


        /*
        |--------------------------------------------------------------------------
        | COMMENTS
        |--------------------------------------------------------------------------
        */

        $commentQuery = VisitorComment::with([
            'event',
            'visitor',
        ])
            ->where(
                'status',
                'published'
            )
            ->when(
                $eventId,
                fn ($query) =>
                    $query->where(
                        'event_id',
                        $eventId
                    )
            )
            ->when(
                $dateFrom,
                fn ($query) =>
                    $query->whereDate(
                        'published_at',
                        '>=',
                        $dateFrom
                    )
            )
            ->when(
                $dateTo,
                fn ($query) =>
                    $query->whereDate(
                        'published_at',
                        '<=',
                        $dateTo
                    )
            );

        $comments = (clone $commentQuery)
            ->latest('published_at')
            ->get();

        $commentCount =
            (clone $commentQuery)->count();

        $averageRating =
            (clone $commentQuery)
                ->whereNotNull('rating')
                ->avg('rating');

        $averageRating =
            $averageRating
                ? round($averageRating, 1)
                : 0;


        /*
        |--------------------------------------------------------------------------
        | SIGNATURES
        |--------------------------------------------------------------------------
        */

        $signatureQuery = Signature::with([
            'signingSession.event',
            'signingSession.signer',
        ])
            ->whereHas(
                'signingSession',
                function ($query) use (
                    $eventId,
                    $dateFrom,
                    $dateTo
                ) {

                    if ($eventId) {
                        $query->where(
                            'event_id',
                            $eventId
                        );
                    }

                    if ($dateFrom) {
                        $query->whereDate(
                            'signed_at',
                            '>=',
                            $dateFrom
                        );
                    }

                    if ($dateTo) {
                        $query->whereDate(
                            'signed_at',
                            '<=',
                            $dateTo
                        );
                    }
                }
            );

        $signatures = (clone $signatureQuery)
            ->latest('signed_at')
            ->get();

        $signatureCount =
            (clone $signatureQuery)->count();


        /*
        |--------------------------------------------------------------------------
        | SELECTED EVENT
        |--------------------------------------------------------------------------
        */

        $selectedEvent = null;

        if ($eventId) {
            $selectedEvent =
                Event::find($eventId);
        }


        return view(
            'admin.reports.index',
            compact(
                'events',
                'selectedEvent',
                'visitors',
                'visitorCount',
                'comments',
                'commentCount',
                'averageRating',
                'signatures',
                'signatureCount',
                'dateFrom',
                'dateTo'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT CSV / EXCEL
    |--------------------------------------------------------------------------
    */

    public function exportCsv(Request $request)
    {
        $eventId =
            $request->input('event_id');

        $dateFrom =
            $request->input('date_from');

        $dateTo =
            $request->input('date_to');


        $visitors = Visitor::with('event')
            ->when(
                $eventId,
                fn ($query) =>
                    $query->where(
                        'event_id',
                        $eventId
                    )
            )
            ->when(
                $dateFrom,
                fn ($query) =>
                    $query->whereDate(
                        'checked_in_at',
                        '>=',
                        $dateFrom
                    )
            )
            ->when(
                $dateTo,
                fn ($query) =>
                    $query->whereDate(
                        'checked_in_at',
                        '<=',
                        $dateTo
                    )
            )
            ->latest('checked_in_at')
            ->get();


        $filename =
            'guestbook_report_' .
            now()->format('Ymd_His') .
            '.csv';


        $callback =
            function () use ($visitors) {

                $file =
                    fopen(
                        'php://output',
                        'w'
                    );


                /*
                 * BOM supaya Excel baca UTF-8 dengan betul.
                 */
                fwrite(
                    $file,
                    "\xEF\xBB\xBF"
                );


                fputcsv(
                    $file,
                    [
                        'Nama',
                        'Organisasi',
                        'Telefon',
                        'Email',
                        'Tujuan',
                        'Event',
                        'Tarikh Check-In',
                        'Kaedah Daftar',
                    ]
                );


                foreach ($visitors as $visitor) {

                    fputcsv(
                        $file,
                        [
                            $visitor->name,
                            $visitor->organization,
                            $visitor->phone,
                            $visitor->email,
                            $visitor->purpose,
                            $visitor->event?->name,
                            $visitor->checked_in_at
                                ? $visitor
                                    ->checked_in_at
                                    ->format(
                                        'd/m/Y H:i:s'
                                    )
                                : '',
                            strtoupper(
                                $visitor
                                    ->registration_method
                                    ?? ''
                            ),
                        ]
                    );
                }


                fclose($file);
            };


        return Response::stream(
            $callback,
            200,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $filename .
                    '"',
            ]
        );
    }
}