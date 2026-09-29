@extends('layouts.admin')

@section('title', 'Laporan')

@section('page-title', 'Laporan')

@section(
    'page-subtitle',
    'Laporan visitor, komen, rating dan tandatangan.'
)

@section('content')

<style>
    @media print {

        .no-print {
            display: none !important;
        }

        body {
            background: #ffffff !important;
        }

        .print-report-card {
            box-shadow: none !important;
            break-inside: avoid;
        }

        table {
            font-size: 10px !important;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }
    }
</style>


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6 no-print">

    <div>

        <h2 class="text-xl font-bold">
            Laporan Digital Guestbook
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tapis laporan mengikut event atau tempoh tarikh.
        </p>

    </div>


    <div class="flex flex-wrap gap-2">

        <a
            href="{{ route(
                'admin.reports.export.csv',
                request()->query()
            ) }}"
            class="px-4 py-2.5 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700"
        >
            Export Excel / CSV
        </a>


        <button
            type="button"
            onclick="window.print()"
            class="px-4 py-2.5 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
        >
            Print / PDF
        </button>

    </div>

</div>


{{-- =========================================================
     FILTER
========================================================= --}}

<div class="bg-white border rounded-2xl shadow-sm p-5 mb-6 no-print">

    <form
        method="GET"
        action="{{ route('admin.reports.index') }}"
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4"
    >

        {{-- EVENT --}}
        <div>

            <label class="block text-sm font-semibold mb-2">
                Event
            </label>

            <select
                name="event_id"
                class="w-full border border-gray-300 rounded-xl px-3 py-2.5 bg-white"
            >

                <option value="">
                    Semua Event
                </option>

                @foreach ($events as $event)

                    <option
                        value="{{ $event->id }}"
                        {{ request('event_id') == $event->id ? 'selected' : '' }}
                    >
                        {{ $event->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- DATE FROM --}}
        <div>

            <label class="block text-sm font-semibold mb-2">
                Tarikh Dari
            </label>

            <input
                type="date"
                name="date_from"
                value="{{ request('date_from') }}"
                class="w-full border border-gray-300 rounded-xl px-3 py-2.5"
            >

        </div>


        {{-- DATE TO --}}
        <div>

            <label class="block text-sm font-semibold mb-2">
                Tarikh Hingga
            </label>

            <input
                type="date"
                name="date_to"
                value="{{ request('date_to') }}"
                class="w-full border border-gray-300 rounded-xl px-3 py-2.5"
            >

        </div>


        {{-- ACTION --}}
        <div class="flex items-end gap-2">

            <button
                type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-800"
            >
                Tapis
            </button>


            <a
                href="{{ route('admin.reports.index') }}"
                class="flex-1 px-4 py-2.5 rounded-xl border bg-white text-center font-semibold hover:bg-gray-50"
            >
                Reset
            </a>

        </div>

    </form>

</div>


{{-- =========================================================
     PRINT HEADER
========================================================= --}}

<div class="hidden print:block mb-6">

    <h1 class="text-2xl font-bold">
        MELAKA DIGITAL GUESTBOOK
    </h1>

    <h2 class="text-xl font-bold mt-2">
        Laporan Sistem
    </h2>


    @if ($selectedEvent)

        <p class="mt-2">
            Event:
            <strong>
                {{ $selectedEvent->name }}
            </strong>
        </p>

    @else

        <p class="mt-2">
            Event:
            <strong>
                Semua Event
            </strong>
        </p>

    @endif


    @if ($dateFrom || $dateTo)

        <p>

            Tempoh:

            <strong>

                @if ($dateFrom)

                    {{
                        \Carbon\Carbon::parse(
                            $dateFrom
                        )->format('d/m/Y')
                    }}

                @else

                    -

                @endif

                hingga

                @if ($dateTo)

                    {{
                        \Carbon\Carbon::parse(
                            $dateTo
                        )->format('d/m/Y')
                    }}

                @else

                    -

                @endif

            </strong>

        </p>

    @endif


    <p>
        Dicetak:
        {{ now()->format('d/m/Y h:i A') }}
    </p>

</div>


{{-- =========================================================
     SUMMARY
========================================================= --}}

