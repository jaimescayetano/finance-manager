<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

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
        $response = User::applyExpense($data['amount'] ?? 0);
        
        send_notification(
            $response['message'],
            $response['status'] ? 1 : 0
        );

        if (!$response['status']) $this->halt();

        $expense = static::getModel()::create($data);
        return $expense;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}
