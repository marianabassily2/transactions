<?php

namespace App\Models;

use App\Models\Transaction;


class Payment extends BaseModel
{
    protected $fillable = ['amount','transaction_id','paid_on','details'];
    
    public static $rules = [
        'amount' => 'required|integer|min:100',
        'details' => 'nullable|min:1|max:1000'
    ];
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
