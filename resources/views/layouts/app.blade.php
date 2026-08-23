<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ \App\Models\Setting::get('nama_aplikasi', 'E-Survey Deli Serdang') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    {{-- ===== Konfigurasi PWA ===== --}}
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#0d6e3f">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="E-Survey">
    <meta name="mobile-web-app-capable" content="yes">
</head>

<body>
    <div class="wrapper d-flex">

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-clipboard2-data-fill"></i>
                <div>
                    <div class="brand-title">E-Survey</div>
                    <div class="brand-sub">Deli Serdang</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard Admin Utama
                </a>

                @if(auth()->user()->hasMenuAccess('isi_survey'))
                <a href="{{ route('user-survey.index') }}" class="nav-link {{ request()->routeIs('user-survey.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Isi Survey
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('admin_user'))
                <a href="{{ route('admin-users.index') }}" class="nav-link {{ request()->routeIs('admin-users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Manajemen Admin User
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('survey_template'))
                <a href="{{ route('survey-templates.index') }}" class="nav-link {{ request()->routeIs('survey-templates.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i> Template Survei / Data Survei
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('survey_response'))
                <a href="{{ route('survey-responses.index') }}" class="nav-link {{ request()->routeIs('survey-responses.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-square-text-fill"></i> Respon Survei
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('backup_restore'))
                <a href="{{ route('backup.index') }}" class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}">
                    <i class="bi bi-hdd-fill"></i> Backup &amp; Restore Data
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('hak_akses'))
                <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill"></i> Hak Akses
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('laporan'))
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Laporan
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('pengaturan'))
                <a href="{{ route('pengaturan.index') }}" class="nav-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i> Pengaturan
                </a>
                @endif

                @if(auth()->user()->hasMenuAccess('integrasi'))
                <a href="{{ route('integrasi.index') }}" class="nav-link {{ request()->routeIs('integrasi.*') ? 'active' : '' }}">
                    <i class="bi bi-plug-fill"></i> Integrasi API
                </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <div class="content-wrapper flex-grow-1">
            <header class="topbar d-flex align-items-center justify-content-between">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="toggleSidebar"><i class="bi bi-list"></i></button>
                <h5 class="mb-0 topbar-title">@yield('title', 'Dashboard')</h5>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span class="d-none d-sm-inline">{{ auth()->user()->name ?? '' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->role->nama_role ?? '' }}</span></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            <main class="main-content">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </main>

            <footer class="text-center text-muted small py-3">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::get('nama_instansi', 'Pemerintah Kabupaten Deli Serdang') }} — Sistem Survey Kepuasan Layanan Digital
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- ===== Service Worker (PWA) ===== --}}
    <script>
        // Daftarkan service worker supaya aset statis (css/js/ikon) di-cache
        // dan halaman offline fallback aktif. Tombol Install App sengaja
        // hanya ditampilkan di halaman login, bukan di sini.
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('sw.js') }}")
                    .catch((err) => console.warn('SW registration gagal:', err));
            });
        }
    </script>
    @yield('scripts')
</body>


</html>