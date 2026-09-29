<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>QR Registration - {{ $event->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top right, rgba(185, 28, 28, 0.25), transparent 35%),
                linear-gradient(135deg, #111827 0%, #1f2937 50%, #450a0a 100%);
            color: #ffffff;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .card {
            width: 100%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            padding: 35px;
            text-align: center;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }

        .brand {
            color: #fca5a5;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .event-name {
            margin-top: 12px;
            font-size: 34px;
            font-weight: 800;
            line-height: 1.2;
        }

        .event-location {
            margin-top: 10px;
            color: #d1d5db;
            font-size: 16px;
        }

        .qr-wrapper {
            margin: 30px auto 20px;
            width: 320px;
            max-width: 100%;
            background: #ffffff;
            padding: 20px;
            border-radius: 20px;
        }

        .qr-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

        .instruction {
            margin-top: 20px;
            font-size: 18px;
            font-weight: 700;
        }

        .subtext {
            margin-top: 8px;
            color: #d1d5db;
            font-size: 14px;
        }

        .url-box {
            margin-top: 20px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.25);
            word-break: break-all;
            font-size: 13px;
            color: #e5e7eb;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        .button-red {
            background: #b91c1c;
            color: white;
        }

        .button-dark {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.20);
        }

        @media print {
            body {
                background: white;
                color: black;
            }

            .page-wrapper {
                padding: 0;
            }

            .card {
                background: white;
                color: black;
                border: none;
                box-shadow: none;
            }

            .brand,
            .event-location,
            .subtext,
            .url-box {
                color: #333333;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrapper">

        <div class="card">

            <div class="brand">
                Melaka Digital Guestbook
            </div>

            <div class="event-name">
                {{ $event->name }}
            </div>

            @if ($event->location)
                <div class="event-location">
                    {{ $event->location }}
                </div>
            @endif

            <div class="qr-wrapper">
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($registrationUrl) }}"
                    alt="QR Registration">
            </div>

            <div class="instruction">
                Imbas QR untuk daftar sebagai tetamu
            </div>

            <div class="subtext">
                Gunakan telefon untuk membuka borang pendaftaran event ini.
            </div>

            <div class="url-box">
                {{ $registrationUrl }}
            </div>

            <div class="actions">

                <a
                    href="{{ route('guest.register', $event) }}"
                    target="_blank"
                    class="button button-red">
                    Buka Borang Daftar
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="button button-dark">
                    Cetak QR
                </button>

                <a
                    href="{{ route('admin.events.index') }}"
                    class="button button-dark">
                    Kembali
                </a>

            </div>

        </div>

    </div>

</body>

</html>