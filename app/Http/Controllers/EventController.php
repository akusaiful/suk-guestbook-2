<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Signer;
use App\Models\SigningSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | EVENT LIST
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $events = Event::orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view(
            'admin.events.index',
            compact('events')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EVENT DETAIL / SIGNING CONTROL
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        Event $event
    ): View {
        /*
        |--------------------------------------------------------------------------
        | ACTIVE SIGNING SESSION
        |--------------------------------------------------------------------------
        */

        $activeSigningSession = SigningSession::with('signer')
            ->where('event_id', $event->id)
            ->where('status', 'signing')
            ->latest('opened_at')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | SIGNERS YANG PERNAH SIGN UNTUK EVENT INI
        |--------------------------------------------------------------------------
        */

        $signedSignerIds = SigningSession::where(
            'event_id',
            $event->id
        )
            ->where('status', 'signed')
            ->pluck('signer_id')
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | SENARAI SIGNER AKTIF
        |--------------------------------------------------------------------------
        */

        $signersQuery = Signer::where(
            'is_active',
            true
        );


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Cari berdasarkan:
        | - Nama
        | - Jawatan
        | - Organisasi
        |
        */

        if ($request->filled('q')) {

            $search = trim(
                $request->input('q')
            );

            $signersQuery->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'position',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'organization',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }


        $signers = $signersQuery
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        $status = $request->input(
            'status',
            'all'
        );

        if ($status !== 'all') {

            $signers = $signers
                ->filter(
                    function ($signer) use (
                        $status,
                        $signedSignerIds,
                        $activeSigningSession
                    ) {

                        $isSigning =
                            $activeSigningSession &&
                            $activeSigningSession->signer_id === $signer->id;

                        $hasSigned =
                            $signedSignerIds->contains(
                                $signer->id
                            );


                        if ($status === 'signing') {
                            return $isSigning;
                        }


                        if ($status === 'signed') {
                            return !$isSigning &&
                                $hasSigned;
                        }


                        if ($status === 'unsigned') {
                            return !$isSigning &&
                                !$hasSigned;
                        }


                        return true;
                    }
                )
                ->values();
        }


        return view(
            'events.show',
            compact(
                'event',
                'signers',
                'activeSigningSession',
                'signedSignerIds'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE EVENT
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view(
            'admin.events.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE EVENT
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'theme' => [
                'required',
                'string',
                'in:melaka_classic,modern_dark,clean_light',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);


        $validated['is_active'] =
            $request->boolean(
                'is_active'
            );


        Event::create($validated);


        return redirect()
            ->route(
                'admin.events.index'
            )
            ->with(
                'success',
                'Event berjaya ditambah.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT EVENT
    |--------------------------------------------------------------------------
    */

    public function edit(
        Event $event
    ): View {
        return view(
            'admin.events.edit',
            compact('event')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE EVENT
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Event $event
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'theme' => [
                'required',
                'string',
                'in:melaka_classic,modern_dark,clean_light',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);


        $validated['is_active'] =
            $request->boolean(
                'is_active'
            );


        $event->update(
            $validated
        );


        return redirect()
            ->route(
                'admin.events.index'
            )
            ->with(
                'success',
                'Event berjaya dikemaskini.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE EVENT
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Event $event
    ): RedirectResponse {
        $event->delete();


        return redirect()
            ->route(
                'admin.events.index'
            )
            ->with(
                'success',
                'Event berjaya dipadam.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | QR PAGE
    |--------------------------------------------------------------------------
    */

    public function qr(
        Event $event
    ): View {
        $registrationUrl =
            route(
                'guest.register',
                $event
            );


        return view(
            'admin.events.qr',
            compact(
                'event',
                'registrationUrl'
            )
        );
    }
}