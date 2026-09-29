<?php

namespace App\Http\Controllers;

use App\Events\DisplayUpdated;
use App\Events\SignerRequested;
use App\Events\SignatureClearRequested;
use App\Events\SigningCancelled;
use App\Events\SigningSessionUpdated;
use App\Models\Event;
use App\Models\Signer;
use App\Models\SigningSession;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SigningController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REQUEST SIGN
    |--------------------------------------------------------------------------
    */

    public function requestSign(Event $event, Signer $signer)
    {
        SigningSession::where('event_id', $event->id)
            ->where('status', 'signing')
            ->update([
                'status' => 'cancelled',
            ]);

        $session = SigningSession::create([
            'event_id' => $event->id,
            'signer_id' => $signer->id,
            'status' => 'signing',
            'opened_at' => now(),
        ]);

        SignerRequested::dispatch(
            $event,
            $signer,
            $session
        );

        SigningSessionUpdated::dispatch($event);

        return redirect()
            ->route('admin.events.show', $event)
            ->with(
                'success',
                $signer->name . ' dipilih untuk tandatangan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SIGN DEVICE
    |--------------------------------------------------------------------------
    */

    public function device()
    {
        $session = SigningSession::with([
            'event',
            'signer',
        ])
            ->where('status', 'signing')
            ->latest('opened_at')
            ->first();

        return view(
            'signing.device',
            compact('session')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIGNATURE HISTORY
    |--------------------------------------------------------------------------
    */

    public function history()
    {
        $signatures = Signature::with([
            'signingSession.event',
            'signingSession.signer',
        ])
            ->latest('signed_at')
            ->paginate(10);

        return view(
            'admin.signatures.index',
            compact('signatures')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR SIGNATURE PAD FROM ADMIN
    |--------------------------------------------------------------------------
    */

    public function clearSignaturePad(Event $event)
    {
        SignatureClearRequested::dispatch($event);

        SigningSessionUpdated::dispatch($event);

        return back()->with(
            'success',
            'Arahan padam tandatangan telah dihantar ke Sign Device.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL ACTIVE SIGNING SESSION
    |--------------------------------------------------------------------------
    */

    public function cancelSigning(Event $event)
    {
        $session = SigningSession::where('event_id', $event->id)
            ->where('status', 'signing')
            ->latest('opened_at')
            ->first();

        if (!$session) {
            return back()->with(
                'error',
                'Tiada sesi signing aktif untuk dibatalkan.'
            );
        }

        $session->update([
            'status' => 'cancelled',
        ]);

        SigningCancelled::dispatch(
            $event,
            $session
        );

        SigningSessionUpdated::dispatch($event);

        return back()->with(
            'success',
            'Sesi signing berjaya dibatalkan.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE SAVED SIGNATURE
    |--------------------------------------------------------------------------
    */

    public function destroySignature(Signature $signature)
    {
        $signature->load([
            'signingSession.event',
        ]);

        $session = $signature->signingSession;
        $event = $session?->event;

        if ($signature->signature_path) {
            Storage::disk('public')->delete(
                $signature->signature_path
            );
        }

        $signature->delete();

        if ($session) {
            $session->update([
                'status' => 'cancelled',
                'signed_at' => null,
            ]);
        }

        if ($event) {
            DisplayUpdated::dispatch($event);

            SigningSessionUpdated::dispatch($event);
        }

        return redirect()
            ->route('admin.signatures.index')
            ->with(
                'success',
                'Tandatangan berjaya dipadam.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT SIGNATURE
    |--------------------------------------------------------------------------
    */

    public function submitSignature(
        Request $request,
        SigningSession $session
    ) {
        $request->validate([
            'signature' => [
                'required',
                'string',
            ],
        ]);

        if ($session->status !== 'signing') {
            return back()->with(
                'error',
                'Sesi tandatangan tidak lagi aktif.'
            );
        }

        $signatureData = $request->input('signature');

        if (!str_starts_with(
            $signatureData,
            'data:image/png;base64,'
        )) {
            return back()->with(
                'error',
                'Format tandatangan tidak sah.'
            );
        }

        $signatureData = str_replace(
            'data:image/png;base64,',
            '',
            $signatureData
        );

        $signatureData = str_replace(
            ' ',
            '+',
            $signatureData
        );

        $decodedSignature = base64_decode(
            $signatureData,
            true
        );

        if ($decodedSignature === false) {
            return back()->with(
                'error',
                'Tandatangan gagal diproses.'
            );
        }

        $filename =
            'signatures/' .
            now()->format('Y/m/') .
            'signature_' .
            $session->id .
            '_' .
            now()->format('Ymd_His') .
            '.png';

        Storage::disk('public')->put(
            $filename,
            $decodedSignature
        );

        Signature::create([
            'signing_session_id' => $session->id,
            'signature_path' => $filename,
            'signed_at' => now(),
        ]);

        $session->update([
            'status' => 'signed',
            'signed_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        $session->load('event');

        DisplayUpdated::dispatch(
            $session->event
        );

        SigningSessionUpdated::dispatch(
            $session->event
        );

        return redirect()
            ->route('sign.device')
            ->with(
                'success',
                'Tandatangan berjaya disimpan.'
            );
    }
}