@php
    $highlightComments = [];

    foreach ($latestComments as $comment) {
        $highlightComments[] = [
            'comment' => $comment->comment,
            'name' => $comment->name,
            'organization' => $comment->organization,
            'rating' => (int) ($comment->rating ?? 0),
        ];
    }

    $registrationUrl = route('guest.register', $event);
@endphp

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $event->name }} - Melaka Digital Guestbook
    </title>

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
            font-family: Arial, Helvetica, sans-serif;

            color: #ffffff;

            overflow-x: hidden;

            background:
                linear-gradient(
                    90deg,
                    rgba(2, 12, 26, 0.18) 0%,
                    rgba(4, 18, 34, 0.13) 48%,
                    rgba(70, 17, 26, 0.18) 100%
                ),
                url('/images/themes/melaka-showcase-bg.png')
                center center / cover
                no-repeat
                fixed;
        }

        body::before {
            content: "";

            position: fixed;
            inset: 0;

            pointer-events: none;

            background:
                linear-gradient(
                    180deg,
                    rgba(0, 0, 0, 0.03),
                    rgba(0, 0, 0, 0.10)
                );

            z-index: -1;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .page {
            min-height: 100vh;

            padding:
                12px 18px 20px;
        }

        .shell {
            width: 100%;

            max-width: 1580px;

            margin: 0 auto;
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .header {
            position: relative;

            min-height: 110px;

            text-align: center;

            margin-bottom: 10px;
        }

        .brand-row {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 14px;
        }

        .line {
            width: 78px;
            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #f3c86a
                );
        }

        .line.right {
            background:
                linear-gradient(
                    90deg,
                    #f3c86a,
                    transparent
                );
        }

        .brand {
            color: #f6ce72;

            font-size: 11px;

            font-weight: 900;

            letter-spacing: 0.30em;

            text-transform: uppercase;

            text-shadow:
                0 2px 8px
                rgba(0, 0, 0, 0.55);
        }

        .event-name {
            margin-top: 8px;

            font-family:
                Georgia,
                'Times New Roman',
                serif;

            font-size: 38px;

            font-weight: 700;

            line-height: 1.05;

            text-shadow:
                0 4px 18px
                rgba(0, 0, 0, 0.62);
        }

        .location {
            margin-top: 8px;

            font-size: 13px;

            color: #ffffff;

            text-shadow:
                0 2px 8px
                rgba(0, 0, 0, 0.65);
        }


        /* =====================================================
           QR TOP RIGHT
        ====================================================== */

        .header-qr {
            position: absolute;

            top: 0;
            right: 0;

            display: flex;
            align-items: center;

            gap: 9px;

            padding: 8px 10px;

            border-radius: 14px;

            background:
                rgba(67, 24, 53, 0.73);

            border:
                1px solid
                rgba(255, 255, 255, 0.20);

            backdrop-filter:
                blur(8px);

            box-shadow:
                0 12px 28px
                rgba(0, 0, 0, 0.20);
        }

        .header-qr-box {
            width: 70px;
            height: 70px;

            padding: 5px;

            border-radius: 8px;

            background: #ffffff;
        }

        .header-qr-box img {
            display: block;

            width: 100%;
            height: 100%;
        }

        .header-qr-text {
            text-align: left;
        }

        .header-qr-title {
            font-family:
                Georgia,
                'Times New Roman',
                serif;

            font-size: 14px;

            font-weight: 700;
        }

        .header-qr-subtitle {
            max-width: 125px;

            margin-top: 3px;

            color: #e5e7eb;

            font-size: 7px;

            line-height: 1.4;
        }

        .header-qr-label {
            margin-top: 5px;

            color: #f4c76d;

            font-size: 7px;

            font-weight: 900;

            letter-spacing: 0.08em;

            text-transform: uppercase;
        }


        /* =====================================================
           STATISTICS
        ====================================================== */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 12px;

            max-width: 1380px;

            margin:
                0 auto 14px;
        }

        .stat {
            min-height: 94px;

            display: flex;

            align-items: center;

            gap: 14px;

            padding: 13px 16px;

            border-radius: 17px;

            border:
                1px solid
                rgba(255, 255, 255, 0.20);

            box-shadow:
                0 16px 36px
                rgba(0, 0, 0, 0.20);

            backdrop-filter:
                blur(8px);
        }

        .stat.blue {
            background:
                linear-gradient(
                    135deg,
                    rgba(4, 57, 99, 0.74),
                    rgba(3, 31, 55, 0.63)
                );
        }

        .stat.pink {
            background:
                linear-gradient(
                    135deg,
                    rgba(99, 30, 63, 0.75),
                    rgba(51, 23, 43, 0.64)
                );
        }

        .stat.gold {
            background:
                linear-gradient(
                    135deg,
                    rgba(103, 75, 38, 0.74),
                    rgba(53, 39, 28, 0.64)
                );
        }

        .stat.red {
            background:
                linear-gradient(
                    135deg,
                    rgba(125, 28, 48, 0.77),
                    rgba(68, 21, 34, 0.66)
                );
        }

        .stat-icon {
            width: 54px;
            height: 54px;

            flex: 0 0 54px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-size: 25px;

            background:
                rgba(255, 255, 255, 0.09);

            border:
                1px solid
                rgba(255, 255, 255, 0.15);
        }

        .stat-label {
            color: #f3f4f6;

            font-size: 9px;

            font-weight: 900;

            letter-spacing: 0.07em;

            text-transform: uppercase;
        }

        .stat-value {
            margin-top: 5px;

            font-size: 31px;

            line-height: 1;

            font-weight: 900;
        }

        .stars {
            margin-top: 5px;

            color: #fbbf24;

            font-size: 12px;

            letter-spacing: 2px;
        }


        /* =====================================================
           MAIN PANELS
        ====================================================== */

        .content-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.15fr)
                minmax(0, 0.78fr);

            gap: 28px;

            max-width: 1240px;

            margin: 0 auto;

            align-items: start;
        }

        .panel {
            overflow: hidden;

            border-radius: 20px;

            border:
                1px solid
                rgba(255, 255, 255, 0.17);

            backdrop-filter:
                blur(7px);

            box-shadow:
                0 20px 46px
                rgba(0, 0, 0, 0.25);
        }

        .left-panel {
            background:
                linear-gradient(
                    145deg,
                    rgba(2, 23, 43, 0.69),
                    rgba(4, 17, 31, 0.61)
                );
        }

        .right-panel {
            background:
                linear-gradient(
                    145deg,
                    rgba(86, 20, 43, 0.71),
                    rgba(63, 17, 31, 0.61)
                );
        }

        .panel-head {
            min-height: 62px;

            display: flex;

            align-items: center;
            justify-content: space-between;

            padding:
                10px 14px;

            border-bottom:
                1px solid
                rgba(255, 255, 255, 0.11);
        }

        .panel-title-wrap {
            display: flex;

            align-items: center;

            gap: 11px;
        }

        .panel-icon {
            width: 38px;
            height: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-size: 16px;

            background:
                rgba(255, 255, 255, 0.07);

            border:
                1px solid
                rgba(255, 255, 255, 0.13);
        }

        .panel-title {
            font-family:
                Georgia,
                'Times New Roman',
                serif;

            font-size: 21px;

            font-weight: 700;
        }

        .panel-subtitle {
            margin-top: 2px;

            color: #d1d5db;

            font-size: 8px;
        }

        .badge {
            padding:
                5px 10px;

            border-radius: 999px;

            border:
                1px solid
                rgba(248, 113, 113, 0.55);

            background:
                rgba(185, 28, 28, 0.21);

            color: #fecaca;

            font-size: 7px;

            font-weight: 900;
        }


        /* =====================================================
           LATEST COMMENTS
        ====================================================== */

        .latest-list {
            display: grid;

            gap: 7px;

            padding: 10px;
        }

        .latest-card {
            min-height: 62px;

            display: grid;

            grid-template-columns:
                38px
                minmax(0, 1fr)
                auto;

            align-items: center;

            gap: 9px;

            padding:
                8px 10px;

            border-radius: 12px;

            border:
                1px solid
                rgba(255, 255, 255, 0.11);

            background:
                linear-gradient(
                    135deg,
                    rgba(255, 255, 255, 0.055),
                    rgba(255, 255, 255, 0.018)
                );
        }

        .avatar {
            width: 36px;
            height: 36px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #436482,
                    #263c55
                );

            border:
                1px solid
                rgba(255, 255, 255, 0.13);

            font-size: 10px;

            font-weight: 900;
        }

        .comment-text {
            font-size: 10px;

            font-weight: 700;

            line-height: 1.3;
        }

        .comment-name {
            margin-top: 4px;

            color: #fca5a5;

            font-size: 6px;

            font-weight: 900;

            text-transform: uppercase;
        }

        .comment-org {
            margin-top: 1px;

            color: #d1d5db;

            font-size: 6px;
        }

        .comment-rating {
            color: #fbbf24;

            font-size: 8px;

            letter-spacing: 1px;

            white-space: nowrap;
        }


        /* =====================================================
           RANDOM COMMENTS
        ====================================================== */

        .right-body {
            padding: 10px;
        }

        .random-list {
            display: grid;

            gap: 8px;
        }

        .random-card {
            min-height: 88px;

            padding:
                10px 12px;

            border-radius: 13px;

            border:
                1px solid
                rgba(248, 113, 113, 0.18);

            background:
                linear-gradient(
                    135deg,
                    rgba(255, 255, 255, 0.055),
                    rgba(121, 28, 43, 0.11)
                );

            opacity: 1;

            transform:
                translateX(0);

            transition:
                opacity 0.55s ease,
                transform 0.55s ease;
        }

        .random-card.hide {
            opacity: 0;

            transform:
                translateX(22px);
        }

        .random-top {
            display: flex;

            justify-content: space-between;

            gap: 10px;
        }

        .quote {
            color: #f87171;

            font-family: Georgia, serif;

            font-size: 22px;

            line-height: 0.8;
        }

        .random-rating {
            color: #fbbf24;

            font-size: 9px;

            letter-spacing: 1px;
        }

        .random-text {
            margin-top: 5px;

            font-family:
                Georgia,
                'Times New Roman',
                serif;

            font-size: 14px;

            font-weight: 700;

            line-height: 1.3;
        }

        .random-name {
            margin-top: 7px;

            color: #fca5a5;

            font-size: 7px;

            font-weight: 900;

            text-transform: uppercase;
        }

        .random-org {
            margin-top: 2px;

            color: #d1d5db;

            font-size: 6px;
        }

        .auto-footer {
            margin-top: 9px;

            text-align: center;

            color:
                rgba(255, 255, 255, 0.50);

            font-size: 7px;

            letter-spacing: 0.15em;

            text-transform: uppercase;
        }


        /* =====================================================
           TABLET
        ====================================================== */

        @media (max-width: 1200px) {

            .event-name {
                font-size: 32px;
            }

            .content-grid {
                max-width: 1100px;

                grid-template-columns:
                    1.1fr
                    0.82fr;
            }

            .header-qr-box {
                width: 62px;
                height: 62px;
            }
        }

        @media (max-width: 900px) {

            .header {
                padding-top: 95px;
            }

            .header-qr {
                right: 50%;

                transform:
                    translateX(50%);
            }

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .content-grid {
                grid-template-columns: 1fr;

                gap: 12px;
            }

            .latest-card {
                grid-template-columns:
                    38px
                    1fr;
            }

            .comment-rating {
                grid-column: 2;
            }
        }
    </style>

