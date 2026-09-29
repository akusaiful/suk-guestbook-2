@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section(
    'page-subtitle',
    'Smart Visitor Registration & Digital Signature'
)

@section('content')

{{-- =========================================================
     STATISTICS
========================================================= --}}

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    {{-- VISITOR --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm">

        <div class="flex items-center justify-between gap-4">

            <div>

                <div class="text-xs text-gray-500">
                    Jumlah Visitor
                </div>

                <div class="text-3xl font-bold mt-2">
                    {{ $totalVisitors }}
                </div>

            </div>

            <div class="text-3xl">
                👥
            </div>

        </div>

    </div>


    {{-- COMMENT --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm">

        <div class="flex items-center justify-between gap-4">

            <div>

                <div class="text-xs text-gray-500">
                    Jumlah Komen
                </div>

                <div class="text-3xl font-bold mt-2">
                    {{ $totalComments }}
                </div>

            </div>

            <div class="text-3xl">
                💬
            </div>

        </div>

    </div>


    {{-- SIGNATURE --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm">

        <div class="flex items-center justify-between gap-4">

            <div>

                <div class="text-xs text-gray-500">
                    Jumlah Signature
                </div>

                <div class="text-3xl font-bold mt-2">
                    {{ $totalSignatures }}
                </div>

            </div>

            <div class="text-3xl">
                ✍️
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     MAIN CONTENT
========================================================= --}}

<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    {{-- =====================================================
         EVENT AKTIF
    ====================================================== --}}

    <div class="bg-white border rounded-2xl shadow-sm p-5">

        <div class="flex items-start justify-between gap-4 mb-4">

            <div>

                <h2 class="text-lg font-bold">
                    Event Aktif
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Paparan maksimum 3 event aktif.
                </p>

            </div>


            <a
                href="{{ route('admin.events.index') }}"
                class="px-3 py-2 rounded-lg border bg-white text-xs font-semibold hover:bg-gray-50 whitespace-nowrap"
            >
                Lihat Semua
            </a>

        </div>


        @if ($activeEvents->count())

            <div class="space-y-3">

                @foreach ($activeEvents->take(3) as $event)

                    <div class="border rounded-xl p-4">

                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                            {{-- INFO --}}
                            <div class="min-w-0">

                                <div class="font-semibold text-sm">
                                    {{ $event->name }}
                                </div>


                                <div class="text-xs text-gray-500 mt-1">

                                    {{ $event->event_date->format('d/m/Y') }}

                                    @if ($event->location)
                                        • {{ $event->location }}
                                    @endif

                                </div>


                                <span class="inline-flex mt-3 px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    Aktif
                                </span>

                            </div>


                            {{-- ACTION --}}
                            <div class="flex flex-wrap gap-2 shrink-0">

                                <a
                                    href="{{ route('admin.events.show', $event) }}"
                                    class="px-3 py-2 rounded-lg bg-gray-900 text-white text-xs font-semibold hover:bg-gray-800"
                                >
                                    Pilih
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

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            @if ($activeEvents->count() > 3)

                <div class="text-center mt-4">

                    <a
                        href="{{ route('admin.events.index') }}"
                        class="text-xs font-semibold text-gray-600 hover:underline"
                    >
                        + {{ $activeEvents->count() - 3 }} lagi event
                    </a>

                </div>

            @endif


        @else

            <div class="border border-dashed rounded-xl py-10 px-4 text-center">

                <div class="text-4xl">
                    📅
                </div>

                <div class="font-semibold mt-3">
                    Tiada event aktif
                </div>

                <div class="text-sm text-gray-500 mt-1">
                    Tambah atau aktifkan event terlebih dahulu.
                </div>

            </div>

        @endif

    </div>


    {{-- =====================================================
         KOMEN TERKINI
    ====================================================== --}}

    <div class="bg-white border rounded-2xl shadow-sm p-5">

        <div class="flex items-start justify-between gap-4 mb-4">

            <div>

                <h2 class="text-lg font-bold">
                    Komen Terkini
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Paparan maksimum 4 komen terbaru.
                </p>

            </div>


            <a
                href="{{ route('admin.visitors.index') }}"
                class="px-3 py-2 rounded-lg border bg-white text-xs font-semibold hover:bg-gray-50 whitespace-nowrap"
            >
                Lihat Visitor
            </a>

        </div>


        @if ($latestComments->count())

            <div class="space-y-3">

                @foreach ($latestComments->take(4) as $comment)

                    <div class="border rounded-xl p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <div class="text-sm font-semibold">
                                    {{ $comment->name }}
                                </div>


                                @if ($comment->organization)

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $comment->organization }}
                                    </div>

                                @endif

                            </div>


                            @if ($comment->rating)

                                <div class="text-xs whitespace-nowrap">

                                    @for ($i = 1; $i <= 5; $i++)

                                        @if ($i <= $comment->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif

                                    @endfor

                                </div>

                            @endif

                        </div>


                        <div class="text-sm text-gray-700 mt-3 leading-relaxed">

                            {{
                                \Illuminate\Support\Str::limit(
                                    $comment->comment,
                                    110
                                )
                            }}

                        </div>

                    </div>

                @endforeach

            </div>


            @if ($latestComments->count() > 4)

                <div class="text-center mt-4">

                    <a
                        href="{{ route('admin.visitors.index') }}"
                        class="text-xs font-semibold text-gray-600 hover:underline"
                    >
                        + {{ $latestComments->count() - 4 }} lagi komen
                    </a>

                </div>

            @endif


        @else

            <div class="border border-dashed rounded-xl py-10 px-4 text-center">

                <div class="text-4xl">
                    💬
                </div>

                <div class="font-semibold mt-3">
                    Belum ada komen
                </div>

                <div class="text-sm text-gray-500 mt-1">
                    Komen visitor akan muncul di sini.
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     QUICK ACTION
========================================================= --}}

<div class="mt-5 bg-white border rounded-2xl shadow-sm p-5">

    <div class="mb-4">

        <h2 class="text-lg font-bold">
            Akses Pantas
        </h2>

        <p class="text-xs text-gray-500 mt-1">
            Modul utama sistem Guestbook.
        </p>

    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3">

        <a
            href="{{ route('admin.events.index') }}"
            class="border rounded-xl p-4 hover:bg-gray-50"
        >
            <div class="text-2xl">
                📅
            </div>

            <div class="text-sm font-semibold mt-2">
                Event
            </div>
        </a>


        <a
            href="{{ route('admin.visitors.index') }}"
            class="border rounded-xl p-4 hover:bg-gray-50"
        >
            <div class="text-2xl">
                👥
            </div>

            <div class="text-sm font-semibold mt-2">
                Visitor
            </div>
        </a>


        <a
            href="{{ route('admin.signatures.index') }}"
            class="border rounded-xl p-4 hover:bg-gray-50"
        >
            <div class="text-2xl">
                ✍️
            </div>

            <div class="text-sm font-semibold mt-2">
                Signature
            </div>
        </a>


        <a
            href="{{ route('admin.reports.index') }}"
            class="border rounded-xl p-4 hover:bg-gray-50"
        >
            <div class="text-2xl">
                📊
            </div>

            <div class="text-sm font-semibold mt-2">
                Laporan
            </div>
        </a>


        <a
            href="{{ route('admin.signers.index') }}"
            class="border rounded-xl p-4 hover:bg-gray-50"
        >
            <div class="text-2xl">
                🖊️
            </div>

            <div class="text-sm font-semibold mt-2">
                Penandatangan
            </div>
        </a>


        <a
            href="{{ route('sign.device') }}"
            target="_blank"
            class="border rounded-xl p-4 hover:bg-gray-50"
        >
            <div class="text-2xl">
                📱
            </div>

            <div class="text-sm font-semibold mt-2">
                Sign Device
            </div>
        </a>

    </div>

</div>

@endsection