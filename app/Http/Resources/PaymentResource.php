<?php

namespace App\Http\Resources;

class PaymentResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->formatAmount($this->amount),
            'trasnaction' => $request->expanded ? new TransactionResource($this->transaction) : $this->transaction->id,
            'paid_on' => $this->paid_on,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}