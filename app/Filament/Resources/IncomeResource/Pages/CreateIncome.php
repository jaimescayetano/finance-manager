<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Models\User;
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
        $response = User::applyIncome($data['amount'] ?? 0);
        $income = static::getModel()::create($data);

        send_notification(
            $response['message'],
            $response['status'] ? 1 : 0
        );     

        return $income;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}
