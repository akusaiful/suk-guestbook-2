<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    >

    <title>Sign Device - MELAKA DIGITAL GUESTBOOK</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            width: 100%;
            min-height: 100%;
        }

        body {
            background:
                linear-gradient(
                    135deg,
                    #111827 0%,
                    #1f2937 55%,
                    #3f171d 100%
                );

            color: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }

        .device-page {
            min-height: 100vh;
            padding: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .device-shell {
            width: 100%;
            max-width: 1180px;
        }

        .device-card {
            width: 100%;

            border-radius: 24px;

            border:
                1px solid
                rgba(255, 255, 255, 0.16);

            background:
                linear-gradient(
                    135deg,
                    rgba(55, 65, 81, 0.96),
                    rgba(73, 49, 56, 0.96)
                );

            box-shadow:
                0 25px 60px
                rgba(0, 0, 0, 0.28);

            padding: 24px;
        }

        .brand {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand-title {
            color: #fca5a5;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.22em;
        }

        .brand-subtitle {
            margin-top: 6px;
            color: #d1d5db;
            font-size: 12px;
        }

        .landscape-grid {
            display: grid;
            grid-template-columns:
                minmax(280px, 0.85fr)
                minmax(420px, 1.45fr);

            gap: 24px;
            align-items: stretch;
        }

        .info-panel,
        .sign-panel {
            border:
                1px solid
                rgba(255, 255, 255, 0.10);

            border-radius: 18px;

            background:
                rgba(17, 24, 39, 0.18);

            padding: 22px;
        }

        .event-label {
            color: #d1d5db;
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .event-name {
            margin-top: 8px;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.25;
        }

        .event-location {
            margin-top: 7px;
            color: #d1d5db;
            font-size: 14px;
        }

        .divider {
            margin: 22px 0;
            border: 0;
            border-top:
                1px solid
                rgba(255, 255, 255, 0.14);
        }

        .signer {
            text-align: center;
        }

        .avatar {
            width: 92px;
            height: 92px;
            margin: 0 auto;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid
                rgba(255, 255, 255, 0.18);

            background: #59616d;

            color: #fca5a5;
            font-size: 34px;
            font-weight: 900;
        }

        .signer-name {
            margin-top: 18px;
            font-size: 28px;
            font-weight: 900;
            line-height: 1.2;
        }

        .signer-meta {
            margin-top: 7px;
            color: #d1d5db;
            font-size: 15px;
        }

        .sign-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .instruction {
            text-align: center;

            color: #fca5a5;
            font-size: 17px;
            font-weight: 800;

            margin-bottom: 12px;
        }

        .canvas-wrap {
            width: 100%;
        }

        #signature-pad {
            display: block;

            width: 100%;
            height: 340px;

            background: #ffffff;

            border:
                2px dashed
                #9ca3af;

            border-radius: 16px;

            touch-action: none;
            cursor: crosshair;
        }

        .autosave-status {
            min-height: 24px;

            margin-top: 12px;

            text-align: center;

            color: #fca5a5;

            font-size: 14px;
            font-weight: 700;
        }

        .actions {
            margin-top: 10px;
        }

        .clear-button {
            width: 100%;

            border: 1px solid #ef4444;
            border-radius: 12px;

            background: #dc2626;
            color: #ffffff;

            padding: 13px;

            font-size: 15px;
            font-weight: 800;

            cursor: pointer;

            transition: 0.2s ease;
        }

        .clear-button:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        .clear-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .autosave-info {
            margin-top: 12px;

            text-align: center;

            color: #d1d5db;

            font-size: 12px;
            line-height: 1.5;
        }

        .waiting {
            text-align: center;
            padding: 50px 20px;
        }

        .waiting-icon {
            font-size: 54px;
        }

        .waiting-title {
            margin-top: 18px;
            font-size: 25px;
            font-weight: 900;
        }

        .waiting-text {
            margin-top: 10px;
            color: #d1d5db;
            font-size: 14px;
            line-height: 1.6;
        }

        .success-message,
        .error-message {
            margin-bottom: 16px;
            border-radius: 12px;
            padding: 11px 14px;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
        }

        .success-message {
            border:
                1px solid
                rgba(134, 239, 172, 0.35);

            background:
                rgba(22, 163, 74, 0.18);

            color: #bbf7d0;
        }

        .error-message {
            border:
                1px solid
                rgba(252, 165, 165, 0.35);

            background:
                rgba(220, 38, 38, 0.18);

            color: #fecaca;
        }

        @media (max-width: 900px) {
            .landscape-grid {
                grid-template-columns: 1fr;
            }

            .info-panel {
                padding: 18px;
            }

            .signer-name {
                font-size: 24px;
            }

            #signature-pad {
                height: 300px;
            }
        }

        @media (orientation: landscape)
            and (min-width: 900px) {

            .device-page {
                padding: 12px 18px;
            }

            .device-card {
                padding: 18px;
            }

            .brand {
                margin-bottom: 14px;
            }

            .info-panel,
            .sign-panel {
                min-height: 470px;
            }

            #signature-pad {
                height: 300px;
            }

            .signer-name {
                font-size: 26px;
            }

            .avatar {
                width: 82px;
                height: 82px;
            }
        }
    </style>
