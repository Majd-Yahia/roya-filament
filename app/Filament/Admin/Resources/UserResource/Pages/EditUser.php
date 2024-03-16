<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Event;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave() {
        // Manually dispatch the updated event because most of changes are relational
        Event::dispatch('eloquent.updated: ' . User::class, $this->record);
    }
}
