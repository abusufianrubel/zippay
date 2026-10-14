<?php

namespace Modules\Agent\Database\factories;

use App\Models\User;
use App\Models\Currency;
use App\Models\PaymentMethod;
use Modules\Agent\Entities\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashInFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Agent\Entities\CashIn::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $agent = Agent::inRandomOrder()->first();
        $currency = Currency::inRandomOrder()->first();
        $paymentMethod = PaymentMethod::where('name', 'Cash')->first();
    
        return [
            'user_id' => $user->id,
            'agent_id' => $agent->id,
            'agent_package_id' => $agent->agent_package_id,
            'currency_id' => $currency->id,
            'payment_method_id' => $paymentMethod->id,
            'uuid' => $this->faker->unique()->uuid,
            'agent_percentage' => $this->faker->randomFloat(2, 0, 5),
            'charge_percentage' => $this->faker->randomFloat(2, 0, 5),
            'charge_fixed' => $this->faker->randomFloat(2, 0, 10),
            'subtotal' => $this->faker->randomFloat(2, 100, 200),
            'amount' => $this->faker->randomFloat(2, 100, 200),
            'total' => $this->faker->randomFloat(2, 100, 200),
            'status' => 'Success',
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

