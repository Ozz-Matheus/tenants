<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', __('emails.layout.default_title', ['app' => config('app.name')]))</title>
    @include('emails.layout.styles')
</head>
<body>
    <table class="body" role="presentation" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="container" role="presentation" cellpadding="0" cellspacing="0">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <img src="{{ asset('images/logo.jpg') }}"
                                 alt="{{ __('emails.layout.logo_alt', ['app' => config('app.name')]) }}">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td class="content">
                            <h1>@yield('title', __('emails.layout.default_title', ['app' => config('app.name')]))</h1>

                            @yield('content')

                            <!-- Firma -->
                            <div class="signature">
                                <strong>{{ __('emails.layout.thanks') }}</strong>
                                <p>{{ __('emails.layout.team', ['app' => config('app.name')]) }}</p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p><strong>{{ config('app.name') }}</strong></p>
                            <p>
                                {{ __('emails.layout.auto_message') }}<br>
                                {{ __('emails.layout.no_reply') }}
                            </p>
                            <div class="footer-links">
                                <a href="{{ route('filament.dashboard.pages.dashboard') }}" target="_blank">
                                    {{ __('emails.layout.go_to_dashboard') }}
                                </a>
                                <a href="mailto:soporte@holdingtec.app" target="_blank">
                                    {{ __('emails.layout.help_center') }}
                                </a>
                            </div>

                            <p style="margin-top: 16px; font-size: 12px; color: #9ca3af;">
                                © {{ date('Y') }} {{ config('app.name') }}. {{ __('emails.layout.rights_reserved') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>