</head>

<body>

<div class="page">

    <div class="shell">


        {{-- HEADER --}}
        <header class="header">

            <div class="brand-row">

                <div class="line"></div>

                <div class="brand">
                    Melaka Digital Guestbook
                </div>

                <div class="line right"></div>

            </div>


            <div class="event-name">
                {{ $event->name }}
            </div>


            <div class="location">
                📍 {{ $event->location ?? 'Melaka' }}
            </div>


            <div class="header-qr">

                <div class="header-qr-box">

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($registrationUrl) }}"
                        alt="QR Event"
                    >

                </div>


                <div class="header-qr-text">

                    <div class="header-qr-title">
                        Daftar Kehadiran
                    </div>

                    <div class="header-qr-subtitle">
                        Imbas QR untuk daftar dan beri maklum balas.
                    </div>

                    <div class="header-qr-label">
                        Scan Me
                    </div>

                </div>

            </div>

        </header>


        {{-- STATS --}}
        <section class="stats">

            <div class="stat blue">

                <div class="stat-icon">
                    👥
                </div>

                <div>

                    <div class="stat-label">
                        Jumlah Pelawat
                    </div>

                    <div class="stat-value">
                        {{ $visitorCount }}
                    </div>

                </div>

            </div>


            <div class="stat pink">

                <div class="stat-icon">
                    💬
                </div>

                <div>

                    <div class="stat-label">
                        Jumlah Komen
                    </div>

                    <div class="stat-value">
                        {{ $commentCount }}
                    </div>

                </div>

            </div>


            <div class="stat gold">

                <div class="stat-icon">
                    ✍️
                </div>

                <div>

                    <div class="stat-label">
                        Jumlah Tandatangan
                    </div>

                    <div class="stat-value">
                        {{ $signatureCount }}
                    </div>

                </div>

            </div>


            <div class="stat red">

                <div class="stat-icon">
                    ⭐
                </div>

                <div>

                    <div class="stat-label">
                        Purata Rating
                    </div>

                    <div class="stat-value">
                        {{ number_format($averageRating, 1) }}
                    </div>

                    <div class="stars">

                        @for ($i = 1; $i <= 5; $i++)

                            @if ($i <= round($averageRating))
                                ★
                            @else
                                ☆
                            @endif

                        @endfor

                    </div>

                </div>

            </div>

        </section>


        {{-- MAIN --}}
        <section class="content-grid">


            {{-- LEFT --}}
            <div class="panel left-panel">

                <div class="panel-head">

                    <div class="panel-title-wrap">

                        <div class="panel-icon">
                            💬
                        </div>

                        <div>

                            <div class="panel-title">
                                Komen Terkini
                            </div>

                            <div class="panel-subtitle">
                                Pandangan terkini daripada para pengunjung.
                            </div>

                        </div>

                    </div>


                    <div class="badge">
                        ● LIVE
                    </div>

                </div>


                <div class="latest-list">

                    @foreach ($latestComments->take(5) as $comment)

                        @php
                            $parts = preg_split(
                                '/\s+/',
                                trim($comment->name)
                            );

                            $initials = '';

                            foreach (
                                array_slice(
                                    $parts,
                                    0,
                                    2
                                )
                                as $part
                            ) {

                                $initials .= strtoupper(
                                    mb_substr(
                                        $part,
                                        0,
                                        1
                                    )
                                );
                            }
                        @endphp


                        <div class="latest-card">

                            <div class="avatar">
                                {{ $initials ?: '?' }}
                            </div>


                            <div>

                                <div class="comment-text">

                                    “{{
                                        \Illuminate\Support\Str::limit(
                                            $comment->comment,
                                            85
                                        )
                                    }}”

                                </div>


                                <div class="comment-name">
                                    — {{ $comment->name }}
                                </div>


                                @if ($comment->organization)

                                    <div class="comment-org">
                                        {{ $comment->organization }}
                                    </div>

                                @endif

                            </div>


                            <div class="comment-rating">

                                @for ($i = 1; $i <= 5; $i++)

                                    @if ($i <= (int) $comment->rating)
                                        ★
                                    @else
                                        ☆
                                    @endif

                                @endfor

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="panel right-panel">

                <div class="panel-head">

                    <div class="panel-title-wrap">

                        <div class="panel-icon">
                            ⭐
                        </div>

                        <div>

                            <div class="panel-title">
                                Sorotan Komen
                            </div>

                            <div class="panel-subtitle">
                                Pilihan komen pengunjung secara automatik.
                            </div>

                        </div>

                    </div>


                    <div class="badge">
                        ↻ AUTO
                    </div>

                </div>


                <div class="right-body">

                    <div class="random-list">

                        @for ($i = 0; $i < 3; $i++)

                            <div
                                class="random-card"
                                data-random-card="{{ $i }}"
                            >

                                <div class="random-top">

                                    <div class="quote">
                                        “
                                    </div>

                                    <div
                                        class="random-rating"
                                        data-random-rating="{{ $i }}"
                                    ></div>

                                </div>


                                <div
                                    class="random-text"
                                    data-random-text="{{ $i }}"
                                ></div>


                                <div
                                    class="random-name"
                                    data-random-name="{{ $i }}"
                                ></div>


                                <div
                                    class="random-org"
                                    data-random-org="{{ $i }}"
                                ></div>

                            </div>

                        @endfor

                    </div>


                    <div class="auto-footer">
                        Sorotan komen bertukar secara automatik
                    </div>

                </div>

            </div>

        </section>

    </div>

