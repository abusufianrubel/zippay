<?php

namespace Modules\Agent\Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\TransactionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentFeesLimitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethod = PaymentMethod::where('name', 'Cash')->first();
        $transactionTypes = TransactionType::whereIn('name', ['Cashin', 'Cashout'])->get();

        if (checkDemoEnvironment()) {
            DB::table('fees_limits')->insert(array(
                array(
                    'currency_id' => getCurrencyId('USD'),
                    'transaction_type_id' => $transactionTypes[0]->id,
                    'payment_method_id' => $paymentMethod->id,
                    'charge_percentage' => '2.50000000',
                    'charge_fixed' => '2.00000000',
                    'min_limit' => '1.00',
                    'max_limit' => null,
                    'processing_time' => '0',
                    'has_transaction' => 'Yes',
                ),
                array(
                    'currency_id' => getCurrencyId('USD'),
                    'transaction_type_id' => $transactionTypes[1]->id,
                    'payment_method_id' => $paymentMethod->id,
                    'charge_percentage' => '2.50000000',
                    'charge_fixed' => '1.00000000',
                    'min_limit' => '1.00000000',
                    'max_limit' => null,
                    'processing_time' => '0',
                    'has_transaction' => 'Yes',
                ),
            ));
        } else {
            DB::table('fees_limits')->insert(array(
                array(
                    'currency_id' => getCurrencyId('USD'),
                    'transaction_type_id' => $transactionTypes[0]->id,
                    'payment_method_id' => $paymentMethod->id,
                    'charge_percentage' => '0.00000000',
                    'charge_fixed' => '0.00000000',
                    'min_limit' => '1.00',
                    'max_limit' => null,
                    'processing_time' => '0',
                    'has_transaction' => 'Yes',
                ),
                array(
                    'currency_id' => getCurrencyId('USD'),
                    'transaction_type_id' => $transactionTypes[1]->id,
                    'payment_method_id' => $paymentMethod->id,
                    'charge_percentage' => '0.00000000',
                    'charge_fixed' => '0.00000000',
                    'min_limit' => '1.00000000',
                    'max_limit' => null,
                    'processing_time' => '0',
                    'has_transaction' => 'Yes',
                ),
            ));
        }

        
    }
}
