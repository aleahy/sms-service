<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function test_user_can_get_a_list_of_users()
    {
        $users = User::factory(50)->create();
        $this->actingAs($users->first());


        $this->get(route('users.index'))
            ->assertOk()
            ->assertInertia(function (Assert $page) use ($users) {
                $page->component('Users/Index')
                    ->has('users.data', 20)
                    ->where('users.data.0.name', $users->first()->name)
                    ->where('users.data.0.id', $users->first()->id);
            });
    }

    /**
     * @test
     */
    public function test_a_user_can_create_a_user()
    {
        //Logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertDatabaseMissing('users', [
            'name' => 'Alex',
            'email' => 'alex@example.com'
        ]);
        //Post Request
        $this->postJson(route('users.store'), [
            'name' => 'Alex',
            'email' => 'alex@example.com'
        ])->assertSuccessful()
            ->assertJson([
                'user' => [
                    'name' => 'Alex',
                    'email' => 'alex@example.com'
                ]
            ]);

        //User exists in database
        $this->assertDatabaseHas('users', [
            'name' => 'Alex',
            'email' => 'alex@example.com'
        ]);
    }

}
