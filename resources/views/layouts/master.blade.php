<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' | ' : '' }}GAD-MS Mabinay</title>

    @php
        $logoPath = $setting->photo_filename && is_file(public_path('uploads/' . $setting->photo_filename))
            ? 'uploads/' . $setting->photo_filename
            : 'template/img/gad-logo.png';
        $user = auth()->user();
        $initials = strtoupper(mb_substr($user->fname, 0, 1) . mb_substr($user->lname, 0, 1));
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400&display=swap">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free-v6/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/gadms.css') }}?v={{ filemtime(public_path('css/gadms.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}">

    <link rel="icon" href="{{ asset($logoPath) }}">
    <script>document.documentElement.classList.add('has-nav-js');</script>
</head>

<body class="hold-transition layout-top-nav text-sm">
<a href="#main" class="gad-skip">Skip to content</a>

<div class="wrapper">
    <header class="gad-band">
        <div class="gad-band__top">
            <a href="{{ route('dashboard') }}" class="gad-brand">
                <img src="{{ asset($logoPath) }}" class="gad-seal" alt="">
                <span>
                    <span class="gad-brand__office">Municipal Social Welfare and Development Office</span>
                    <span class="gad-brand__system">{{ $setting->system_name ?: 'GAD Management System' }}, Mabinay</span>
                </span>
            </a>

            <button type="button" class="gad-theme-toggle" id="themeToggle" aria-label="Switch to dark mode" title="Toggle dark mode"><i class="fas fa-moon" aria-hidden="true"></i></button>
            <div class="gad-user dropdown">
                <button type="button" class="gad-user__toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="gad-user__initials" aria-hidden="true">{{ $initials }}</span>
                    <span>
                        <span class="gad-user__name">{{ $user->fname }} {{ $user->lname }}</span>
                        <span class="gad-user__role">{{ $user->role }}</span>
                    </span>
                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    <span class="sr-only">Account menu</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                    <a class="dropdown-item" href="{{ route('user_settings') }}">
                        <i class="fas fa-user-gear fa-fw mr-2" aria-hidden="true"></i>Account settings
                    </a>
                    @if ($user->canAccessModule('admin'))
                        <a class="dropdown-item" href="{{ route('setting_list') }}">
                            <i class="fas fa-image fa-fw mr-2" aria-hidden="true"></i>System name and logo
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-arrow-right-from-bracket fa-fw mr-2" aria-hidden="true"></i>Sign out
                    </a>
                </div>
            </div>
            <button type="button" class="gad-nav-toggle" id="moduleMenuToggle" aria-label="Toggle module menu" aria-controls="moduleNav" aria-expanded="false">
                <i class="fas fa-bars" aria-hidden="true"></i><span>Menu</span>
            </button>
        </div>

        @include('partials.control')
    </header>

    <div class="content-wrapper">
        <main id="main" class="gad-main" tabindex="-1">
            @yield('body')
        </main>
    </div>

    <footer class="main-footer">
        Maintained by <a href="https://www.facebook.com/profile.php?id=61550487001454" target="_blank" rel="noopener">SYSTALLGRAPFIX</a>
    </footer>
</div>

<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<script>
    (function () {
        const isDark = localStorage.getItem('gad-theme') === 'dark';
        if (isDark) document.body.classList.add('dark-mode');
        document.getElementById('themeToggle').addEventListener('click', function () {
            const dark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('gad-theme', dark ? 'dark' : 'light');
            this.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
            this.querySelector('i').className = dark ? 'fas fa-sun' : 'fas fa-moon';
        });
        if (isDark) {
            document.getElementById('themeToggle').setAttribute('aria-label', 'Switch to light mode');
            document.getElementById('themeToggle').querySelector('i').className = 'fas fa-sun';
        }
    })();
</script>
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('template/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('template/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="{{ asset('template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('js/passValidation.js') }}"></script>
<script src="{{ asset('js/citizenAddValidation.js') }}"></script>
<script src="{{ asset('js/userAddValidation.js') }}"></script>
<script src="{{ asset('js/basic/userscript.js') }}"></script>
<script src="{{ asset('js/form-script.js') }}"></script>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

@php
    $currentRoute = request()->route()->getName();
@endphp

@include('script.masterScript')
@include('script.dashboardScript')
@if(request()->is('senior*'))
    @include('script.seniorScript')
@endif
@if(request()->is('user*'))
    @include('script.userScript')
@endif
@if(request()->is('faced*'))
    @include('script.facedScript')
@endif
@stack('scripts')
<script>
    (function () {
        // Publish the pinned header's height for scroll offsets and other sticky panels.
        const band = document.querySelector('.gad-band');
        if (!band) return;
        const update = function () {
            document.documentElement.style.setProperty('--gad-band-height', band.offsetHeight + 'px');
        };
        update();
        if ('ResizeObserver' in window) {
            new ResizeObserver(update).observe(band);
        } else {
            window.addEventListener('resize', update);
        }
    })();

    (function () {
        const toggle = document.getElementById('moduleMenuToggle');
        const nav = document.getElementById('moduleNav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function () {
            const expanded = toggle.getAttribute('aria-expanded') !== 'true';
            toggle.setAttribute('aria-expanded', String(expanded));
            nav.classList.toggle('is-open', expanded);
        });
    })();
</script>
</body>
</html>
