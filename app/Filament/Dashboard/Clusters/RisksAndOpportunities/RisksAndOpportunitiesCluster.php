<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class RisksAndOpportunitiesCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ExclamationCircle;

    protected static ?int $navigationSort = 2;
}
