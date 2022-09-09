<?php

namespace Tests\Feature;

use App\Models\SMS;
use App\Models\User;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReceivedSMSTest extends TestCase
{
   /**
    * @test
    */
   public function test_user_can_view_the_recieved_sms_pages()
   {
       $sms = SMS::factory()->receivedSMS()->create();

       $this->logIn();

       $this->get(route('sms.received.index'))
           ->assertOk()
           ->assertInertia(function(AssertableInertia $page) use ($sms) {
               $page->component('ReceivedSMS/Index')
                   ->has('smss.data', 1)
                   ->where('smss.data.0.id', $sms->id);
           });
   }

   /**
    * @test
    */
   public function test_a_sent_sms_isnt_counted_with_the_received_smss()
   {
       $sms = SMS::factory()->sentSMS()->create();

       $this->logIn();

       $this->get(route('sms.received.index'))
           ->assertOk()
           ->assertInertia(function(AssertableInertia $page) use ($sms) {
               $page->component('ReceivedSMS/Index')
                   ->has('smss.data', 0);
           });
   }

   /**
    * @test
    */
   public function test_system_can_receive_an_sms()
   {
       $user = User::factory()->create();
       Sanctum::actingAs($user, [User::TOKEN_ABILITY_SEND_SMS]);

       $this->assertDatabaseMissing('sms', [
           'to_phone_number' => '+61 123456789',
           'from_phone_number' => '+61 987654321',
           'message' => 'The message',
           'sender_id' => $user->id,
           'sent' => false,
       ]);

       $this->postJson(route('api.sms.received.store'), [
           'to' => '+61 123456789',
           'from' => '+61 987654321',
           'message' => 'The message',
       ])->assertSuccessful();

       $this->assertDatabaseHas('sms', [
           'to_phone_number' => '+61 123456789',
           'from_phone_number' => '+61 987654321',
           'message' => 'The message',
           'sender_id' => $user->id,
           'sent' => false,
       ]);
   }

   /**
    * @test
    * @dataProvider invalidSMSData
    */
   public function test_system_validates_received_sms($key, $value, $error)
   {
       $user = User::factory()->create();
       Sanctum::actingAs($user, [User::TOKEN_ABILITY_SEND_SMS]);

       $this->assertDatabaseCount('sms', 0);

       $this->postJson(route('api.sms.received.store'), [
           $key => $value
       ])->assertJsonValidationErrors([
           $key => $error
       ]);

       $this->assertDatabaseCount('sms', 0);
   }

    public function invalidSMSData()
    {
        return [
            'To Phone Required' => ['to', '', 'required'],
            'To Phone not too large' => ['to', Str::random(16), 'greater'],
            'From Phone not too large' => ['from', Str::random(16), 'greater'],
            'From Phone Required' => ['from', '', 'required'],
            'Message required' => ['message', '', 'required'],
            'Message not too large' => ['message', Str::random(1601), 'greater'],
        ];
   }
}
