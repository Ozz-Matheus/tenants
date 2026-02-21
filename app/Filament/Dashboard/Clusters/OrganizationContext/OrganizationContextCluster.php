<?php

namespace App\Filament\Dashboard\Clusters\OrganizationContext;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class OrganizationContextCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    public static function getModelLabel(): string
    {
        return __('organization_context.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('organization_context.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('organization_context.plural_model_label');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return __('organization_context.plural_model_label');
    }
}
