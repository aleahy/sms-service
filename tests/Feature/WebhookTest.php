<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Webhook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    /**
     * @test
     */
    public function test_a_users_webhook_can_be_saved()
    {
        $user = User::factory()->create();

        $this->logIn();

        $this->post(route('users.webhook.store', ['user' => $user]),[
            'webhook_url' => 'https://test.com/webhook'
        ])->assertJsonStructure(['secret']);

        $this->assertDatabaseHas('webhooks', [
            'user_id' => $user->id,
            'url' => 'https://test.com/webhook',
        ]);

        $webhook = Webhook::where('user_id', $user->id)->first();
        $this->assertNotNull($webhook->secret);
    }

    /**
     * @test
     */
    public function test_a_webhook_can_be_updated()
    {
        $user = User::factory()->has(Webhook::factory())->create();

        $this->logIn();

        $this->post(route('users.webhook.store', ['user' => $user]),[
            'webhook_url' => 'https://test.com/webhook'
        ])->assertNoContent();

        $this->assertDatabaseHas('webhooks', [
            'user_id' => $user->id,
            'url' => 'https://test.com/webhook',
        ]);

        $webhook = Webhook::where('user_id', $user->id)->first();
        $this->assertNotNull($webhook->secret);
    }

    /**
     * @test
     */
    public function test_a_webhook_must_be_valid()
    {
        $user = User::factory()->create();

        $this->logIn();

        $this->postJson(route('users.webhook.store', ['user' => $user]), [
            'webhook_url' => 'string'
        ])->assertJsonValidationErrors(['webhook_url' => 'URL']);

        $this->postJson(route('users.webhook.store', ['user' => $user]), [
            'webhook_url' => ''
        ])->assertJsonValidationErrors(['webhook_url' => 'required']);
    }

    /**
     * @test
     */
    public function test_a_webhook_can_be_deleted()
    {
        $this->logIn();
        $user = User::factory()->has(Webhook::factory())->create();

        $this->assertDatabaseHas('webhooks', [
            'user_id' => $user->id
        ]);

        $this->delete(route('users.webhook.delete', ['user' => $user]))
            ->assertRedirect(route('users.show', ['user' => $user]));

        $this->assertDatabaseMissing('webhooks', [
            'user_id' => $user->id
        ]);
    }
}
