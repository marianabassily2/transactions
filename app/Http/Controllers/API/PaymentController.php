<?php

namespace App\Http\Controllers\API;

use App\Models\Payment;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentRepository;
use App\Http\Requests\API\StorePaymentRequest;
use App\Http\Requests\API\UpdatePaymentRequest;

class PaymentController extends Controller
{
    public function __construct(private PaymentRepository $paymentRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        return $this->sendResponse(PaymentResource::collection($transaction->payments),'Payments Retrieved Successfuly!');
    }

    public function indexAll()
    {
        return $this->sendResponse(PaymentResource::collection($this->paymentRepository->all()),'Payments Retrieved Successfuly!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request, Transaction $transaction)
    {
        $transaction->payments()->create($request->validated());
        return $this->sendSuccess('Payment Created Successfuly!',201);
    }

}
