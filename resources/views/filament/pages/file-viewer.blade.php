<x-filament::page>
    <div class="space-y-6 file-viewer">

        <div class="space-y-4">
            <div class="flex items-center gap-x-2">

                {{-- Status --}}
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-500 dark:text-gray-400"><strong>{{ __('Status') }}<small>:</small></strong></span>
                    @if($status)
                        <x-filament::badge :color="$status->getColor() ?? 'gray'">
                            {{ $status->getLabel() }}
                        </x-filament::badge>
                    @else
                        <span class="text-gray-600 dark:text-gray-300">{{ __('Stateless') }}</span>
                    @endif
                </div>

                <div class="hidden h-4 w-px bg-gray-300 dark:bg-gray-700 sm:block"></div>

                {{-- Formato --}}
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-500 dark:text-gray-400"><strong> {{ __('Format') }}<small>:</small></strong></span>
                    <span class="text-gray-900 dark:text-white">{{ $file->readable_mime_type }}</span>
                </div>

                <div class="hidden h-4 w-px bg-gray-300 dark:bg-gray-700 sm:block"></div>

                {{-- Tamaño --}}
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-500 dark:text-gray-400"><strong> {{ __('Size') }}<small>:</small></strong></span>
                    <span class="text-gray-900 dark:text-white">{{ $file->readable_size }}</span>
                </div>
            </div>
            @if ($file->isPdf())
                {{-- PDF embebido directamente --}}
                <iframe
                    src="{{ $file->url() }}"
                    class="w-full h-screen border rounded shadow"
                    title="PDF Viewer"
                ></iframe>

            @elseif ($file->isOfficeEmbeddable())
                @php
                // Si el doc es confidencial y quieres evitar exponerlo a un tercero (Office Viewer),
                // puedes deshabilitar la vista y forzar descarga:
                    $allowExternalViewer = !optional($doc)->confidential;
                @endphp
                {{-- Office Online Viewer necesita URL ABSOLUTA y accesible públicamente --}}
                @if ($allowExternalViewer)
                    <iframe
                        src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($file->url()) }}"
                        class="w-full h-screen border rounded shadow"
                        title="Office Viewer"
                    ></iframe>
                @else
                    <div class="p-4 border rounded bg-yellow-50">
                        {{ __('This document is confidential. Download it to view it') }}
                    </div>
                @endif

            @else
                <div class="p-4 border rounded bg-gray-50">
                    {{ __('Preview not available for this file type') }}
                </div>
            @endif

            <div class="pt-2">
                <x-filament::button
                    :href="$file->url()"
                    tag="a"
                    icon="heroicon-m-arrow-down-tray"
                    :download="$file->name"
                >
                    {{ __('Download') }}
                </x-filament::button>
            </div>
        </div>

        {{-- Tabla de Decisiones --}}
        @if(isset($doc) && $status !== \App\Enums\StatusEnum::DRAFT)
        <div class="mt-8 border-t pt-6">
                {{ $this->table }}
            </div>
        @endif

    </div>
</x-filament::page>