</head>

<body>

<div class="device-page">

    <div class="device-shell">

        <div class="device-card">


            @if (session('success'))

                <div class="success-message">
                    {{ session('success') }}
                </div>

            @endif


            @if (session('error'))

                <div class="error-message">
                    {{ session('error') }}
                </div>

            @endif


            <div class="brand">

                <div class="brand-title">
                    MELAKA DIGITAL GUESTBOOK
                </div>

                <div class="brand-subtitle">
                    Smart Visitor Registration & Digital Signature
                </div>

            </div>


            @if ($session)

                <div class="landscape-grid">

                    {{-- LEFT INFO --}}
                    <div class="info-panel">

                        <div class="event-label">
                            Event
                        </div>

                        <div class="event-name">
                            {{ $session->event?->name ?? '-' }}
                        </div>

                        @if ($session->event?->location)

                            <div class="event-location">
                                {{ $session->event->location }}
                            </div>

                        @endif


                        <hr class="divider">


                        <div class="signer">

                            <div class="avatar">

                                {{
                                    strtoupper(
                                        substr(
                                            $session->signer?->name ?? '?',
                                            0,
                                            1
                                        )
                                    )
                                }}

                            </div>


                            <div class="signer-name">
                                {{ $session->signer?->name ?? '-' }}
                            </div>


                            @if ($session->signer?->position)

                                <div class="signer-meta">
                                    {{ $session->signer->position }}
                                </div>

                            @endif


                            @if ($session->signer?->organization)

                                <div class="signer-meta">
                                    {{ $session->signer->organization }}
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- RIGHT SIGNATURE --}}
                    <div class="sign-panel">

                        <div class="instruction">
                            Sila turunkan tandatangan
                        </div>


                        <form
                            id="signature-form"
                            action="{{ route('sign.submit', $session) }}"
                            method="POST"
                        >

                            @csrf


                            <input
                                type="hidden"
                                name="signature"
                                id="signature-data"
                            >


                            <div class="canvas-wrap">

                                <canvas
                                    id="signature-pad"
                                ></canvas>

                            </div>


                            <div
                                id="autosave-status"
                                class="autosave-status"
                            >
                                Tandatangan akan disimpan automatik selepas anda selesai menulis.
                            </div>


                            <div class="actions">

                                <button
                                    type="button"
                                    id="clear-button"
                                    class="clear-button"
                                >
                                    Padam Tandatangan
                                </button>

                            </div>


                            <div class="autosave-info">
                                Sistem akan menyimpan secara automatik selepas 5 saat tanpa pergerakan.
                            </div>

                        </form>

                    </div>

                </div>


            @else

                <div class="waiting">

                    <div class="waiting-icon">
                        ⏳
                    </div>

                    <div class="waiting-title">
                        Menunggu Penandatangan
                    </div>

                    <div class="waiting-text">
                        Tiada sesi signing aktif sekarang.
                        <br>
                        Sila tunggu admin memilih penandatangan.
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>


