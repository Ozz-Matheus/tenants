@extends('emails.layout.theme')

@section('title')
    {{ __('emails.new_document_created.title') }}
@endsection

@section('content')
    <p>{{ __('emails.new_document_created.greeting') }} <strong>{{ $user->name }}</strong>,</p>

    <p>{{ __('emails.new_document_created.notification', ['app' => config('app.name')]) }}</p>

    <div class="info-card">
        <ul>
            <li>
                <strong>{{ __('emails.new_document_created.title_label') }}:</strong>
                <span>{{ $doc->title }}</span>
            </li>
            <li>
                <strong>{{ __('emails.new_document_created.created_by') }}:</strong>
                <span>{{ $doc->createdBy->name ?? __('emails.new_document_created.system') }}</span>
            </li>
            <li>
                <strong>{{ __('emails.new_document_created.date') }}:</strong>
                <span>{{ $doc->created_at->format('d/m/Y H:i') }}</span>
            </li>
        </ul>
    </div>

    <p style="margin-top: 28px;">
        {{ __('emails.new_document_created.review_details') }}
    </p>

    <p style="text-align: center;">
        <a href="{{ route('filament.dashboard.resources.docs.view', ['record' => $doc->id]) }}" class="button">
            {{ __('emails.new_document_created.view_document_button') }}
        </a>
    </p>

    <div class="alert-box">
        <img width="24" height="24" src="{{ asset('images/email-icons/doc.png') }}" alt="{{ __('emails.new_document_created.document_icon_alt') }}">
        <span>{{ __('emails.new_document_created.ready_to_manage') }}</span>
    </div>
@endsection
