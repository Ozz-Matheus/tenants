@extends('emails.layout.theme')

@section('title')
    {{ __('emails.tenant_credentials.title') }}
@endsection

@section('content')
    <p>
        {{ __('emails.tenant_credentials.greeting') }} {{ $tenantName }},
    </p>

    <p>
        {{ __('emails.tenant_credentials.access_generated') }}
    </p>

    <p>
        {{ __('emails.tenant_credentials.system_info', ['app' => config('app.name')]) }}
    </p>

    <ul>
        <li>
            <strong>
                {{ __('emails.tenant_credentials.tenant_credentials_label') }}:
            </strong>
            {{ $tenantName }}
        </li>
        <li>
            <strong>
                {{ __('emails.tenant_credentials.reset_url_label') }}:
            </strong>
        </li>
    </ul>

    <p>
        <a href="{{ $resetUrl }}" class="button" target="_blank">
            {{ __('emails.tenant_credentials.go_to_system_button') }}
        </a>
    </p>
@endsection
