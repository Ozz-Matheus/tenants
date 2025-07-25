<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\Widget;

class DataWidget extends Widget
{
    protected static string $view = 'filament.resources.data-resource.widgets.data-widget';

    protected function getViewData(): array
    {
        $user = auth()->user();

        return [
            'roles' => $user->getRoleNames(),
            'permissionsViaRoles' => $user->getPermissionsViaRoles(),
        ];
    }
}
