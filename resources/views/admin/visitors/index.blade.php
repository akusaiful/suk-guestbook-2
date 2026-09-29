@extends('layouts.admin')

@section('title', 'Visitor Management')

@section('page-title', 'Visitor Management')

@section('page-subtitle', 'Urus pendaftaran dan rekod pengunjung mengikut event.')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

    <div>

        <h2 class="text-xl font-bold">
            Senarai Pengunjung
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Semak pengunjung, tapis mengikut event dan urus rekod pendaftaran.
        </p>

    </div>


    <a
        href="{{ route('admin.visitors.create') }}"
        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
    >
        + Daftar Pengunjung
    </a>

</div>


{{-- FILTER + SUMMARY --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">

    {{-- FILTER --}}
    <div class="xl:col-span-2 bg-white border rounded-2xl p-5 shadow-sm">

        <div class="mb-3">

            <h3 class="font-semibold">
                Tapis Pengunjung
            </h3>

            <p class="text-xs text-gray-500 mt-1">
                Pilih event untuk memaparkan rekod tertentu.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('admin.visitors.index') }}"
            class="flex flex-col md:flex-row gap-3"
        >

            <select
                name="event_id"
                class="flex-1 border border-gray-300 rounded-xl px-3 py-3 bg-white"
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


            <button
                type="submit"
                class="px-5 py-3 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
            >
                Tapis
            </button>


            <a
                href="{{ route('admin.visitors.index') }}"
                class="px-5 py-3 rounded-xl border bg-white text-center text-sm font-semibold hover:bg-gray-50"
            >
                Reset
            </a>

        </form>

    </div>


    {{-- SUMMARY --}}
    <div class="grid grid-cols-2 xl:grid-cols-1 gap-4">

        <div class="bg-white border rounded-2xl p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-xs text-gray-500">
                        Jumlah Pengunjung
                    </div>

                    <div class="text-2xl font-bold mt-1">
                        {{ $totalVisitors }}
                    </div>

                </div>

                <div class="text-3xl">
                    👥
                </div>

            </div>

        </div>


        <div class="bg-white border rounded-2xl p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-xs text-gray-500">
                        Daftar Hari Ini
                    </div>

                    <div class="text-2xl font-bold mt-1">
                        {{ $todayVisitors }}
                    </div>

                </div>

                <div class="text-3xl">
                    📍
                </div>

            </div>

        </div>

    </div>

</div>


{{-- TABLE --}}
<div class="bg-white border rounded-2xl overflow-hidden shadow-sm">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Nama
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Organisasi
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Telefon
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Event
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Check-In
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Kaedah
                    </th>

                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Tindakan
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200">

                @forelse ($visitors as $visitor)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4 align-top">

                            <div class="font-semibold text-sm">
                                {{ $visitor->name }}
                            </div>

                            @if ($visitor->email)

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $visitor->email }}
                                </div>

                            @endif

                        </td>


                        <td class="px-5 py-4 align-top text-sm">
                            {{ $visitor->organization ?? '-' }}
                        </td>


                        <td class="px-5 py-4 align-top text-sm">
                            {{ $visitor->phone ?? '-' }}
                        </td>


                        <td class="px-5 py-4 align-top">

                            <div class="text-sm font-medium">
                                {{ $visitor->event?->name ?? '-' }}
                            </div>

                        </td>


                        <td class="px-5 py-4 align-top text-sm whitespace-nowrap">

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


                        <td class="px-5 py-4 align-top">

                            @if ($visitor->registration_method === 'qr')

                                <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    QR
                                </span>

                            @elseif ($visitor->registration_method === 'admin')

                                <span class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                    ADMIN
                                </span>

                            @else

                                <span class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                    {{ strtoupper($visitor->registration_method ?? '-') }}
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-4 align-top">

                            <div class="flex justify-end">

                                <form
                                    method="POST"
                                    action="{{ route('admin.visitors.destroy', $visitor) }}"
                                    onsubmit="return confirm('Padam pengunjung ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-2 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700"
                                    >
                                        Padam
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-6 py-14 text-center"
                        >

                            <div class="text-4xl mb-3">
                                👥
                            </div>

                            <div class="font-semibold">
                                Belum ada pengunjung
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Rekod pengunjung akan dipaparkan di sini.
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- PAGINATION --}}
@if ($visitors->hasPages())

    <div class="mt-5">
        {{ $visitors->links() }}
    </div>

@endif

@endsection