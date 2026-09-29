@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="mb-6">
            <h2 class="text-2xl font-bold">
                Tambah Event
            </h2>

            <p class="text-gray-500">
                Daftar program atau majlis baru.
            </p>
        </div>

        <form action="{{ route('events.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">

            @csrf

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nama Event *
                </label>

                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300"
                    required>

                @error('name')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Tarikh *
                </label>

                <input type="date" name="event_date" value="{{ old('event_date') }}"
                    class="w-full rounded-lg border-gray-300" required>

            </div>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Lokasi
                </label>

                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full rounded-lg border-gray-300">

            </div>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Penerangan
                </label>

                <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300">{{ old('description') }}</textarea>

            </div>

            <div class="mb-6">

                <label class="flex items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" checked>

                    <span>Event aktif</span>

                </label>

            </div>

            <div class="flex justify-end gap-3">

                <a href="{{ route('events.index') }}" class="rounded-lg border px-5 py-2.5">
                    Batal
                </a>

                <button type="submit" class="rounded-lg bg-red-700 px-5 py-2.5 font-semibold text-white">
                    Simpan Event
                </button>

            </div>

        </form>

    </div>

@endsection
