<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Models\User;
use App\Services\Finance\IncomeService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class CreateIncome extends CreateRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $userId = auth()->id();
        $response = IncomeService::create($userId, $data);
    
        send_notification(
            $response['message'],
            $response['success'] ? 1 : 0
        );

        if (!$response['success'] || !isset($response['model'])) $this->halt();

        return $response['model'];
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}
