@extends('layouts.admin')

@section('title', 'Tambah Event')

@section('page-title', 'Tambah Event')

@section('page-subtitle', 'Daftar event atau program baru untuk Guestbook.')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between gap-4 mb-5">

        <div>

            <h2 class="text-xl font-bold">
                Maklumat Event
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Lengkapkan maklumat event di bawah.
            </p>

        </div>

        <a
            href="{{ route('admin.events.index') }}"
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

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white border rounded-2xl shadow-sm p-6">

        <form
            method="POST"
            action="{{ route('admin.events.store') }}"
            class="space-y-5"
        >

            @csrf


            {{-- NAMA EVENT --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    Nama Event *
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Contoh: Majlis Pelancaran Melaka Digital Guestbook"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

                @error('name')

                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- TARIKH + LOKASI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Tarikh Event *
                    </label>

                    <input
                        type="date"
                        name="event_date"
                        value="{{ old('event_date') }}"
                        required
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >

                    @error('event_date')

                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Lokasi
                    </label>

                    <input
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Contoh: MITC, Melaka"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >

                    @error('location')

                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- KETERANGAN --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    Keterangan
                </label>

                <textarea
                    name="description"
                    rows="3"
                    placeholder="Masukkan keterangan ringkas event..."
                    class="w-full border border-gray-300 rounded-xl px-3 py-2.5 resize-none focus:outline-none focus:ring-2 focus:ring-gray-300"
                >{{ old('description') }}</textarea>

                @error('description')

                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- THEME + STATUS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">

                {{-- THEME --}}
                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Theme Event *
                    </label>

                    <select
                        name="theme"
                        required
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >

                        <option
                            value="melaka_classic"
                            {{ old('theme', 'melaka_classic') === 'melaka_classic' ? 'selected' : '' }}
                        >
                            Melaka Classic
                        </option>

                        <option
                            value="modern_dark"
                            {{ old('theme') === 'modern_dark' ? 'selected' : '' }}
                        >
                            Modern Dark
                        </option>

                        <option
                            value="clean_light"
                            {{ old('theme') === 'clean_light' ? 'selected' : '' }}
                        >
                            Clean Light
                        </option>

                    </select>

                    @error('theme')

                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- STATUS --}}
                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Status Event
                    </label>

                    <label
                        class="h-[46px] flex items-center gap-3 border border-gray-300 rounded-xl px-4 bg-gray-50 cursor-pointer"
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
                                Aktifkan Event
                            </div>

                            <div class="text-[11px] text-gray-500">
                                Benarkan register, display & signing.
                            </div>

                        </div>

                    </label>

                </div>

            </div>


            {{-- ACTION --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-1">

                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-800"
                >
                    Simpan Event
                </button>

                <a
                    href="{{ route('admin.events.index') }}"
                    class="flex-1 px-4 py-2.5 rounded-xl border bg-white text-center font-semibold hover:bg-gray-50"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection