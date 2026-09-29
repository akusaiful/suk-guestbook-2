<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Admin') - MELAKA DIGITAL GUESTBOOK
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            background: #f3f4f6;
            color: #111827;
        }

        .admin-layout {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;

            display: flex;
            flex-direction: column;

            background:
                linear-gradient(
                    180deg,
                    #111827 0%,
                    #1f2937 68%,
                    #3d171c 100%
                );

            color: #ffffff;
            z-index: 40;
        }

        .sidebar-brand {
            padding: 26px 20px 22px;
            border-bottom:
                1px solid
                rgba(255, 255, 255, 0.10);
        }

        .sidebar-brand-small {
            color: #fca5a5;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.18em;
        }

        .sidebar-brand-title {
            margin-top: 5px;
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
        }

        .sidebar-brand-subtitle {
            margin-top: 8px;
            font-size: 12px;
            color: #9ca3af;
        }

        .sidebar-menu {
            flex: 1;
            padding: 22px 12px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 13px;

            width: 100%;

            padding: 13px 14px;
            margin-bottom: 7px;

            border-radius: 12px;

            color: #d1d5db;
            text-decoration: none;

            font-size: 14px;
            font-weight: 700;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }

        .sidebar-link:hover {
            background:
                rgba(255, 255, 255, 0.08);

            color: #ffffff;
        }

        .sidebar-link.active {
            background: #c91f24;
            color: #ffffff;
        }

        .sidebar-link-icon {
            width: 22px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-user {
            margin: 12px;
            padding: 14px;

            border:
                1px solid
                rgba(255, 255, 255, 0.14);

            border-radius: 16px;

            background:
                rgba(255, 255, 255, 0.05);
        }

        .sidebar-user-name {
            font-size: 14px;
            font-weight: 800;
        }

        .sidebar-user-email {
            margin-top: 5px;
            font-size: 11px;
            color: #d1d5db;
        }

        .logout-button {
            width: 100%;
            margin-top: 14px;

            border: 0;
            border-radius: 10px;

            background: #ef2626;
            color: #ffffff;

            padding: 11px;

            font-size: 13px;
            font-weight: 800;

            cursor: pointer;
        }

        .logout-button:hover {
            background: #dc1f1f;
        }

        .main-area {
            min-height: 100vh;
            width: calc(100% - 250px);
            margin-left: 250px;
        }

        .topbar {
            min-height: 100px;
            display: flex;
            align-items: center;

            background: #ffffff;

            border-bottom:
                1px solid #e5e7eb;
        }

        .topbar-inner {
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;

            padding: 22px 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .topbar-title {
            font-size: 24px;
            font-weight: 900;
            line-height: 1.15;
        }

        .topbar-subtitle {
            margin-top: 6px;
            color: #6b7280;
            font-size: 13px;
        }

        .topbar-user {
            text-align: right;
        }

        .topbar-user-name {
            font-size: 14px;
            font-weight: 800;
        }

        .topbar-user-email {
            margin-top: 5px;
            color: #6b7280;
            font-size: 11px;
        }

        .content-area {
            padding: 28px 30px 40px;
        }

        .content-wrap {
            max-width: 1320px;
            margin: 0 auto;
        }

        .mobile-header {
            display: none;
        }

        .mobile-nav {
            display: none;
        }

        @media (max-width: 900px) {

            .sidebar {
                display: none;
            }

            .main-area {
                width: 100%;
                margin-left: 0;
            }

            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;

                min-height: 68px;

                padding: 12px 18px;

                background:
                    linear-gradient(
                        90deg,
                        #111827,
                        #3d171c
                    );

                color: #ffffff;
            }

            .mobile-header-brand {
                font-weight: 900;
            }

            .mobile-nav {
                display: flex;
                gap: 7px;

                overflow-x: auto;

                padding: 10px 14px;

                background: #ffffff;

                border-bottom:
                    1px solid #e5e7eb;
            }

            .mobile-nav a {
                white-space: nowrap;

                padding: 8px 11px;

                border-radius: 8px;

                background: #f3f4f6;

                color: #111827;

                text-decoration: none;

                font-size: 12px;
                font-weight: 700;
            }

            .mobile-nav a.active {
                background: #c91f24;
                color: #ffffff;
            }

            .topbar {
                min-height: auto;
            }

            .topbar-inner {
                padding: 18px;
            }

            .topbar-user {
                display: none;
            }

            .topbar-title {
                font-size: 21px;
            }

            .content-area {
                padding: 20px 16px 32px;
            }
        }
    </style>
</head>

<body>

<div class="admin-layout">

    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}
    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="sidebar-brand-small">
                MELAKA DIGITAL
            </div>

            <div class="sidebar-brand-title">
                GUESTBOOK
            </div>

            <div class="sidebar-brand-subtitle">
                Admin Control Panel
            </div>

        </div>


        <nav class="sidebar-menu">

            {{-- DASHBOARD --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon">
                    🏠
                </span>

                <span>
                    Dashboard
                </span>
            </a>


            {{-- EVENT --}}
            <a
                href="{{ route('admin.events.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon">
                    🗓️
                </span>

                <span>
                    Event
                </span>
            </a>


            {{-- VISITOR --}}
            <a
                href="{{ route('admin.visitors.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon">
                    👥
                </span>

                <span>
                    Pengunjung
                </span>
            </a>


            {{-- SIGNATURE HISTORY --}}
            <a
                href="{{ route('admin.signatures.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.signatures.*') ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon">
                    ✍️
                </span>

                <span>
                    Sejarah Tandatangan
                </span>
            </a>


            {{-- SIGNERS --}}
            <a
                href="{{ route('admin.signers.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.signers.*') ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon">
                    🖊️
                </span>

                <span>
                    Penandatangan
                </span>
            </a>


            {{-- SIGN DEVICE --}}
            <a
                href="{{ route('sign.device') }}"
                target="_blank"
                class="sidebar-link"
            >
                <span class="sidebar-link-icon">
                    📱
                </span>

                <span>
                    Sign Device
                </span>
            </a>

            {{-- REPORT --}}
            <a
                href="{{ route('admin.reports.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon">
                    📊
                </span>

                <span>
                    Laporan
                </span>
            </a>

        </nav>


        {{-- ADMIN INFO --}}
        <div class="sidebar-user">

            <div class="sidebar-user-name">
                Admin Melaka
            </div>

            <div class="sidebar-user-email">
                admin@melaka.gov.my
            </div>


            <form
                action="{{ route('admin.logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-button"
                >
                    Logout
                </button>

            </form>

        </div>

    </aside>


    {{-- =====================================================
         MOBILE HEADER
    ====================================================== --}}
    <div class="main-area">

        <div class="mobile-header">

            <div class="mobile-header-brand">
                MELAKA DIGITAL GUESTBOOK
            </div>

        </div>


        {{-- MOBILE NAV --}}
        <div class="mobile-nav">

            <a
                href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('admin.events.index') }}"
                class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
            >
                Event
            </a>

            <a
                href="{{ route('admin.visitors.index') }}"
                class="{{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}"
            >
                Pengunjung
            </a>

            <a
                href="{{ route('admin.signatures.index') }}"
                class="{{ request()->routeIs('admin.signatures.*') ? 'active' : '' }}"
            >
                Signature
            </a>

            <a
                href="{{ route('admin.reports.index') }}"
                class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
            >
                Laporan
            </a>

            <a
                href="{{ route('admin.signers.index') }}"
                class="{{ request()->routeIs('admin.signers.*') ? 'active' : '' }}"
            >
                Penandatangan
            </a>

            <a
                href="{{ route('sign.device') }}"
                target="_blank"
            >
                Sign Device
            </a>

        </div>


        {{-- =================================================
             TOPBAR
        ================================================== --}}
        <header class="topbar">

            <div class="topbar-inner">

                <div>

                    <div class="topbar-title">
                        @yield('page-title', 'Admin Dashboard')
                    </div>

                    <div class="topbar-subtitle">
                        @yield(
                            'page-subtitle',
                            'Smart Visitor Registration & Digital Signature'
                        )
                    </div>

                </div>


                <div class="topbar-user">

                    <div class="topbar-user-name">
                        Admin Melaka
                    </div>

                    <div class="topbar-user-email">
                        admin@melaka.gov.my
                    </div>

                </div>

            </div>

        </header>


        {{-- =================================================
             CONTENT
        ================================================== --}}
        <main class="content-area">

            <div class="content-wrap">

                {{-- SUCCESS MESSAGE --}}
                @if (session('success'))

                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 text-sm">

                        {{ session('success') }}

                    </div>

                @endif


                {{-- ERROR MESSAGE --}}
                @if (session('error'))

                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">

                        {{ session('error') }}

                    </div>

                @endif


                @yield('content')

            </div>

        </main>

    </div>

</div>


@stack('scripts')

</body>

</html>