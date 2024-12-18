<?php

namespace App\Filament\Resources\SavingResource\Pages;

use App\Filament\Resources\SavingResource;
use App\Services\Finance\SavingsService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSaving extends EditRecord
{
    protected static string $resource = SavingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $userId = auth()->id();
        $response = SavingsService::update($userId, $record->id, $data);

        send_notification(
            $response['message'],
            $response['success'] ? 1 : 0
        );

        if (!$response['success'] || !isset($response['model'])) $this->halt();

        return $response['model'];
    }
}
