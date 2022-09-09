<?php

namespace Tests\Feature;

use App\Models\SMS;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\Queue;
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
}
