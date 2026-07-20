<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'GestDoc') }}</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap');

            :root {
                --gold-400: #facc15;
                --gold-500: #eab308;
                --gold-600: #ca8a04;
                --gold-700: #a16207;
                --gold-50: #fefce8;
                --navy-900: #0f172a;
                --navy-800: #1e293b;
                --navy-700: #334155;
                --navy-600: #475569;
                --navy-50: #f8fafc;
                --radius-sm: 8px;
                --radius: 12px;
                --radius-lg: 16px;
                --radius-xl: 20px;
                --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.04), 0 1px 2px -1px rgb(0 0 0 / 0.04);
                --shadow: 0 4px 12px -2px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.03);
                --shadow-lg: 0 12px 24px -8px rgb(0 0 0 / 0.08), 0 4px 8px -4px rgb(0 0 0 / 0.04);
                --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-800) 50%, var(--navy-700) 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                -webkit-font-smoothing: antialiased;
            }

            .auth-wrapper {
                width: 100%;
                max-width: 440px;
                padding: 24px;
                position: relative;
            }

            .auth-card {
                background: #ffffff;
                border-radius: var(--radius-xl);
                padding: 40px 36px;
                box-shadow: var(--shadow-lg);
                border: 1px solid #e2e8f0;
                position: relative;
                overflow: hidden;
            }

            .auth-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--gold-500) 0%, var(--gold-400) 100%);
            }

            .auth-logo {
                text-align: center;
                margin-bottom: 28px;
            }

            .auth-logo-icon {
                width: 56px;
                height: 56px;
                border-radius: var(--radius);
                background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: var(--navy-900);
                font-size: 26px;
                margin-bottom: 12px;
                box-shadow: 0 8px 20px rgba(234, 179, 8, 0.25);
            }

            .auth-logo h1 {
                font-family: 'Playfair Display', serif;
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--navy-900);
                margin: 0;
                letter-spacing: -0.02em;
            }

            .auth-logo p {
                color: var(--navy-600);
                font-size: 0.9rem;
                margin-top: 4px;
            }

            .form-label {
                font-weight: 600;
                font-size: 13px;
                color: var(--navy-700);
                margin-bottom: 8px;
            }

            .form-control {
                border-radius: var(--radius-sm);
                border: 1px solid #e2e8f0;
                padding: 12px 14px;
                font-size: 14px;
                transition: var(--transition);
                background: #ffffff;
                font-family: 'Inter', sans-serif;
            }

            .form-control:focus {
                border-color: var(--gold-500);
                box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.08);
                outline: none;
            }

            .btn-auth {
                width: 100%;
                padding: 12px;
                border-radius: var(--radius-sm);
                background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
                color: var(--navy-900);
                border: none;
                font-weight: 700;
                font-size: 0.95rem;
                transition: var(--transition);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                margin-top: 8px;
            }

            .btn-auth:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 20px rgba(234, 179, 8, 0.3);
                color: var(--navy-900);
            }

            .auth-footer {
                text-align: center;
                margin-top: 24px;
                font-size: 0.88rem;
                color: var(--navy-600);
            }

            .auth-footer a {
                color: var(--gold-700);
                font-weight: 600;
                text-decoration: none;
            }

            .auth-footer a:hover {
                color: var(--gold-600);
            }

            .form-check-input:checked {
                background-color: var(--gold-500);
                border-color: var(--gold-500);
            }

            .form-check-input:focus {
                border-color: var(--gold-500);
                box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.08);
            }

            @media (max-width: 576px) {
                .auth-card {
                    padding: 28px 22px;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            <div class="auth-card">
                <div class="auth-logo">
                    <div class="auth-logo-icon">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                    <h1>GestDoc</h1>
                    <p>@yield('auth-subtitle', 'Connectez-vous à votre espace')</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
