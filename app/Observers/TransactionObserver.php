<?php

namespace App\Observers;

use App\Enums\TransactionStatus;
use Carbon\Carbon;

class TransactionObserver
{
    public function creating($query)
    {
        if ($query->due_on < Carbon::today()) {
            $query->status = TransactionStatus::OVER_DUE;
        } else {
            $query->status = TransactionStatus::OUTSTANDING;
        }
    }
}
