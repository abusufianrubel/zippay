<?php

namespace Modules\Agent\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Agent\Entities\Cashin;
use Modules\Agent\Entities\Cashout;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'user_id' => getUserByEmail('kyla@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'end_user_id' => null,
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'merchant_id' => null,
                'bank_id' => null,
                'file_id' => null,
                'uuid' => 'E0400EA9F10D5',
                'refund_reference' => null,
                'transaction_reference_id' => getTransactionReferenceId(Cashin::class, 'E0400EA9F10D5'),
                'transaction_type_id' => getTransactionTypeId('Cashin'),
                'user_type' => 'registered',
                'email' => null,
                'phone' => null,
                'subtotal' => '10.00000000',
                'percentage' => '2.50000000',
                'charge_percentage' => '0.25000000',
                'charge_fixed' => '2.00000000',
                'total' => '12.15000000',
                'note' => null,
                'payment_status' => null,
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
                'agent_percentage' => '0.10',
            ],
            [
                'user_id' => getUserByEmail('irish@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'end_user_id' => null,
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'merchant_id' => null,
                'bank_id' => null,
                'file_id' => null,
                'uuid' => '929353787154C',
                'refund_reference' => null,
                'transaction_reference_id' => getTransactionReferenceId(Cashin::class, '929353787154C'),
                'transaction_type_id' => getTransactionTypeId('Cashin'),
                'user_type' => 'registered',
                'email' => null,
                'phone' => null,
                'subtotal' => '10.00000000',
                'percentage' => '2.50000000',
                'charge_percentage' => '0.25000000',
                'charge_fixed' => '2.00000000',
                'total' => '12.15000000',
                'note' => null,
                'payment_status' => null,
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
                'agent_percentage' => '0.10',
            ],
            [
                'user_id' => getUserByEmail('kyla@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'end_user_id' => null,
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'merchant_id' => null,
                'bank_id' => null,
                'file_id' => null,
                'uuid' => '31B796C206CE8',
                'refund_reference' => null,
                'transaction_reference_id' => getTransactionReferenceId(Cashout::class, '31B796C206CE8'),
                'transaction_type_id' => getTransactionTypeId('Cashout'),
                'user_type' => 'registered',
                'email' => null,
                'phone' => null,
                'subtotal' => '5.00000000',
                'percentage' => '2.50000000',
                'charge_percentage' => '0.12500000',
                'charge_fixed' => '1.00000000',
                'total' => '5.05000000',
                'note' => null,
                'payment_status' => null,
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
                'agent_percentage' => '0.05',
            ],
            [
                'user_id' => getUserByEmail('irish@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'end_user_id' => null,
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'merchant_id' => null,
                'bank_id' => null,
                'file_id' => null,
                'uuid' => '52EB4B2E8C1A4',
                'refund_reference' => null,
                'transaction_reference_id' => getTransactionReferenceId(Cashout::class, '52EB4B2E8C1A4'),
                'transaction_type_id' => getTransactionTypeId('Cashout'),
                'user_type' => 'registered',
                'email' => null,
                'phone' => null,
                'subtotal' => '5.00000000',
                'percentage' => '2.50000000',
                'charge_percentage' => '0.12500000',
                'charge_fixed' => '1.00000000',
                'total' => '5.05000000',
                'note' => null,
                'payment_status' => null,
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
                'agent_percentage' => '0.05',
            ],
        ]);
    }
}
