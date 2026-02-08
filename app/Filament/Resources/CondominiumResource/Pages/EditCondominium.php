<?php

namespace App\Filament\Resources\CondominiumResource\Pages;
use Illuminate\Database\Eloquent\Model;
use App\Services\CondominiumService;
use App\Filament\Resources\CondominiumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCondominium extends EditRecord
{
    protected static string $resource = CondominiumResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(CondominiumService::class)
            ->updateForAdmin($data, $record->id);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
