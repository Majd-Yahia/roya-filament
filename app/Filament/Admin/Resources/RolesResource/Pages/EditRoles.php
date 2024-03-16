<?php

namespace App\Filament\Admin\Resources\RolesResource\Pages;

use App\Filament\Admin\Resources\RolesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EditRoles extends EditRecord
{
    protected static string $resource = RolesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave() {

        $roles = Auth()->user()->roles->pluck('id')->toArray();

        if(in_array($this->data['id'], $roles)) {
            Auth()->user()->reCachePermission();
        }
    }
}
