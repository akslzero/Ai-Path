<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use Filament\Resources\Pages\EditRecord;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Simpan level & XP ke relasi profile
        $this->record->profile->update([
            'level' => $data['profile']['level'],
            'total_xp' => $data['profile']['total_xp'],
        ]);

        unset($data['profile']);
        return $data;
    }
}
