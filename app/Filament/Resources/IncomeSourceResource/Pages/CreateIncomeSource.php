<?php

namespace App\Filament\Resources\IncomeSourceResource\Pages;

use App\Filament\Resources\IncomeSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomeSource extends CreateRecord
{
    protected static string $resource = IncomeSourceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
