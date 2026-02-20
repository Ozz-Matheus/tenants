<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\EffectivenessLevelRangeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditEffectivenessLevelRange extends EditRecord
{
    protected static string $resource = EffectivenessLevelRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getRecordTitle(): string|Htmlable
    {
        $resource = static::getResource();
        $title = $this->getRecord()->getAttribute($resource::getRecordTitleAttribute());

        if ($title instanceof \BackedEnum) {
            return (string) $title->value;
        }

        return (string) $title;
    }
}
