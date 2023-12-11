<?php

namespace App\Repositories;

use App\Enums\TransactionStatus;
use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Transaction::class;
    }

    public function getByPayer($payerId)
    {
        return $this->model::payer($payerId)->get();
    }

    public function getMonthlyReport($from = null, $to = null)
    {
        $statusesAsColumns = '';
        foreach (TransactionStatus::cases() as $status) {
            $statusesAsColumns .= "sum( case when status = '" . $status->value . "' then 1 else 0 end) as " . $status->name . ",";
        }

        return $this->model::selectRaw($statusesAsColumns . "year(created_at) year, month(created_at) month")
            ->groupBy('year', 'month')->when($from, function ($query) use ($from) {
                $query->whereDate('created_at', '>=', $from);
            })->when(isset($to), function ($query) use ($to) {
                $query->whereDate('created_at', '=<', $to);
            })->get();
    }
}
