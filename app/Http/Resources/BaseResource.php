<?php

namespace App\Http\Resources;

use App\Traits\ApiRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    CONST AMOUNT_FACTOR = 100;

    protected function formatAmount($amount)
    {
        return $amount / self::AMOUNT_FACTOR . ' EGP';
    }

    protected function getLocale()
    {
        return app()->getLocale();
    }
}
