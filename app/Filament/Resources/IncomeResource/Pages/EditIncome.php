<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Services\Finance\IncomeService;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class EditIncome extends EditRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $userId = auth()->id();
        $response = IncomeService::update($userId, $record->id, $data);

        send_notification(
            $response['message'],
            $response['success'] ? 1 : 0
        );

        if (!$response['success'] || !isset($response['model'])) $this->halt();

        return $response['model'];
    }

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }
}
