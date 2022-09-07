<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SMS>
 */
class SMSFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sender_id' => null,
            'recipient_id' => (User::factory()),
            'from_phone_number' => $this->faker->phoneNumber(),
            'to_phone_number' => $this->faker->phoneNumber(),
            'message' => $this->faker->paragraph(),
            'sent' => true,
        ];
    }

    public function sentSMS()
    {
        return $this->state(function (array $attributes) {
            return [
                'sender_id' => null,
                'recipient_id' => User::factory(),
                'sent' => true,
            ];
        });
    }

    public function receivedSMS()
    {
        return $this->state(function (array $attributes) {
            return [
                'sender_id' => User::factory(),
                'recipient_id' => null,
                'sent' => false,
            ];
        });
    }
}
