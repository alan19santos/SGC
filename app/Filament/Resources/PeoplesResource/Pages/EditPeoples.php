<?php

namespace App\Filament\Resources\PeoplesResource\Pages;
use App\Services\PeoplesServices;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PeoplesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeoples extends EditRecord
{
    protected static string $resource = PeoplesResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(PeoplesServices::class)
            ->updateForAdmin($data, $record->id);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
