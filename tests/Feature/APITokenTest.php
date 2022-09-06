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

    /**
     * @test
     */
    public function test_a_user_can_delete_an_api_token()
    {
        $this->logIn();

        $user = User::factory()->create();

        $token = $user->createToken(User::TOKEN_SEND_SMS, [User::TOKEN_ABILITY_SEND_SMS])
                    ->accessToken;

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
            'name' => User::TOKEN_SEND_SMS
        ]);

        $this->delete(route('users.sms-token.delete', ['user' => $user, 'token' => $token->id]))
            ->assertRedirect(route('users.show', ['user' => $user]));

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
            'name' => User::TOKEN_SEND_SMS
        ]);
    }


}
