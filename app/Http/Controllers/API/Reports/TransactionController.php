<?php

namespace App\Http\Controllers\API\Reports;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;

class TransactionController extends Controller
{

    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function monthly()
    {
        $data = $this->transactionRepository->getMonthlyReport(request()->from,request()->to);
        return $this->sendResponse($data,'The Monthly Transactions Report Retrieved Successfuly!');
    }

}
