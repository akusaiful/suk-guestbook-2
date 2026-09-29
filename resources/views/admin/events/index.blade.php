@extends('layouts.admin')

@section('title', 'Event Management')

@section('page-title', 'Event Management')

@section('page-subtitle', 'Urus event dan program Guestbook.')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

    <div>

        <h2 class="text-xl font-bold">
            Senarai Event
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Semua event yang telah didaftarkan dalam sistem.
        </p>

    </div>


    <a
        href="{{ route('admin.events.create') }}"
        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
    >
        + Tambah Event
    </a>

</div>


<div class="bg-white border rounded-2xl overflow-hidden shadow-sm">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Event
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Tarikh
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Lokasi
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Status
                    </th>

                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Tindakan
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200">

                @forelse ($events as $event)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4 align-top">

                            <div class="font-semibold text-sm">
                                {{ $event->name }}
                            </div>

                            @if ($event->description)

                                <div class="text-xs text-gray-500 mt-1 max-w-md">
                                    {{ \Illuminate\Support\Str::limit($event->description, 90) }}
                                </div>

                            @endif

                        </td>


                        <td class="px-5 py-4 align-top text-sm whitespace-nowrap">
                            {{ $event->event_date->format('d/m/Y') }}
                        </td>


                        <td class="px-5 py-4 align-top text-sm">
                            {{ $event->location ?? '-' }}
                        </td>


                        <td class="px-5 py-4 align-top">

                            @if ($event->is_active)

                                <span class="inline-flex px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    Aktif
                                </span>

                            @else

                                <span class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                    Tidak Aktif
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-4 align-top">

                            <div class="flex justify-end flex-wrap gap-2">

                                <a
                                    href="{{ route('admin.events.show', $event) }}"
                                    class="px-3 py-2 rounded-lg bg-gray-900 text-white text-xs font-semibold hover:bg-gray-800"
                                >
                                    Urus Signer
                                </a>

                                <a
                                    href="{{ route('display.show', $event) }}"
                                    target="_blank"
                                    class="px-3 py-2 rounded-lg border bg-white text-xs font-semibold hover:bg-gray-50"
                                >
                                    Display
                                </a>

                                <a
                                    href="{{ route('admin.events.qr', $event) }}"
                                    target="_blank"
                                    class="px-3 py-2 rounded-lg border bg-white text-xs font-semibold hover:bg-gray-50"
                                >
                                    QR
                                </a>

                                <a
                                    href="{{ route('admin.events.edit', $event) }}"
                                    class="px-3 py-2 rounded-lg border bg-white text-xs font-semibold hover:bg-gray-50"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.events.destroy', $event) }}"
                                    method="POST"
                                    onsubmit="return confirm('Padam event ini?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-2 rounded-lg border border-red-200 text-red-600 text-xs font-semibold hover:bg-red-50"
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
                            colspan="5"
                            class="px-6 py-14 text-center"
                        >

                            <div class="text-4xl mb-3">
                                📅
                            </div>

                            <div class="font-semibold">
                                Belum ada event
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Tambah event pertama untuk mula menggunakan Guestbook.
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


@if ($events->hasPages())

    <div class="mt-5">
        {{ $events->links() }}
    </div>

@endif

@endsection