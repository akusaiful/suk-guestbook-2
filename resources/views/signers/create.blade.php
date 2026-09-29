@extends('layouts.admin')

@section('title', 'Tambah Penandatangan')

@section('page-title', 'Tambah Penandatangan')

@section('page-subtitle', 'Daftar individu baru untuk modul tandatangan.')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="flex items-center justify-between gap-4 mb-5">

        <div>
            <h2 class="text-xl font-bold">
                Maklumat Penandatangan
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Lengkapkan maklumat individu di bawah.
            </p>
        </div>

        <a
            href="{{ route('admin.signers.index') }}"
            class="px-4 py-2 rounded-lg border bg-white text-sm font-semibold hover:bg-gray-50 whitespace-nowrap"
        >
            ← Kembali
        </a>

    </div>


    @if ($errors->any())

        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">

            <div class="font-semibold mb-2">
                Sila semak maklumat berikut:
            </div>

            <ul class="list-disc pl-5 text-sm space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white border rounded-2xl shadow-sm p-6">

        <form
            method="POST"
            action="{{ route('admin.signers.store') }}"
            class="space-y-5"
        >

            @csrf


            <div>

                <label class="block text-sm font-semibold mb-2">
                    Nama Penuh *
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Contoh: Ahmad bin Ali"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

                @error('name')
                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Jawatan
                    </label>

                    <input
                        type="text"
                        name="position"
                        value="{{ old('position') }}"
                        placeholder="Contoh: TKSP"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Organisasi
                    </label>

                    <input
                        type="text"
                        name="organization"
                        value="{{ old('organization') }}"
                        placeholder="Contoh: JKMM"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >

                </div>

            </div>


            <div>

                <label class="block text-sm font-semibold mb-2">
                    Status
                </label>

                <label
                    class="flex items-center gap-3 border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 cursor-pointer"
                >

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300"
                    >

                    <div>

                        <div class="text-sm font-semibold">
                            Aktifkan Penandatangan
                        </div>

                        <div class="text-xs text-gray-500 mt-1">
                            Penandatangan aktif boleh dipilih dalam event.
                        </div>

                    </div>

                </label>

            </div>


            <div class="flex flex-col sm:flex-row gap-3 pt-1">

                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-800"
                >
                    Simpan Penandatangan
                </button>

                <a
                    href="{{ route('admin.signers.index') }}"
                    class="flex-1 px-4 py-2.5 rounded-xl border bg-white text-center font-semibold hover:bg-gray-50"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection