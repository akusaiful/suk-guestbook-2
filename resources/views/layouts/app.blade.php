<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Melaka Digital Guestbook')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <header class="bg-red-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4">

            <h1 class="text-xl font-bold">
                MELAKA DIGITAL GUESTBOOK
            </h1>

            <p class="text-sm text-red-100">
                Smart Visitor Registration & Digital Signature
            </p>

            <!-- LETAK NAV DI SINI -->
            <nav class="mt-4 flex gap-4 text-sm">

                <a href="{{ route('admin.events.index') }}" class="hover:underline">
                    Event
                </a>

                <a href="{{ route('admin.signers.index') }}" class="hover:underline">
                    Penandatangan
                </a>

            </nav>

        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 border border-green-300 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </main>

</body>

</html>
