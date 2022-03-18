<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class sectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'section_name' => $this->faker->name(),
            'description' => $this->faker->word(),
            'created_by' => 'mohamed'
        ];
    }
}
