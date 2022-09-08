<?php

namespace Tests\Feature;

use App\Models\SMS;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
