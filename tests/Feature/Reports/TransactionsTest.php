<?php

namespace Tests\Feature\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use App\Models\Transaction;
use App\Enums\TransactionStatus;

class TransactionsTest extends TestCase
{
    public function test_admin_can_view_monthly_transactions_report(): void
    {
        //paidTransaction
        $paidTransaction = Transaction::factory()->create();
        $paidTransaction->status = TransactionStatus::PAID;
        $paidTransaction->save();
        //overdueTransaction
        Transaction::factory()->create(['due_on' => Carbon::yesterday()->format('Y-m-d')]);
        //outstandingTransaction
        Transaction::factory()->create(['due_on' => Carbon::tomorrow()->format('Y-m-d')]);
        $response = $this->actingAs($this->admin)->getJson(route('reports.transactions.monthly'));

        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'The Monthly Transactions Report Retrieved Successfuly!',
            'data' => [
                [
                    'PAID' => '1',
                    'OUTSTANDING' => '1',
                    'OVER_DUE' => '1',
                    'year' => 2023,
                    'month' => 12,
                ]
            ]
        ]);
    }

    public function test_user_can_not_view_monthly_transactions_report(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('reports.transactions.monthly'));
        $this->assertUnauthorized($response);
    }
}
