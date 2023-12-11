<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use App\Http\Requests\API\StoreTransactionRequest;

class TransactionController extends Controller
{

    public function __construct(private TransactionRepository $transactionRepository)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(TransactionResource::collection($this->transactionRepository->all()),'Transactions Retrieved Successfuly!');
    }

    public function indexByPayer()
    {
         return $this->sendResponse(TransactionResource::collection($this->transactionRepository->getByPayer(auth()->user()->id)),'Transactions Retrieved Successfuly!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $this->transactionRepository->create($request->validated());
        return $this->sendSuccess('Transaction Created Successfuly!',201);
    }

}
