<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $event->name }} - Melaka Digital Guestbook</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $theme = $event->theme ?? 'melaka_classic';
    @endphp

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
        }

        .page-wrapper {
            min-height: 100vh;
            padding: 32px 16px;
        }

        .container {
            max-width: 760px;
            margin: 0 auto;
        }

        .card {
            border-radius: 22px;
            padding: 28px;
            border: 1px solid;
        }

        .brand {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .event-name {
            margin-top: 10px;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.2;
        }

        .event-meta {
            margin-top: 10px;
            font-size: 14px;
        }

        .success-box {
            margin: 22px 0;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid;
            outline: none;
            font-size: 15px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 130px;
        }

        .error-text {
            margin-top: 6px;
            font-size: 13px;
            color: #dc2626;
        }

        .rating-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .rating-option input {
            display: none;
        }

        .rating-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 58px;
            height: 48px;
            padding: 0 14px;
            border: 1px solid;
            border-radius: 10px;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.2s ease;
        }

        .submit-button {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        /* =========================
           MELAKA CLASSIC
        ========================== */
        body.theme-melaka_classic {
            background:
                radial-gradient(
                    circle at top right,
                    rgba(185, 28, 28, 0.28),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #111827 0%,
                    #1f2937 45%,
                    #450a0a 100%
                );
            color: #ffffff;
        }

        body.theme-melaka_classic .card {
            background: rgba(255, 255, 255, 0.10);
            border-color: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
        }

        body.theme-melaka_classic .brand {
            color: #fca5a5;
        }

        body.theme-melaka_classic .event-meta {
            color: #d1d5db;
        }

        body.theme-melaka_classic .form-control {
            background: rgba(255, 255, 255, 0.96);
            border-color: #d1d5db;
            color: #111827;
        }

        body.theme-melaka_classic .rating-option label {
            background: rgba(255, 255, 255, 0.96);
            border-color: #d1d5db;
            color: #111827;
        }

        body.theme-melaka_classic .rating-option input:checked + label {
            background: #fee2e2;
            border-color: #b91c1c;
            transform: scale(1.05);
        }

        body.theme-melaka_classic .submit-button {
            background: #b91c1c;
            color: #ffffff;
        }

        body.theme-melaka_classic .success-box {
            background: rgba(22, 163, 74, 0.16);
            border-color: rgba(74, 222, 128, 0.45);
            color: #bbf7d0;
        }

        /* =========================
           MODERN DARK
        ========================== */
        body.theme-modern_dark {
            background:
                radial-gradient(
                    circle at top left,
                    rgba(37, 99, 235, 0.24),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #020617 0%,
                    #0f172a 50%,
                    #111827 100%
                );
            color: #ffffff;
        }

        body.theme-modern_dark .card {
            background: rgba(15, 23, 42, 0.88);
            border-color: rgba(96, 165, 250, 0.20);
        }

        body.theme-modern_dark .brand {
            color: #60a5fa;
        }

        body.theme-modern_dark .event-meta {
            color: #cbd5e1;
        }

        body.theme-modern_dark .form-control {
            background: #0f172a;
            border-color: #334155;
            color: #ffffff;
        }

        body.theme-modern_dark .rating-option label {
            background: #0f172a;
            border-color: #334155;
            color: #ffffff;
        }

        body.theme-modern_dark .rating-option input:checked + label {
            background: #1e3a8a;
            border-color: #60a5fa;
            transform: scale(1.05);
        }

        body.theme-modern_dark .submit-button {
            background: #2563eb;
            color: #ffffff;
        }

        body.theme-modern_dark .success-box {
            background: rgba(22, 163, 74, 0.15);
            border-color: rgba(74, 222, 128, 0.35);
            color: #bbf7d0;
        }

        /* =========================
           CLEAN LIGHT
        ========================== */
        body.theme-clean_light {
            background:
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #ffffff 50%,
                    #f1f5f9 100%
                );
            color: #111827;
        }

        body.theme-clean_light .card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        }

        body.theme-clean_light .brand {
            color: #b91c1c;
        }

        body.theme-clean_light .event-meta {
            color: #64748b;
        }

        body.theme-clean_light .form-control {
            background: #ffffff;
            border-color: #cbd5e1;
            color: #111827;
        }

        body.theme-clean_light .rating-option label {
            background: #ffffff;
            border-color: #cbd5e1;
            color: #111827;
        }

        body.theme-clean_light .rating-option input:checked + label {
            background: #fee2e2;
            border-color: #b91c1c;
            transform: scale(1.05);
        }

        body.theme-clean_light .submit-button {
            background: #111827;
            color: #ffffff;
        }

        body.theme-clean_light .success-box {
            background: #dcfce7;
            border-color: #bbf7d0;
            color: #166534;
        }

        @media (max-width: 640px) {
            .page-wrapper {
                padding: 20px 12px;
            }

            .card {
                padding: 20px;
            }

            .event-name {
                font-size: 24px;
            }

            .rating-group {
                gap: 8px;
            }

            .rating-option label {
                min-width: 52px;
                height: 44px;
                padding: 0 10px;
                font-size: 18px;
            }
        }
    </style>
</head>

<body class="theme-{{ $theme }}">

    <div class="page-wrapper">

        <div class="container">

            <div class="card">

                <div>

                    <div class="brand">
                        Melaka Digital Guestbook
                    </div>

                    <div class="event-name">
                        {{ $event->name }}
                    </div>

                    <div class="event-meta">

                        {{ $event->event_date->format('d/m/Y') }}

                        @if ($event->location)
                            • {{ $event->location }}
                        @endif

                    </div>

                </div>


                @if (session('success'))

                    <div class="success-box">
                        {{ session('success') }}
                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('guest.register.store', $event) }}"
                    style="margin-top: 26px;">

                    @csrf


                    <div class="form-group">

                        <label class="form-label">
                            Nama Penuh *
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="form-control">

                        @error('name')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Organisasi / Jabatan
                        </label>

                        <input
                            type="text"
                            name="organization"
                            value="{{ old('organization') }}"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            No. Telefon
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Tujuan / Catatan
                        </label>

                        <input
                            type="text"
                            name="purpose"
                            value="{{ old('purpose') }}"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Rating Event *
                        </label>

                        <div class="rating-group">

                            @for ($i = 1; $i <= 5; $i++)

                                <div class="rating-option">

                                    <input
                                        type="radio"
                                        name="rating"
                                        id="rating-{{ $i }}"
                                        value="{{ $i }}"
                                        {{ old('rating') == $i ? 'checked' : '' }}
                                        required>

                                    <label for="rating-{{ $i }}">
                                        {{ $i }} ⭐
                                    </label>

                                </div>

                            @endfor

                        </div>

                        @error('rating')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Komen / Ucapan *
                        </label>

                        <textarea
                            name="comment"
                            required
                            class="form-control"
                            placeholder="Tuliskan komen atau ucapan anda...">{{ old('comment') }}</textarea>

                        @error('comment')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="submit-button">

                        Hantar Pendaftaran & Komen

                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>