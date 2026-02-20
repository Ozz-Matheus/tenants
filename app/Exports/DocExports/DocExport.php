<?php

namespace App\Exports\DocExports;

use App\Models\Doc;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DocExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected array $DocIds;

    public function __construct(array $DocIds)
    {
        $this->DocIds = $DocIds;
    }

    public function title(): string
    {
        return '📄 Documentos seleccionados';
    }

    public function collection(): Collection
    {
        return Doc::with([
            'type',
            'process',
            'subprocess',
            'createdBy',
            'latestVersion',
        ])
            ->whereIn('id', $this->DocIds)
            ->get();
    }

    public function map($doc): array
    {

        return [
            $doc->classification_code,
            $doc->title,
            $doc->type?->title,
            $doc->process?->title,
            $doc->subprocess?->title,
            $doc->latestVersion?->status?->getLabel() ?? __('Stateless'),
            $doc->latestVersion?->version ?? '-',
            $doc->confidential ? __('doc.private') : __('doc.public'),
            $doc->storage_method?->getLabel() ?? '-',
            $doc->retention_time ?? '-',
            $doc->recoveryMethod?->title ?? '-',
            $doc->dispositionMethod?->title ?? '-',
            $doc->headquarter->name,
            optional($doc->createdBy)->name,
            optional($doc->createdBy)->email,
            $doc->created_at,
            $doc->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            __('Classification code'),
            __('Title'),
            __('doc.type.model_label'),
            __('Process'),
            __('Subprocess'),
            __('Status'),
            __('doc.version.model_label'),
            __('doc.confidential'),
            __('doc.storage_method'),
            __('doc.retention_time').__(' per month'),
            __('doc.recovery_method'),
            __('doc.disposition_method'),
            __('headquarter.model_label'),
            __('Created by (name)'),
            __('Created by (email)'),
            __('Created at'),
            __('Updated at'),
        ];
    }
}