@if ($session)

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const canvas =
                document.getElementById(
                    'signature-pad'
                );

            const ctx =
                canvas.getContext('2d');

            const form =
                document.getElementById(
                    'signature-form'
                );

            const signatureInput =
                document.getElementById(
                    'signature-data'
                );

            const clearButton =
                document.getElementById(
                    'clear-button'
                );

            const statusText =
                document.getElementById(
                    'autosave-status'
                );


            let drawing = false;
            let hasSignature = false;

            let autoSaveTimer = null;
            let countdownTimer = null;

            let countdown = 5;
            let submitting = false;


            function resizeCanvas() {

                const rect =
                    canvas.getBoundingClientRect();

                const ratio =
                    Math.max(
                        window.devicePixelRatio || 1,
                        1
                    );


                const existingImage =
                    hasSignature
                        ? canvas.toDataURL()
                        : null;


                canvas.width =
                    rect.width * ratio;

                canvas.height =
                    rect.height * ratio;


                ctx.setTransform(
                    ratio,
                    0,
                    0,
                    ratio,
                    0,
                    0
                );


                ctx.lineWidth = 3;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#111827';


                if (existingImage) {

                    const image =
                        new Image();

                    image.onload =
                        function () {

                            ctx.drawImage(
                                image,
                                0,
                                0,
                                rect.width,
                                rect.height
                            );
                        };

                    image.src =
                        existingImage;
                }
            }


            resizeCanvas();


            function getPosition(event) {

                const rect =
                    canvas.getBoundingClientRect();


                if (event.touches?.length) {

                    return {
                        x:
                            event.touches[0].clientX -
                            rect.left,

                        y:
                            event.touches[0].clientY -
                            rect.top,
                    };
                }


                return {
                    x:
                        event.clientX -
                        rect.left,

                    y:
                        event.clientY -
                        rect.top,
                };
            }


            function cancelAutoSave() {

                if (autoSaveTimer) {

                    clearTimeout(
                        autoSaveTimer
                    );

                    autoSaveTimer = null;
                }


                if (countdownTimer) {

                    clearInterval(
                        countdownTimer
                    );

                    countdownTimer = null;
                }


                countdown = 5;
            }


            function startDrawing(event) {

                if (submitting) {
                    return;
                }


                event.preventDefault();

                cancelAutoSave();


                drawing = true;
                hasSignature = true;


                statusText.textContent =
                    'Sedang menulis tandatangan...';


                const position =
                    getPosition(event);


                ctx.beginPath();

                ctx.moveTo(
                    position.x,
                    position.y
                );
            }


            function draw(event) {

                if (
                    !drawing ||
                    submitting
                ) {
                    return;
                }


                event.preventDefault();


                const position =
                    getPosition(event);


                ctx.lineTo(
                    position.x,
                    position.y
                );

                ctx.stroke();
            }


            function stopDrawing(event) {

                if (!drawing) {
                    return;
                }


                if (event) {
                    event.preventDefault();
                }


                drawing = false;

                ctx.closePath();


                if (hasSignature) {
                    startAutoSave();
                }
            }


            function startAutoSave() {

                cancelAutoSave();

                countdown = 5;

                updateCountdownText();


                countdownTimer =
                    setInterval(
                        function () {

                            countdown--;


                            if (countdown > 0) {

                                updateCountdownText();

                            } else {

                                clearInterval(
                                    countdownTimer
                                );

                                countdownTimer = null;
                            }

                        },
                        1000
                    );


                autoSaveTimer =
                    setTimeout(
                        function () {

                            submitSignature();

                        },
                        5000
                    );
            }


            function updateCountdownText() {

                statusText.textContent =
                    'Tandatangan akan disimpan automatik dalam ' +
                    countdown +
                    ' saat...';
            }


            function submitSignature() {

                if (
                    !hasSignature ||
                    submitting
                ) {
                    return;
                }


                submitting = true;

                cancelAutoSave();


                statusText.textContent =
                    'Sedang menyimpan tandatangan...';


                clearButton.disabled =
                    true;

                clearButton.style.opacity =
                    '0.5';


                signatureInput.value =
                    canvas.toDataURL(
                        'image/png'
                    );


                form.submit();
            }


            function clearCanvas(
                message =
                    'Tandatangan dipadam. Sila tandatangan semula.'
            ) {

                cancelAutoSave();


                ctx.clearRect(
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );


                hasSignature = false;
                drawing = false;


                statusText.textContent =
                    message;
            }


            clearButton.addEventListener(
                'click',
                function () {

                    if (submitting) {
                        return;
                    }

                    clearCanvas();
                }
            );


            canvas.addEventListener(
                'mousedown',
                startDrawing
            );

            canvas.addEventListener(
                'mousemove',
                draw
            );

            canvas.addEventListener(
                'mouseup',
                stopDrawing
            );

            canvas.addEventListener(
                'mouseleave',
                function (event) {

                    if (drawing) {
                        stopDrawing(event);
                    }

                }
            );


            canvas.addEventListener(
                'touchstart',
                startDrawing,
                {
                    passive: false
                }
            );

            canvas.addEventListener(
                'touchmove',
                draw,
                {
                    passive: false
                }
            );

            canvas.addEventListener(
                'touchend',
                stopDrawing,
                {
                    passive: false
                }
            );


            window.addEventListener(
                'resize',
                function () {

                    if (!drawing) {
                        resizeCanvas();
                    }

                }
            );

        }
    );
</script>

@endif


<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            if (!window.Echo) {

                console.error(
                    'Laravel Echo belum tersedia.'
                );

                return;
            }


            const signingChannel =
                window.Echo.channel(
                    'signing.device'
                );


            signingChannel.listen(
                '.SignerRequested',
                function () {

                    window.location.reload();

                }
            );


            signingChannel.listen(
                '.SigningCancelled',
                function (data) {

                    @if ($session)

                        const currentSessionId =
                            {{ $session->id }};


                        if (
                            data.session_id &&
                            Number(data.session_id) !==
                            Number(currentSessionId)
                        ) {
                            return;
                        }

                    @endif


                    window.location.reload();

                }
            );


            signingChannel.listen(
                '.SignatureClearRequested',
                function (data) {

                    @if ($session)

                        const currentEventId =
                            {{ $session->event_id }};


                        if (
                            data.event_id &&
                            Number(data.event_id) !==
                            Number(currentEventId)
                        ) {
                            return;
                        }


                        const canvas =
                            document.getElementById(
                                'signature-pad'
                            );

                        const statusText =
                            document.getElementById(
                                'autosave-status'
                            );


                        if (!canvas) {
                            return;
                        }


                        const ctx =
                            canvas.getContext('2d');


                        ctx.clearRect(
                            0,
                            0,
                            canvas.width,
                            canvas.height
                        );


                        statusText.textContent =
                            'Tandatangan dipadam oleh admin. Sila tandatangan semula.';


                        setTimeout(
                            function () {

                                window.location.reload();

                            },
                            400
                        );

                    @endif

                }
            );

        }
    );
</script>

</body>

</html>