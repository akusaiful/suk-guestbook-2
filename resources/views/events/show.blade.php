@extends('layouts.admin')

@section('title', 'Event Detail')

@section('page-title', 'Event Detail')

@section(
    'page-subtitle',
    'Urus penandatangan dan kawalan signing untuk event ini.'
)

@section('content')


{{-- =========================================================
     EVENT HEADER
========================================================= --}}
<div class="mb-5">

    <a
        href="{{ route('admin.events.index') }}"
        class="text-sm text-gray-500 hover:underline"
    >
        ← Kembali ke senarai event
    </a>


    <h2 class="mt-3 text-2xl font-bold">
        {{ $event->name }}
    </h2>


    <p class="text-sm text-gray-500 mt-1">

        {{ $event->event_date->format('d/m/Y') }}

        @if ($event->location)
            • {{ $event->location }}
        @endif

    </p>

</div>


{{-- =========================================================
     FILTER
========================================================= --}}
<div class="bg-white border rounded-2xl shadow-sm p-4 mb-5">

    <form
        method="GET"
        action="{{ route('admin.events.show', $event) }}"
    >

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">

            {{-- SEARCH --}}
            <div class="lg:col-span-6">

                <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                    Cari Penandatangan
                </label>

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Nama, jawatan atau organisasi..."
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

            </div>


            {{-- STATUS --}}
            <div class="lg:col-span-3">

                <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 bg-white text-sm"
                >

                    <option
                        value="all"
                        {{ request('status', 'all') === 'all' ? 'selected' : '' }}
                    >
                        Semua Status
                    </option>

                    <option
                        value="unsigned"
                        {{ request('status') === 'unsigned' ? 'selected' : '' }}
                    >
                        Belum Sign
                    </option>

                    <option
                        value="signing"
                        {{ request('status') === 'signing' ? 'selected' : '' }}
                    >
                        Sedang Sign
                    </option>

                    <option
                        value="signed"
                        {{ request('status') === 'signed' ? 'selected' : '' }}
                    >
                        Signed
                    </option>

                </select>

            </div>


            {{-- ACTION --}}
            <div class="lg:col-span-3 flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
                >
                    Cari
                </button>


                <a
                    href="{{ route('admin.events.show', $event) }}"
                    class="flex-1 px-4 py-2.5 rounded-xl border bg-white text-center text-sm font-semibold hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>


