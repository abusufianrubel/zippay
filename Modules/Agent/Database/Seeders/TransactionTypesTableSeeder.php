<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionTypes = [
            ['name' => 'Cashin'],
            ['name' => 'Cashout'],
        ];

        DB::table('transaction_types')->insert($transactionTypes);
    }
}
