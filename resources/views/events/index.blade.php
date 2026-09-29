@extends('layouts.app')

@section('title', 'Senarai Event')

@section('content')

    <div class="mb-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Senarai Event
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Urus event atau program Guestbook.
                </p>
            </div>

            <div>
                <a href="{{ route('events.create') }}"
                    class="inline-flex items-center rounded-lg bg-black px-5 py-3 font-semibold text-white hover:bg-gray-800">
                    + Tambah Event
                </a>
            </div>

        </div>

    </div>


    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif


    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Tarikh
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Lokasi
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Tindakan
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse ($events as $event)
                        <tr class="hover:bg-gray-50">

                            {{-- Event --}}
                            <td class="px-6 py-5">

                                <div class="font-semibold text-gray-900">
                                    {{ $event->name }}
                                </div>

                                @if ($event->description)
                                    <div class="mt-1 text-sm text-gray-500">
                                        {{ $event->description }}
                                    </div>
                                @endif

                            </td>


                            {{-- Tarikh --}}
                            <td class="px-6 py-5 text-sm text-gray-700">

                                {{ $event->event_date->format('d/m/Y') }}

                            </td>


                            {{-- Lokasi --}}
                            <td class="px-6 py-5 text-sm text-gray-700">

                                {{ $event->location ?? '-' }}

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if ($event->is_active)
                                    <span
                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600">
                                        Tidak Aktif
                                    </span>
                                @endif

                            </td>


                            {{-- Tindakan --}}
                            <td class="px-6 py-5 text-right">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- Urus Signer --}}
                                    <a href="{{ route('events.show', $event) }}"
                                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                        Urus Signer
                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('events.edit', $event) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-400 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Edit
                                    </a>


                                    {{-- Padam --}}
                                    <form action="{{ route('events.destroy', $event) }}" method="POST"
                                        onsubmit="return confirm('Adakah anda pasti mahu padam event ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg border border-red-300 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                            Padam
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-12 text-center">

                                <div class="text-lg font-semibold text-gray-700">
                                    Belum ada event
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    Klik butang "Tambah Event" untuk mula.
                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