<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- VISITOR --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm print-report-card">

        <div class="flex items-center justify-between">

            <div>

                <div class="text-xs text-gray-500">
                    Jumlah Visitor
                </div>

                <div class="text-3xl font-bold mt-2">
                    {{ $visitorCount }}
                </div>

            </div>

            <div class="text-3xl">
                👥
            </div>

        </div>

    </div>


    {{-- COMMENT --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm print-report-card">

        <div class="flex items-center justify-between">

            <div>

                <div class="text-xs text-gray-500">
                    Jumlah Komen
                </div>

                <div class="text-3xl font-bold mt-2">
                    {{ $commentCount }}
                </div>

            </div>

            <div class="text-3xl">
                💬
            </div>

        </div>

    </div>


    {{-- RATING --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm print-report-card">

        <div>

            <div class="text-xs text-gray-500">
                Purata Rating
            </div>

            <div class="text-3xl font-bold mt-2">
                {{ number_format($averageRating, 1) }}
            </div>

            <div class="text-yellow-500 mt-2 text-sm">

                @for ($i = 1; $i <= 5; $i++)

                    @if ($i <= round($averageRating))
                        ★
                    @else
                        ☆
                    @endif

                @endfor

            </div>

        </div>

    </div>


    {{-- SIGNATURE --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm print-report-card">

        <div class="flex items-center justify-between">

            <div>

                <div class="text-xs text-gray-500">
                    Jumlah Signature
                </div>

                <div class="text-3xl font-bold mt-2">
                    {{ $signatureCount }}
                </div>

            </div>

            <div class="text-3xl">
                ✍️
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     VISITOR TABLE
========================================================= --}}

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden mb-6 print-report-card">

    <div class="px-5 py-4 border-b">

        <h3 class="font-bold text-lg">
            Senarai Visitor
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            {{ $visitorCount }} rekod visitor ditemui.
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        #
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Nama
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Organisasi
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Event
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Check-In
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Kaedah
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse ($visitors as $visitor)

                    <tr>

                        <td class="px-4 py-3 text-sm">
                            {{ $loop->iteration }}
                        </td>


                        <td class="px-4 py-3">

                            <div class="font-semibold">
                                {{ $visitor->name }}
                            </div>

                            @if ($visitor->email)

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $visitor->email }}
                                </div>

                            @endif

                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $visitor->organization ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $visitor->event?->name ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm whitespace-nowrap">

                            @if ($visitor->checked_in_at)

                                <div>
                                    {{ $visitor->checked_in_at->format('d/m/Y') }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $visitor->checked_in_at->format('h:i A') }}
                                </div>

                            @else

                                -

                            @endif

                        </td>


                        <td class="px-4 py-3 text-sm">

                            <span class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                {{ strtoupper($visitor->registration_method ?? '-') }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="py-10 px-4 text-center text-gray-500"
                        >
                            Tiada rekod visitor.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- =========================================================
     COMMENT & RATING
========================================================= --}}

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden mb-6 print-report-card">

    <div class="px-5 py-4 border-b">

        <h3 class="font-bold text-lg">
            Komen & Rating
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            {{ $commentCount }} maklum balas pengunjung.
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Nama
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Event
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Rating
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Komen
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Tarikh
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse ($comments as $comment)

                    <tr>

                        <td class="px-4 py-3">

                            <div class="font-semibold">
                                {{ $comment->name }}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                {{ $comment->organization ?? '-' }}
                            </div>

                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $comment->event?->name ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm whitespace-nowrap">

                            @if ($comment->rating)

                                <div class="text-yellow-500">
                                    {{ str_repeat('★', $comment->rating) }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $comment->rating }}/5
                                </div>

                            @else

                                -

                            @endif

                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $comment->comment }}
                        </td>


                        <td class="px-4 py-3 text-sm whitespace-nowrap">

                            @if ($comment->published_at)

                                <div>
                                    {{ $comment->published_at->format('d/m/Y') }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $comment->published_at->format('h:i A') }}
                                </div>

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="py-10 px-4 text-center text-gray-500"
                        >
                            Tiada komen atau rating.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- =========================================================
     SIGNATURE TABLE
========================================================= --}}

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden print-report-card">

    <div class="px-5 py-4 border-b">

        <h3 class="font-bold text-lg">
            Rekod Tandatangan
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            {{ $signatureCount }} tandatangan direkodkan.
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        #
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Penandatangan
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Jawatan
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Organisasi
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Event
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                        Tarikh / Masa
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y">

                @forelse ($signatures as $signature)

                    @php

                        $signingSession =
                            $signature->signingSession;

                        $signer =
                            $signingSession?->signer;

                        $signatureEvent =
                            $signingSession?->event;

                    @endphp


                    <tr>

                        <td class="px-4 py-3 text-sm">
                            {{ $loop->iteration }}
                        </td>


                        <td class="px-4 py-3 font-semibold">
                            {{ $signer?->name ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $signer?->position ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $signer?->organization ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm">
                            {{ $signatureEvent?->name ?? '-' }}
                        </td>


                        <td class="px-4 py-3 text-sm whitespace-nowrap">

                            @if ($signature->signed_at)

                                <div>
                                    {{ $signature->signed_at->format('d/m/Y') }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $signature->signed_at->format('h:i A') }}
                                </div>

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="py-10 px-4 text-center text-gray-500"
                        >
                            Tiada rekod tandatangan.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection