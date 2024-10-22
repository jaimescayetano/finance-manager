<?php

namespace App\Observers;

use App\Models\ActionTracking;
use App\Models\Income;

class IncomeObserver
{
    const CREATED_SUCCESS_MESSAGE = 'The transaction was completed successfully';
    const CREATED_SUCESS_STATUS = 'S';
    const CREATED_WRONG_STATUS = 'W';

    /**
     * Handle the Income "created" event.
     */
    public function created(Income $income): void
    {
        ActionTracking::create([
            'message' => self::CREATED_SUCCESS_MESSAGE,
            'amount' => $income->amount,
            'status' => self::CREATED_SUCESS_STATUS,
            'type' => Income::TYPE_ACTION,
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Income "updated" event.
     */
    public function updated(Income $income): void
    {
        //
    }

    /**
     * Handle the Income "deleted" event.
     */
    public function deleted(Income $income): void
    {
        //
    }

    /**
     * Handle the Income "restored" event.
     */
    public function restored(Income $income): void
    {
        //
    }

    /**
     * Handle the Income "force deleted" event.
     */
    public function forceDeleted(Income $income): void
    {
        //
    }
}
