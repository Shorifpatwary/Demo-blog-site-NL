<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address(),
            'country_id' => Country::pluck('id')->random(),
            'state_id' => State::pluck('id')->random(),
            'city_id' => City::pluck('id')->random(),
            'department_id' => Department::pluck('id')->random(),
            'zip_code' => fake()->numberBetween(1000, 9999),
            'birth_date' => fake()->dateTimeBetween('-20 year', '-10 year'),
            'date_hired' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
