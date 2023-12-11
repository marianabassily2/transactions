<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository 
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Payment::class;
    }

}
