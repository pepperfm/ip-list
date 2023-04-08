<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Network;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->ipv4(),
            'frozen' => $this->faker->boolean(),

            'network_id' => Network::factory(),
        ];
    }
}
