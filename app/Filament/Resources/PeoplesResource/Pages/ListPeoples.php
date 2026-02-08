<?php

namespace App\Filament\Resources\PeoplesResource\Pages;

use App\Filament\Resources\PeoplesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeoples extends ListRecords
{
    protected static string $resource = PeoplesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
