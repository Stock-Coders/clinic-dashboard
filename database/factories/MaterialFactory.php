<?php

namespace Database\Factories;

// use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MaterialFactory extends Factory
{
    // protected $model = Medicine::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'             => $this->faker->title(),
            'description'       => $this->faker->sentence(6),
            'quantity'          => $this->faker->numberBetween(1, 50),
            'cost'              => $this->faker->randomFloat(2, 0.01, 99.99),
            'expiration_date'   => $this->faker->dateTimeBetween('now', '+2 years'),
            'representative_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
