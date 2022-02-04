<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => 1,
            'location'      => $this->faker->country(),
            'visited'       => (rand(0,1)?false:true),
            'visited_at'    => $this->faker->date(),
        ];
    }
}