</div>


@if (count($highlightComments) > 0)

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const comments =
                {!! json_encode(
                    $highlightComments,
                    JSON_UNESCAPED_UNICODE |
                    JSON_UNESCAPED_SLASHES
                ) !!};


            const cards =
                document.querySelectorAll(
                    '[data-random-card]'
                );


            function stars(rating) {

                let output = '';

                const value =
                    Number(
                        rating || 0
                    );


                for (
                    let i = 1;
                    i <= 5;
                    i++
                ) {

                    output +=
                        i <= value
                            ? '★'
                            : '☆';
                }


                return output;
            }


            function shuffle(array) {

                const result =
                    [...array];


                for (
                    let i =
                        result.length - 1;

                    i > 0;

                    i--
                ) {

                    const j =
                        Math.floor(
                            Math.random() *
                            (i + 1)
                        );


                    [
                        result[i],
                        result[j]
                    ] =
                    [
                        result[j],
                        result[i]
                    ];
                }


                return result;
            }


            function updateRandomComments() {

                const selected =
                    shuffle(comments)
                        .slice(
                            0,
                            Math.min(
                                3,
                                comments.length
                            )
                        );


                cards.forEach(
                    function (
                        card,
                        index
                    ) {

                        if (!selected.length) {
                            return;
                        }


                        card.classList.add(
                            'hide'
                        );


                        setTimeout(
                            function () {

                                const item =
                                    selected[
                                        index %
                                        selected.length
                                    ];


                                card
                                    .querySelector(
                                        '[data-random-text]'
                                    )
                                    .textContent =
                                        '“' +
                                        item.comment +
                                        '”';


                                card
                                    .querySelector(
                                        '[data-random-name]'
                                    )
                                    .textContent =
                                        '— ' +
                                        item.name;


                                card
                                    .querySelector(
                                        '[data-random-org]'
                                    )
                                    .textContent =
                                        item.organization || '';


                                card
                                    .querySelector(
                                        '[data-random-rating]'
                                    )
                                    .textContent =
                                        stars(
                                            item.rating
                                        );


                                card.classList.remove(
                                    'hide'
                                );

                            },
                            450 +
                            (
                                index * 170
                            )
                        );

                    }
                );
            }


            updateRandomComments();


            setInterval(
                updateRandomComments,
                7500
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
                return;
            }


            window.Echo
                .channel(
                    'display.event.{{ $event->id }}'
                )
                .listen(
                    '.DisplayUpdated',
                    function () {

                        window.location.reload();

                    }
                );

        }
    );
</script>

</body>

</html>