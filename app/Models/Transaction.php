<?php

namespace App\Models;

use App\Enums\TransactionStatus;

class Transaction extends BaseModel
{
    protected $fillable = ['amount','user_id','status','due_on','vat','is_vat_inclusive','payer_id'];

    protected $dates = ['due_on'];

    public static $rules = [
        'amount' => 'required|integer|min:100',
        'due_on' => 'required|date:Y-m-d',
        'vat' => 'required|integer|min:1|max:100',
        'is_vat_inclusive' => 'required|boolean',
        'payer_id' => 'exists:users,id'
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
    ];

    public function customer()
    {
        return $this->belongsTo(User::class,'payer_id','id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function scopePayer($query,$id)
    {
        return $query->where('payer_id', $id);
    }
}
