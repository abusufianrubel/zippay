<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CurrencyPaymentMethodsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_payment_methods')->delete();
        
        DB::table('currency_payment_methods')->insert([
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Stripe'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"secret_key":"sk_test_UWTgGYIdj8igmbVMgTi0ILPm","publishable_key":"pk_test_c2TDWXsjPkimdM8PIltO6d8H"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Paypal'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"client_id":"AXxJWNphTMdyaHZmHv58qH3wFt0bai9j_t_a8R6T7EkC1GbT7-0AvgsULqFz4cqW44H1adjfwjWMdLmk","client_secret":"EJKgSAHOwbiEaLSC-tLDD2tFWQ6Wvx5yawYdEoI7k-FAAEQJAkYNnyxhHzLd3Pm-_r192GpuEcNfWT80","mode":"sandbox"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('EUR'),
                'method_id' => getPaymentMethodId('Paypal'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"client_id":"AXxJWNphTMdyaHZmHv58qH3wFt0bai9j_t_a8R6T7EkC1GbT7-0AvgsULqFz4cqW44H1adjfwjWMdLmk","client_secret":"EJKgSAHOwbiEaLSC-tLDD2tFWQ6Wvx5yawYdEoI7k-FAAEQJAkYNnyxhHzLd3Pm-_r192GpuEcNfWT80","mode":"sandbox"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('GBP'),
                'method_id' => getPaymentMethodId('Stripe'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"secret_key":"sk_test_UWTgGYIdj8igmbVMgTi0ILPm","publishable_key":"pk_test_c2TDWXsjPkimdM8PIltO6d8H"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('GBP'),
                'method_id' => getPaymentMethodId('Paypal'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"client_id":"AXxJWNphTMdyaHZmHv58qH3wFt0bai9j_t_a8R6T7EkC1GbT7-0AvgsULqFz4cqW44H1adjfwjWMdLmk","client_secret":"EJKgSAHOwbiEaLSC-tLDD2tFWQ6Wvx5yawYdEoI7k-FAAEQJAkYNnyxhHzLd3Pm-_r192GpuEcNfWT80","mode":"sandbox"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('EUR'),
                'method_id' => getPaymentMethodId('Stripe'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"secret_key":"sk_test_UWTgGYIdj8igmbVMgTi0ILPm","publishable_key":"pk_test_c2TDWXsjPkimdM8PIltO6d8H"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":1}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":2}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":3}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('GBP'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":4}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('EUR'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":5}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Flutterwave'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"public_key":"FLWPUBK_TEST-65b5f042a78d599b31e98c481eb88ec8-X","secret_key":"FLWSECK_TEST-a079ff40517be8d1994fb0c3bb15c775-X","secret_hash":"LKECxxatK9c~Vn!"}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
