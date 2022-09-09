<?php

namespace Tests\Feature;

use App\Models\SMS;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Spatie\WebhookServer\CallWebhookJob;
use Tests\TestCase;

class SMSTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_get_details_of_an_sms()
    {
        $sms = SMS::factory()->create();

        $this->logIn();
        $this->get(route('sms.show', ['sms' => $sms]))
            ->assertOk();
    }

    /**
     * @test
     */
    public function test_it_can_send_an_sms()
    {
        Queue::fake();

        $recipient = User::factory()->has(Webhook::factory())->create();
        $message = "Hello";
        $fromPhone = '+61 123456789';
        $this->logIn();

        $this->post(route('sms.store'), [
            'recipient_id' => $recipient->id,
            'from' => $fromPhone,
            'message' => $message,
        ]);

        $this->assertDatabaseHas('sms', [
            'recipient_id' => $recipient->id,
            'message' => $message,
            'from_phone_number' => $fromPhone,
            'sent' => true,
        ]);

        Queue::assertPushed(CallWebhookJob::class);
    }

    /**
     * @test
     * @dataProvider invalidSMS
     */
    public function test_sending_sms_is_validated($key, $value, $error)
    {
        Queue::fake();
        $this->logIn();
        $this->assertDatabaseCount('sms', 0);

        $this->postJson(route('sms.store'), [
            $key => $value
        ])->assertJsonValidationErrors([
            $key => $error
        ]);

        Queue::assertNothingPushed();
        $this->assertDatabaseCount('sms', 0);
    }

    public function invalidSMS()
    {
        return [
            'Recipient ID is required' => ['recipient_id', '', 'required'],
            'Recipient ID is a number' => ['recipient_id', 'string', 'number'],
            'Message is required' => ['message', '', 'required'],
            'Message cannot be longer than 1600 characters' => ['message', Str::random(1601), 'greater than 1600'],
            'From phone number is required' => ['from', '', 'required'],
        ];
    }

    public function test_the_recipient_must_exist()
    {
        Queue::fake();
        $this->logIn();
        $this->assertDatabaseCount('sms', 0);

        $maxId = User::query()->orderBy('id', 'desc')->first()->id;
        $this->postJson(route('sms.store'), [
            'recipient_id' => $maxId + 1,
        ])->assertJsonValidationErrors([
            'recipient_id' => 'invalid'
        ]);

        Queue::assertNothingPushed();
        $this->assertDatabaseCount('sms', 0);
    }
    /**
     * @test
     */
    public function test_sms_recipient_must_have_a_webhook()
    {
        Queue::fake();
        $this->logIn();
        $this->assertDatabaseCount('sms', 0);

        $user = User::factory()->create();
        $this->assertDatabaseMissing('webhooks', ['user_id' => $user->id]);

        $this->postJson(route('sms.store'), [
            'recipient_id' => $user->id
        ])->assertJsonValidationErrors([
            'recipient_id' => 'cannot receive SMS',
        ]);

        Queue::assertNothingPushed();
        $this->assertDatabaseCount('sms', 0);
    }
}
