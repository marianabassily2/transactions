<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\Transaction;
use App\Observers\PaymentObserver;
use App\Observers\TransactionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Transaction::observe(TransactionObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
