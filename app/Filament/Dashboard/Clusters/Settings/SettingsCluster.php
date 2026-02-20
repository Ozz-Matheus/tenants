<?php

namespace App\Filament\Dashboard\Clusters\Settings;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class SettingsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return __('Settings');
    }
}
