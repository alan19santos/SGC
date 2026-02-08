<?php

namespace App\Filament\Resources\PeoplesResource\Pages;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PeoplesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\PeoplesServices;

class CreatePeoples extends CreateRecord
{
    protected static string $resource = PeoplesResource::class;

    protected function handleRecordCreation(array $data):model {
        return app(PeoplesServices::class)->storeFormDataForAdmin($data);
    }
}
