<?php

namespace Modules\Agent\Database\factories;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\AgentPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Agent\Entities\Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $agentPackage = AgentPackage::inRandomOrder()->first();
        $country = Country::inRandomOrder()->first();

        return [
            'agent_package_id' => $agentPackage->id,
            'country_id' => $country->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('123456'),
            'iso2' => $this->faker->countryCode,
            'dial_code' => $this->faker->numerify('###'),
            'phone' => $this->faker->unique()->phoneNumber,
            'formatted_phone' => $this->faker->phoneNumber,
            'image' => $this->faker->imageUrl(),
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'timezone' => $this->faker->timezone,
            'status' => $this->faker->randomElement(['Active', 'Suspended', 'Inactive']),
            'remember_token' => Str::random(10),
        ];
    }
}

