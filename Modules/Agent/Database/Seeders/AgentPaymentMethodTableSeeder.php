<?php

namespace Modules\Agent\Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AgentPaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        PaymentMethod::insert([
            ['name' => 'Cash', 'status' => 'Active']
        ]);
    }
}
