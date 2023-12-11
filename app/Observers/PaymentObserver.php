<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Enums\TransactionStatus;
use App\Repositories\TransactionRepository;

class PaymentObserver
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function creating($query)
    {
        $transaction = $this->transactionRepository->find($query->transaction_id);
        if ($query->amount == $transaction->getAmount()) {
            $this->transactionRepository->update(['status' => TransactionStatus::PAID],$transaction->id);
        } elseif($transaction->due_on > Carbon::today()) {
            $this->transactionRepository->update(['status' => TransactionStatus::OVER_DUE],$transaction->id);
        }
        $query->paid_on = Carbon::today()->format('Y-m-d');
    }
}
