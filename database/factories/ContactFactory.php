<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = \App\Models\User::pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'subject' => $this->faker->optional()->sentence(),
            'message' => $this->faker->paragraph(),
            'is_read' => $this->faker->boolean(20),
            'read_at' => null,
            'user_id' => $this->faker->randomElement($users),
        ];
    }
}
