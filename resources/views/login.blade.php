<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in | GAD-MS Mabinay</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400&display=swap">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free-v6/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gadms.css') }}?v={{ filemtime(public_path('css/gadms.css')) }}">
    <link rel="icon" href="{{ asset('template/img/gad-logo.png') }}">
</head>

<body class="gad-login-page">
<main class="gad-signin">
    <div class="gad-signin__shell">
        <aside class="gad-signin__intro" aria-label="Office information">
            <div class="gad-signin__brand">
                <img src="{{ asset('template/img/gad-logo.png') }}" class="gad-signin__seal" alt="MSWDO Mabinay seal">
                <div>
                    <span class="gad-signin__brand-name">MSWDO Mabinay</span>
                    <span class="gad-signin__brand-sub">GAD Management System</span>
                </div>
            </div>

            <div class="gad-signin__intro-copy">
                <span class="gad-signin__eyebrow"><span aria-hidden="true"></span> Municipal staff portal</span>
                <p class="gad-signin__tagline">Supporting people.<br><em>Strengthening communities.</em></p>
                <p>Access the records and services that help the Municipal Social Welfare and Development Office serve Mabinay.</p>
            </div>

            <div class="gad-signin__location"><i class="fas fa-location-dot" aria-hidden="true"></i> Mabinay, Negros Oriental</div>
        </aside>

        <section class="gad-signin__sheet" aria-labelledby="signin-title">
            <div class="gad-signin__form-wrap">
                <span class="gad-signin__form-kicker">Welcome back</span>
                <h1 id="signin-title">Sign in to your account</h1>
                <p class="gad-signin__office">Enter your staff credentials to continue.</p>

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="status">{{ session('success') }}</div>
                @endif

                <form action="{{ route('postLogin') }}" method="post" novalidate>
                    @csrf

                    <div class="form-group gad-signin__field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                               class="form-control @error('username') is-invalid @enderror"
                               placeholder="Enter your username" autocomplete="username" autocapitalize="none" spellcheck="false" required autofocus
                               @error('username') aria-describedby="username-error" @enderror>
                        @error('username')
                            <span id="username-error" class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group gad-signin__field">
                        <label for="password">Password</label>
                        <div class="gad-password">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter your password" autocomplete="current-password" required
                                   @error('password') aria-describedby="password-error" @enderror>
                            <button type="button" class="gad-password__toggle" id="togglePassword" aria-controls="password" aria-pressed="false" aria-label="Show password">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        @error('password')
                            <span id="password-error" class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block gad-signin__submit">
                        <span>Sign in</span><i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <p class="gad-signin__help"><i class="fas fa-circle-info" aria-hidden="true"></i> Need access? Contact your system administrator.</p>
            </div>

            <p class="gad-signin__foot">Municipal Social Welfare and Development Office<br>Mabinay, Negros Oriental</p>
        </section>
    </div>
</main>

<script>
    (function () {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('password');

        toggle.addEventListener('click', function () {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', String(show));
            toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            toggle.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        document.querySelector('form').addEventListener('submit', function (event) {
            if (event.submitter) {
                event.submitter.disabled = true;
                event.submitter.querySelector('span').textContent = 'Signing in...';
            }
        });
    })();

    @if (auth()->check())
        window.location.href = "{{ route('dashboard') }}";
    @endif
</script>
</body>
</html>
