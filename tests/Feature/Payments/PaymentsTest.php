<?php

namespace Tests\Feature\Payments;

use App\Enums\TransactionStatus;
use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use App\Models\Transaction;

class PaymentsTest extends TestCase
{
    public function test_user_can_not_store_payment(): void
    {
        $paymentData = Payment::factory()->make()->toArray();
        $transaction = Transaction::factory()->create();
        $response = $this->actingAs($this->customer)->postJson( route('transactions.payments.store',['transaction' => $transaction->id]),$paymentData);
        $this->assertUnauthorized($response);

    }

    public function test_admin_can_store_payment(): void
    {
        $transaction = Transaction::factory()->create();
        $paymentData = Payment::factory()->make()->toArray();
        $response = $this->actingAs($this->admin)->postJson( route('transactions.payments.store',['transaction' => $transaction->id]),$paymentData);
        $response->assertStatus(201)->assertJson([
            'success' => true,
        ]);
    }

    public function test_admin_can_fully_pay_transaction(): void
    {
        $transaction = Transaction::factory()->create();
        $paymentData = Payment::factory()->make(['amount' => $transaction->amount ])->toArray();
        $response = $this->actingAs($this->admin)->postJson( route('transactions.payments.store',['transaction' => $transaction->id]),$paymentData);
        $response->assertStatus(201)->assertJson([
            'success' => true,
        ]);
        $transaction = Transaction::find($transaction->id);
        $this->assertEquals( $transaction->status,TransactionStatus::PAID);
    }

    public function test_admin_can_view_payment(): void
    {
        $payment = Payment::factory()->create();
        $response = $this->actingAs($this->admin)->getJson(route('transactions.payments.indexAll'));
        $this->assertSuccessAndSee($response,$payment->id);

    }

    public function test_user_can_not_view_payment(): void
    {
        Payment::factory()->create();
        $response = $this->actingAs($this->customer)->getJson(route('transactions.payments.indexAll'));
        $this->assertUnauthorized($response);
    }

    public function test_customer_can_view_his_payments(): void
    {
        $transaction = Transaction::factory()->create(['payer_id' => $this->customer->id]);
        $payment = Payment::factory()->create(['transaction_id' => $transaction->id]);
        $response = $this->actingAs($this->customer)->getJson( route('transactions.payments.index', ['transaction' => $transaction->id]));
        $this->assertSuccessAndSee($response,$payment->id);

    }
}
