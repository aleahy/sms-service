<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APITokenTest extends TestCase
{
    /**
     * @test
     */
    public function test_a_user_can_create_an_API_token_for_a_user()
    {
        $this->logIn();

        $user = User::factory()->create();

        $this->post(route('users.sms-token.store', ['user' => $user]))
            ->assertSuccessful()
            ->assertJsonStructure(['token']);
    }


}
