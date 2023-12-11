<?php

namespace App\Enums;

use Carbon\Carbon;


enum TransactionStatus : int
{
    case PAID = 1;
    case OUTSTANDING = 2;
    case OVER_DUE = 3;

    public static function getStatus($status,$dueDate){
        return match ($status) {
            self::OUTSTANDING => ($dueDate < Carbon::today()) ? 'Overdue' : 'Outstanding',
            self::PAID => 'Paid',
            self::OVER_DUE => 'Overdue',
        };
    }
}