{{-- =========================================================
     MAIN GRID
========================================================= --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">


    {{-- =====================================================
         SIGNER LIST
    ====================================================== --}}
    <div class="xl:col-span-2">

        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b flex items-center justify-between gap-4">

                <div>

                    <h3 class="text-lg font-bold">
                        Senarai Penandatangan
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Pilih individu yang akan menandatangani untuk event ini.
                    </p>

                </div>


                <div class="text-right">

                    <div class="text-xs text-gray-500">
                        Hasil
                    </div>

                    <div class="text-lg font-bold">
                        {{ $signers->count() }}
                    </div>

                </div>

            </div>


            <div class="divide-y">

                @forelse ($signers as $signer)

                    @php

                        $isSigning =
                            $activeSigningSession?->signer_id ===
                            $signer->id;

                        $hasSigned =
                            $signedSignerIds->contains(
                                $signer->id
                            );

                    @endphp


                    <div class="p-5">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                            {{-- SIGNER INFO --}}
                            <div class="min-w-0">

                                <div class="font-semibold">
                                    {{ $signer->name }}
                                </div>


                                <div class="text-sm text-gray-500 mt-1">

                                    {{ $signer->position ?? '-' }}

                                    @if ($signer->organization)

                                        • {{ $signer->organization }}

                                    @endif

                                </div>


                                {{-- STATUS --}}
                                <div class="mt-3">

                                    @if ($isSigning)

                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold"
                                        >
                                            SIGNING
                                        </span>

                                    @elseif ($hasSigned)

                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"
                                        >
                                            SIGNED
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold"
                                        >
                                            BELUM SIGN
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- ACTION --}}
                            <div class="shrink-0">

                                @if ($isSigning)

                                    <button
                                        type="button"
                                        disabled
                                        class="px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 text-sm font-semibold cursor-not-allowed"
                                    >
                                        Sedang Sign
                                    </button>

                                @else

                                    <form
                                        action="{{ route(
                                            'admin.events.request-sign',
                                            [$event, $signer]
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 whitespace-nowrap"
                                        >

                                            {{
                                                $hasSigned
                                                    ? 'Sign Semula'
                                                    : 'Minta Sign'
                                            }}

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    </div>


                @empty

                    <div class="py-14 px-5 text-center">

                        <div class="text-4xl mb-3">
                            🔍
                        </div>

                        <div class="font-semibold">
                            Tiada penandatangan ditemui
                        </div>

                        <div class="text-sm text-gray-500 mt-1">
                            Cuba ubah carian atau status filter.
                        </div>


                        @if (
                            request()->filled('q') ||
                            request('status', 'all') !== 'all'
                        )

                            <a
                                href="{{ route('admin.events.show', $event) }}"
                                class="inline-flex mt-4 px-4 py-2 rounded-lg border bg-white text-sm font-semibold hover:bg-gray-50"
                            >
                                Reset Filter
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =====================================================
         RIGHT SIDE
    ====================================================== --}}
    <div class="space-y-5">


        {{-- STATUS EVENT --}}
        <div class="bg-white border rounded-2xl shadow-sm p-5">

            <h3 class="font-bold">
                Status Event
            </h3>


            <div class="space-y-4 text-sm mt-4">

                <div>

                    <div class="text-gray-500">
                        Tarikh
                    </div>

                    <div class="font-semibold mt-1">
                        {{ $event->event_date->format('d/m/Y') }}
                    </div>

                </div>


                <div>

                    <div class="text-gray-500">
                        Lokasi
                    </div>

                    <div class="font-semibold mt-1">
                        {{ $event->location ?? '-' }}
                    </div>

                </div>


                <div>

                    <div class="text-gray-500">
                        Status
                    </div>


                    @if ($event->is_active)

                        <span
                            class="inline-flex mt-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"
                        >
                            Aktif
                        </span>

                    @else

                        <span
                            class="inline-flex mt-1 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold"
                        >
                            Tidak Aktif
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- =================================================
             CURRENT SIGNING SESSION
        ================================================== --}}
        <div class="bg-white border rounded-2xl shadow-sm p-5">

            <h3 class="font-bold">
                Current Signing Session
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Penandatangan yang sedang aktif pada Sign Device.
            </p>


            @if ($activeSigningSession)

                <div class="mt-4 rounded-xl border bg-gray-50 p-4">

                    <div class="text-xs uppercase tracking-wide text-gray-400">
                        Penandatangan
                    </div>


                    <div class="font-bold text-lg mt-1">
                        {{ $activeSigningSession->signer?->name ?? '-' }}
                    </div>


                    @if ($activeSigningSession->signer?->position)

                        <div class="text-sm text-gray-500 mt-1">
                            {{ $activeSigningSession->signer->position }}
                        </div>

                    @endif


                    @if ($activeSigningSession->signer?->organization)

                        <div class="text-sm text-gray-500">
                            {{ $activeSigningSession->signer->organization }}
                        </div>

                    @endif


                    <div class="mt-4 flex items-center justify-between gap-3">

                        <div>

                            <div class="text-xs text-gray-500">
                                Dibuka
                            </div>

                            <div class="text-sm font-semibold mt-1">

                                @if ($activeSigningSession->opened_at)

                                    {{
                                        $activeSigningSession
                                            ->opened_at
                                            ->format('d/m/Y h:i A')
                                    }}

                                @else

                                    -

                                @endif

                            </div>

                        </div>


                        <span
                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold"
                        >
                            SIGNING
                        </span>

                    </div>


                    <form
                        action="{{ route(
                            'admin.events.cancel-signing',
                            $event
                        ) }}"
                        method="POST"
                        class="mt-4"
                        onsubmit="return confirm(
                            'Batalkan sesi signing aktif ini?'
                        );"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-white text-sm font-semibold hover:bg-gray-800"
                        >
                            Batal Sesi Signing
                        </button>

                    </form>

                </div>


            @else

                <div class="mt-4 rounded-xl border border-dashed py-8 px-4 text-center">

                    <div class="text-3xl mb-2">
                        ⏳
                    </div>

                    <div class="font-semibold">
                        Tiada sesi signing aktif
                    </div>

                    <div class="text-sm text-gray-500 mt-1">
                        Tekan “Minta Sign” pada penandatangan untuk memulakan sesi.
                    </div>

                </div>

            @endif

        </div>


        {{-- =================================================
             REMOTE SIGN DEVICE CONTROL
        ================================================== --}}
        <div class="bg-white border rounded-2xl shadow-sm p-5">

            <h3 class="font-bold">
                Kawalan Sign Device
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Kawalan jauh untuk tandatangan yang sedang dibuat.
            </p>


            @if ($activeSigningSession)

                <form
                    action="{{ route(
                        'admin.events.clear-signature',
                        $event
                    ) }}"
                    method="POST"
                    class="mt-4"
                    onsubmit="return confirm(
                        'Padam tandatangan yang sedang dilukis pada Sign Device?'
                    );"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-white text-sm font-semibold hover:bg-red-700"
                    >
                        Padam Signature di Device
                    </button>

                </form>


                <p class="text-xs text-gray-500 mt-3">
                    Canvas akan dikosongkan dan countdown auto-save akan dibatalkan.
                </p>


            @else

                <button
                    type="button"
                    disabled
                    class="w-full mt-4 rounded-lg bg-gray-100 px-4 py-2.5 text-gray-400 text-sm font-semibold cursor-not-allowed"
                >
                    Tiada Sesi Aktif
                </button>

            @endif

        </div>

    </div>

</div>


@endsection


{{-- =========================================================
     REALTIME
========================================================= --}}
@push('scripts')

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            if (!window.Echo) {

                console.error(
                    'Laravel Echo belum tersedia.'
                );

                return;
            }


            window.Echo
                .channel(
                    'signing.event.{{ $event->id }}'
                )
                .listen(
                    '.SigningSessionUpdated',
                    function (data) {

                        console.log(
                            'SigningSessionUpdated diterima:',
                            data
                        );

                        window.location.reload();
                    }
                );

        }
    );
</script>

@endpush