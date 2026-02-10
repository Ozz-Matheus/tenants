@extends('emails.layout.theme')

@section('title')
    {{ __('emails.document_status_change.title') }}
@endsection

@section('content')
    <p>{{ __('emails.document_status_change.greeting') }} <strong>{{ $user->name }}</strong>,</p>

    <p>{{ __('emails.document_status_change.notification', ['app' => config('app.name')]) }}</p>

    <div class="info-card">
        <ul>
            <li>
                <strong>{{ __('emails.document_status_change.classification_code') }}:</strong>
                <span>{{ $version->doc?->classification_code }}</span>
            </li>
            <li>
                <strong>{{ __('emails.document_status_change.document') }}:</strong>
                <span>{{ $version->file?->name }}</span>
            </li>
            <li>
                <strong>{{ __('emails.document_status_change.new_status') }}:</strong>
                <span>
                    <span class="status-badge {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </span>
            </li>
            <li>
                <strong>{{ __('emails.document_status_change.uploaded_by') }}:</strong>
                <span>{{ $version->createdBy?->name }}</span>
            </li>
            <li>
                <strong>{{ __('emails.document_status_change.date') }}:</strong>
                <span>{{ $version->created_at->format('d/m/Y H:i') }}</span>
            </li>
        </ul>
    </div>

    @if ($messageBody)
        <div class="alert">
            <strong>{{ __('emails.document_status_change.important_info') }}</strong>
            {{ $messageBody }}
        </div>
    @endif

    <p style="margin-top: 28px;">
        {{ __('emails.document_status_change.review_details') }}
    </p>

    <p style="text-align: center;">
        <a href="{{ route('filament.dashboard.resources.docs.view', ['record' => $version->doc->id]) }}"
            class="button">
            {{ __('emails.document_status_change.view_details_button') }}
        </a>
    </p>

    <div class="alert-box">
        <img width="24" height="24" src="{{ asset('images/email-icons/version.png') }}" alt="{{ __('emails.document_status_change.document_icon_alt') }}">
        <span>{{ __('emails.document_status_change.access_from_panel') }}</span>
    </div>
@endsection
