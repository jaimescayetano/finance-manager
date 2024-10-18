<?php

use Filament\Notifications\Notification;

if (!function_exists('send_notification')) {
    function send_notification(string $title, int $type, string $body = ''): Notification
    {
        $notification = Notification::make()
            ->title($title) 
            ->body($body);

        switch ($type) {
            case 0:
                $notification->warning();
                break;
            case 1:
                $notification->success();
                break;
            default:
                break;
        }

        return $notification->send();
    }
}
