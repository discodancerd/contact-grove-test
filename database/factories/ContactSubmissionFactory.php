<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'subject' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'ip' => Arr::random([fake()->ipv4(), fake()->ipv6()]),
            'ua' => fake()->userAgent(),
            'attachment' => fake()->uuid(),
        ];
    }
}
