<?php

namespace Database\Factories;

use App\Models\BusinessInquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BusinessInquiry>
 */
class BusinessInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'email' => $this->faker->safeEmail(),
            'campaign_type' => $this->faker->randomElement(['sponsorship', 'product-placement', 'event', 'other']),
            'budget' => $this->faker->randomElement(['$1,000 - $5,000', '$5,000 - $10,000', null]),
            'timeline' => $this->faker->randomElement(['Q1 2026', 'Q2 2026', null]),
            'message' => $this->faker->paragraph(),
            'is_read' => false,
        ];
    }
}
