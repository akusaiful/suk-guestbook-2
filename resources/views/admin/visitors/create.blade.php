@extends('layouts.admin')

@section('title', 'Daftar Pengunjung')

@section('page-title', 'Daftar Pengunjung')

@section('page-subtitle', 'Pendaftaran pengunjung secara manual oleh admin.')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="flex items-center justify-between gap-4 mb-6">

        <div>

            <h2 class="text-xl font-bold">
                Maklumat Pengunjung
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Lengkapkan maklumat di bawah untuk mendaftarkan pengunjung.
            </p>

        </div>


        <a
            href="{{ route('admin.visitors.index') }}"
            class="px-4 py-2 rounded-lg border bg-white text-sm font-semibold hover:bg-gray-50 whitespace-nowrap"
        >
            ← Kembali
        </a>

    </div>


    {{-- VALIDATION ERROR --}}
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
            action="{{ route('admin.visitors.store') }}"
            class="space-y-5"
        >

            @csrf


            {{-- EVENT --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    Event *
                </label>

                <select
                    name="event_id"
                    required
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

                    <option value="">
                        -- Pilih Event --
                    </option>

                    @foreach ($events as $event)

                        <option
                            value="{{ $event->id }}"
                            {{ old('event_id') == $event->id ? 'selected' : '' }}
                        >
                            {{ $event->name }}
                        </option>

                    @endforeach

                </select>

                @error('event_id')

                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- NAMA --}}
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
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

                @error('name')

                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- ORGANISASI --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    Organisasi / Jabatan
                </label>

                <input
                    type="text"
                    name="organization"
                    value="{{ old('organization') }}"
                    placeholder="Contoh: JKMM"
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

            </div>


            {{-- TELEFON --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    No. Telefon
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Contoh: 0123456789"
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

            </div>


            {{-- EMAIL --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Contoh: nama@email.com"
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >

                @error('email')

                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- PURPOSE --}}
            <div>

                <label class="block text-sm font-semibold mb-2">
                    Tujuan / Catatan
                </label>

                <textarea
                    name="purpose"
                    rows="3"
                    placeholder="Masukkan tujuan atau catatan..."
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-gray-300"
                >{{ old('purpose') }}</textarea>

            </div>


            {{-- ACTION --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-2">

                <button
                    type="submit"
                    class="flex-1 px-4 py-3 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-800"
                >
                    Daftar Pengunjung
                </button>

                <a
                    href="{{ route('admin.visitors.index') }}"
                    class="flex-1 px-4 py-3 rounded-xl border bg-white text-center font-semibold hover:bg-gray-50"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection