<?php

namespace App\Observers;

use App\Models\ActionTracking;
use App\Models\Saving;

class SavingsObserver
{
    const ACTION_SUCCESS = 'S';
    const ACTION_WRONG = 'W';

    /**
     * Handle the Saving "created" event.
     */
    public function created(Saving $saving): void
    {
        ActionTracking::create([
            'message' => __('messages.success.savings_saved'),
            'amount' => $saving->amount,
            'status' => self::ACTION_SUCCESS,
            'type' => Saving::TYPE_ACTION,
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Saving "updated" event.
     */
    public function updated(Saving $saving): void
    {
        ActionTracking::create([
            'message' => __('messages.success.savings_updated'),
            'amount' => $saving->amount,
            'status' => self::ACTION_SUCCESS,
            'type' => Saving::TYPE_ACTION,
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Saving "deleted" event.
     */
    public function deleted(Saving $saving): void
    {
        ActionTracking::create([
            'message' => __('messages.success.savings_deleted'),
            'amount' => $saving->amount,
            'status' => self::ACTION_SUCCESS,
            'type' => Saving::TYPE_ACTION,
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Saving "restored" event.
     */
    public function restored(Saving $saving): void
    {
        //
    }

    /**
     * Handle the Saving "force deleted" event.
     */
    public function forceDeleted(Saving $saving): void
    {
        //
    }
}
