<?php

namespace App\Observers;

use App\Models\ActionTracking;
use App\Models\Expense;

class ExpenseObserver
{
    const CREATED_SUCCESS_MESSAGE = 'The transaction was completed successfully';
    const CREATED_SUCESS_STATUS = 'S';
    const CREATED_WRONG_STATUS = 'W';

    /**
     * Handle the Expense "created" event.
     */
    public function created(Expense $expense): void
    {
        ActionTracking::create([
            'message' => self::CREATED_SUCCESS_MESSAGE,
            'amount' => $expense->amount,
            'status' => self::CREATED_SUCESS_STATUS,
            'type' => Expense::TYPE_ACTION,
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Expense "updated" event.
     */
    public function updated(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "deleted" event.
     */
    public function deleted(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "restored" event.
     */
    public function restored(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "force deleted" event.
     */
    public function forceDeleted(Expense $expense): void
    {
        //
    }
}
