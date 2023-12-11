<?php

namespace App\Http\Resources;

use App\Enums\TransactionStatus;

class TransactionResource extends BaseResource
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
            'payer' => $request->expanded ? $this->customer : $this->customer->email,
            'due_on' => $this->due_on,
            'vat' => $this->vat,
            'is_vat_inclusive' => (bool)$this->is_vat_inclusive,
            'status' => TransactionStatus::getStatus($this->status,$this->due_on),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}