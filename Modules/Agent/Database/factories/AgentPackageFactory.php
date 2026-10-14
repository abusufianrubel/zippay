<?php

namespace Modules\Agent\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgentPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Agent\Entities\AgentPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'fee' => $this->faker->randomFloat(8, 1, 100),
            'is_default' => $this->faker->randomElement(['No', 'No']),
        ];
    }
}

