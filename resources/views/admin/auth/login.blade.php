<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Melaka Digital Guestbook</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(
                    circle at top right,
                    rgba(185, 28, 28, 0.32),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #111827 0%,
                    #1f2937 50%,
                    #450a0a 100%
                );
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 30px;
            color: #ffffff;
        }

        .brand {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #fca5a5;
        }

        .title {
            text-align: center;
            margin-top: 10px;
            font-size: 28px;
            font-weight: 800;
        }

        .subtitle {
            text-align: center;
            margin-top: 6px;
            color: #d1d5db;
            font-size: 14px;
        }

        .form-group {
            margin-top: 20px;
        }

        .label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 700;
        }

        .input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            background: #ffffff;
            color: #111827;
            outline: none;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            font-size: 14px;
            color: #d1d5db;
        }

        .button {
            width: 100%;
            margin-top: 22px;
            border: none;
            border-radius: 11px;
            padding: 13px;
            background: #b91c1c;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .error {
            margin-top: 6px;
            font-size: 13px;
            color: #fecaca;
        }

        .success {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 10px;
            background: rgba(22, 163, 74, 0.16);
            border: 1px solid rgba(74, 222, 128, 0.35);
            color: #bbf7d0;
        }
    </style>
</head>

<body>

    <div class="page">

        <div class="card">

            <div class="brand">
                MELAKA DIGITAL GUESTBOOK
            </div>

            <div class="title">
                Admin Login
            </div>

            <div class="subtitle">
                Sila log masuk untuk mengurus sistem.
            </div>


            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif


            <form method="POST" action="{{ route('admin.login.submit') }}">

                @csrf

                <div class="form-group">

                    <label class="label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="input">

                    @error('email')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label class="label">
                        Kata Laluan
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="input">

                    @error('password')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <label class="remember">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1">

                    Ingat saya

                </label>


                <button
                    type="submit"
                    class="button">

                    Log Masuk

                </button>

            </form>

        </div>

    </div>

</body>

</html>