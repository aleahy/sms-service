<?php

namespace Tests\Feature;

use App\Models\SMS;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
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
}
