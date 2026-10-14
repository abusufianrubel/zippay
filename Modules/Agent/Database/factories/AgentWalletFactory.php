<?php

namespace Modules\Agent\Database\factories;

use App\Models\Currency;
use Modules\Agent\Entities\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentWalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Agent\Entities\AgentWallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $agent = Agent::inRandomOrder()->first();
        $currency = Currency::inRandomOrder()->first();

        return [
            'agent_id' => $agent->id,
            'currency_id' => $currency->id,
            'balance' => $this->faker->randomFloat(8, 0, 1000),
            'is_default' => $this->faker->randomElement(['No', 'No']),
        ];
    }
}

