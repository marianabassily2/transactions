<?php

namespace Tests\Feature\Transactions;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Enums\TransactionStatus;

class TransactionsTest extends TestCase
{
    public function test_user_can_not_store_transaction(): void
    {
        $transactionData = Transaction::factory()->make()->toArray();
        $response = $this->actingAs($this->customer)->postJson(route('transactions.store'), $transactionData);
        $this->assertUnauthorized($response);
    }

    public function test_admin_can_store_transaction(): void
    {
        $transactionData = Transaction::factory()->make()->toArray();
        $response = $this->actingAs($this->admin)->postJson(route('transactions.store'), $transactionData);
        $response->assertStatus(201)->assertJson([
            'success' => true,
        ]);
    }

    public function test_admin_can_view_transaction(): void
    {
        $transaction = Transaction::factory()->create();
        $response = $this->actingAs($this->admin)->getJson(route('transactions.index'));
        $this->assertSuccessAndSee($response, $transaction->id);
    }

    public function test_view_over_due_transaction(): void
    {
        Transaction::factory()->create(['due_on' => Carbon::yesterday()]);
        $response = $this->actingAs($this->admin)->getJson(route('transactions.index'));
        $this->assertSuccessAndSee($response, 'Overdue');
    }

    public function test_view_oustanding_transaction(): void
    {
        Transaction::factory()->create(['due_on' => Carbon::tomorrow()]);
        $response = $this->actingAs($this->admin)->getJson(route('transactions.index'));
        $this->assertSuccessAndSee($response, 'Outstanding');
    }

    public function test_view_oustanding_transaction_become_overdue(): void
    {
        $transaction = Transaction::factory()->create(['due_on' => Carbon::tomorrow()]);
        $response = $this->actingAs($this->admin)->getJson(route('transactions.index'));
        $this->assertSuccessAndSee($response, 'Outstanding');
        $transaction->update(['due_on' => Carbon::yesterday()]);
        $response = $this->actingAs($this->admin)->getJson(route('transactions.index'));
        $this->assertSuccessAndSee($response, 'Overdue');
    }


    public function test_user_can_not_view_transaction(): void
    {

        Transaction::factory()->create();
        $response = $this->actingAs($this->customer)->getJson(route('transactions.index'));
        $this->assertUnauthorized($response);
    }

    public function test_customer_can_view_his_transactions(): void
    {
        $transaction = Transaction::factory()->create(['payer_id' => $this->customer->id]);
        $response = $this->actingAs($this->customer)->getJson(route('customers.transactions.index'));
        $this->assertSuccessAndSee($response, $transaction->id);
    }
}
