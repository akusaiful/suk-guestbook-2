@extends('layouts.admin')

@section('title', 'Penandatangan')

@section('page-title', 'Penandatangan')

@section(
    'page-subtitle',
    'Urus senarai individu yang dibenarkan menandatangani.'
)

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

    <div>

        <h2 class="text-xl font-bold">
            Senarai Penandatangan
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambah, edit, aktifkan atau nyahaktif penandatangan.
        </p>

    </div>


    <a
        href="{{ route('admin.signers.create') }}"
        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800"
    >
        + Tambah Penandatangan
    </a>

</div>


<div class="bg-white border rounded-2xl overflow-hidden shadow-sm">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Nama
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Jawatan
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Organisasi
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

                @forelse ($signers as $signer)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4 align-top">

                            <div class="font-semibold text-sm">
                                {{ $signer->name }}
                            </div>

                        </td>


                        <td class="px-5 py-4 align-top text-sm">
                            {{ $signer->position ?? '-' }}
                        </td>


                        <td class="px-5 py-4 align-top text-sm">
                            {{ $signer->organization ?? '-' }}
                        </td>


                        <td class="px-5 py-4 align-top">

                            @if ($signer->is_active)

                                <span
                                    class="inline-flex px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"
                                >
                                    Aktif
                                </span>

                            @else

                                <span
                                    class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold"
                                >
                                    Tidak Aktif
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-4 align-top">

                            <div class="flex justify-end flex-wrap gap-2">

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('admin.signers.edit', $signer) }}"
                                    class="px-3 py-2 rounded-lg border bg-white text-xs font-semibold hover:bg-gray-50"
                                >
                                    Edit
                                </a>


                                {{-- AKTIF / NYAHAKTIF --}}
                                <form
                                    action="{{ route('admin.signers.toggle-status', $signer) }}"
                                    method="POST"
                                    onsubmit="return confirm(
                                        '{{ $signer->is_active
                                            ? 'Nyahaktifkan penandatangan ini?'
                                            : 'Aktifkan semula penandatangan ini?' }}'
                                    );"
                                >

                                    @csrf
                                    @method('PATCH')

                                    @if ($signer->is_active)

                                        <button
                                            type="submit"
                                            class="px-3 py-2 rounded-lg bg-amber-100 text-amber-700 text-xs font-semibold hover:bg-amber-200"
                                        >
                                            Nyahaktif
                                        </button>

                                    @else

                                        <button
                                            type="submit"
                                            class="px-3 py-2 rounded-lg bg-green-100 text-green-700 text-xs font-semibold hover:bg-green-200"
                                        >
                                            Aktifkan
                                        </button>

                                    @endif

                                </form>


                                {{-- SOFT DELETE --}}
                                <form
                                    action="{{ route('admin.signers.destroy', $signer) }}"
                                    method="POST"
                                    onsubmit="return confirm(
                                        'Padam penandatangan ini? Rekod sejarah tandatangan lama akan kekal.'
                                    );"
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
                                🖊️
                            </div>

                            <div class="font-semibold">
                                Belum ada penandatangan
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Tambah penandatangan pertama untuk mula menggunakan modul signing.
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- PAGINATION --}}
@if ($signers->hasPages())

    <div class="mt-5">
        {{ $signers->links() }}
    </div>

@endif

@endsection