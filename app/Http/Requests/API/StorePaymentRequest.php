<?php

namespace App\Http\Requests\API;

use App\Models\Payment;
use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }
    
    public function prepareForValidation()
    {
        $this->merge(['transation' => $this->transactionRepository->find($this->route('transaction'))->first()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = Payment::$rules;
        $rules['amount'] = $rules['amount'].'|lte:'.$this->transation->amount;
        return $rules;
    }
}
