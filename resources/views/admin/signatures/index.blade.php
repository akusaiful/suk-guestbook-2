@extends('layouts.admin')

@section('title', 'Signature History')

@section('page-title', 'Signature History')

@section('page-subtitle', 'Rekod semua tandatangan digital yang telah disimpan.')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

    <div>

        <h2 class="text-xl font-bold">
            Rekod Tandatangan
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Semak dan urus tandatangan yang telah disimpan.
        </p>

    </div>


    <a
        href="{{ route('sign.device') }}"
        target="_blank"
        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
    >
        Buka Sign Device
    </a>

</div>


<div class="bg-white border rounded-2xl overflow-hidden shadow-sm">

    @if ($signatures->count() > 0)

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="text-left px-4 py-3">
                            #
                        </th>

                        <th class="text-left px-4 py-3">
                            Penandatangan
                        </th>

                        <th class="text-left px-4 py-3">
                            Event
                        </th>

                        <th class="text-left px-4 py-3">
                            Status
                        </th>

                        <th class="text-left px-4 py-3">
                            Tarikh / Masa
                        </th>

                        <th class="text-center px-4 py-3">
                            Tandatangan
                        </th>

                        <th class="text-center px-4 py-3">
                            Tindakan
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @foreach ($signatures as $signature)

                        @php
                            $session = $signature->signingSession;
                            $signer = $session?->signer;
                            $event = $session?->event;
                        @endphp

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-4 align-top">

                                {{ ($signatures->currentPage() - 1) * $signatures->perPage() + $loop->iteration }}

                            </td>


                            <td class="px-4 py-4 align-top">

                                <div class="font-semibold">
                                    {{ $signer?->name ?? '-' }}
                                </div>

                                @if ($signer?->position)

                                    <div class="text-gray-500 mt-1">
                                        {{ $signer->position }}
                                    </div>

                                @endif

                                @if ($signer?->organization)

                                    <div class="text-gray-500">
                                        {{ $signer->organization }}
                                    </div>

                                @endif

                            </td>


                            <td class="px-4 py-4 align-top">

                                <div class="font-medium">
                                    {{ $event?->name ?? '-' }}
                                </div>

                                @if ($event?->location)

                                    <div class="text-gray-500 mt-1">
                                        {{ $event->location }}
                                    </div>

                                @endif

                            </td>


                            <td class="px-4 py-4 align-top">

                                @if ($session?->status === 'signed')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        SIGNED
                                    </span>

                                @elseif ($session?->status === 'signing')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                        SIGNING
                                    </span>

                                @elseif ($session?->status === 'cancelled')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                        CANCELLED
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                        {{ strtoupper($session?->status ?? '-') }}
                                    </span>

                                @endif

                            </td>


                            <td class="px-4 py-4 align-top whitespace-nowrap">

                                @if ($signature->signed_at)

                                    <div class="font-medium">
                                        {{ $signature->signed_at->format('d/m/Y') }}
                                    </div>

                                    <div class="text-gray-500 mt-1">
                                        {{ $signature->signed_at->format('h:i A') }}
                                    </div>

                                @else

                                    -

                                @endif

                            </td>


                            <td class="px-4 py-4 align-top text-center">

                                @if ($signature->signature_path)

                                    <button
                                        type="button"
                                        onclick="openSignaturePreview(
                                            '{{ asset('storage/' . $signature->signature_path) }}',
                                            '{{ addslashes($signer?->name ?? 'Penandatangan') }}'
                                        )"
                                        class="px-3 py-2 rounded-lg bg-gray-900 text-white text-xs font-semibold hover:bg-gray-800"
                                    >
                                        Preview
                                    </button>

                                @else

                                    <span class="text-gray-400">
                                        Tiada tandatangan
                                    </span>

                                @endif

                            </td>


                            <td class="px-4 py-4 align-top">

                                <div class="flex justify-center">

                                    <form
                                        action="{{ route('admin.signatures.destroy', $signature) }}"
                                        method="POST"
                                        onsubmit="return confirm('Anda pasti mahu padam tandatangan ini? Tindakan ini tidak boleh dibatalkan.');"
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

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="py-16 px-4 text-center">

            <div class="text-4xl mb-4">
                ✍️
            </div>

            <h2 class="text-lg font-bold">
                Belum Ada Tandatangan
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Rekod tandatangan akan muncul di sini selepas penandatangan selesai menandatangani.
            </p>

        </div>

    @endif

</div>


{{-- PAGINATION --}}
@if ($signatures->hasPages())

    <div class="mt-6">
        {{ $signatures->links() }}
    </div>

@endif


{{-- PREVIEW MODAL --}}
<div
    id="signature-preview-modal"
    class="fixed inset-0 hidden items-center justify-center bg-black/60 z-50 px-4"
    onclick="handlePreviewBackdrop(event)"
>

    <div
        class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6"
        onclick="event.stopPropagation()"
    >

        <div class="flex items-center justify-between gap-4 mb-4">

            <div>

                <h3 class="text-lg font-bold">
                    Preview Tandatangan
                </h3>

                <p
                    id="signature-preview-name"
                    class="text-sm text-gray-500 mt-1"
                >
                </p>

            </div>


            <button
                type="button"
                onclick="closeSignaturePreview()"
                class="text-gray-500 hover:text-gray-900 text-2xl leading-none"
                aria-label="Tutup"
            >
                ×
            </button>

        </div>


        <div class="border rounded-xl bg-gray-50 p-4 flex items-center justify-center min-h-64">

            <img
                id="signature-preview-image"
                src=""
                alt="Preview Tandatangan"
                class="max-w-full max-h-80 object-contain"
            >

        </div>


        <div class="mt-5 flex justify-end">

            <button
                type="button"
                onclick="closeSignaturePreview()"
                class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
            >
                Tutup
            </button>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
    function openSignaturePreview(
        imageUrl,
        signerName
    ) {
        const modal =
            document.getElementById(
                'signature-preview-modal'
            );

        const image =
            document.getElementById(
                'signature-preview-image'
            );

        const name =
            document.getElementById(
                'signature-preview-name'
            );

        image.src = imageUrl;

        name.textContent =
            signerName;

        modal.classList.remove(
            'hidden'
        );

        modal.classList.add(
            'flex'
        );

        document.body.style.overflow =
            'hidden';
    }


    function closeSignaturePreview() {

        const modal =
            document.getElementById(
                'signature-preview-modal'
            );

        const image =
            document.getElementById(
                'signature-preview-image'
            );

        modal.classList.add(
            'hidden'
        );

        modal.classList.remove(
            'flex'
        );

        image.src = '';

        document.body.style.overflow =
            '';
    }


    function handlePreviewBackdrop(event) {

        if (
            event.target.id ===
            'signature-preview-modal'
        ) {
            closeSignaturePreview();
        }
    }


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeSignaturePreview();
            }

        }
    );
</script>

@endpush