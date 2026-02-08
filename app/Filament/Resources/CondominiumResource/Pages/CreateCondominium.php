<?php

namespace App\Filament\Resources\CondominiumResource\Pages;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\CondominiumResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\CondominiumService;

class CreateCondominium extends CreateRecord
{
    protected static string $resource = CondominiumResource::class;

    protected function handleRecordCreation(array $data):model {
        return app(CondominiumService::class)
            ->storeForAdmin($data);
    }
}
