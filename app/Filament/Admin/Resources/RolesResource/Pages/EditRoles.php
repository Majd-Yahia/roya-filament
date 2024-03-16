<?php

namespace App\Filament\Admin\Resources\RolesResource\Pages;

use App\Filament\Admin\Resources\RolesResource;
use App\Models\Role;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Event;

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
        // Manually dispatch the updated event because most of changes are relational
        Event::dispatch('eloquent.updated: ' . Role::class, $this->record);
    }
}
