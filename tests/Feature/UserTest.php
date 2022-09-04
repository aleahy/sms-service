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
                    ->has('users.data', 15)
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
        ])->assertRedirect();


        //User exists in database
        $this->assertDatabaseHas('users', [
            'name' => 'Alex',
            'email' => 'alex@example.com'
        ]);
    }

    /**
     * @test
     */
    public function test_a_user_can_delete_a_user()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $this->logIn()
            ->delete(route('users.destroy', ['user' => $user]))
            ->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    public function test_a_user_can_update_a_user()
    {
        $user = User::factory()->create([
            'name' => 'First Name',
            'email' => 'first@example.com'
        ]);

        $this->logIn()
            ->patchJson(route('users.update', ['user' => $user]), [
                'name' => 'New Name',
                'email' => 'new@example.com'
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

//    /**
//     * @test
//     */
//    public function test_a_user_can_be_created_with_a_webhook()
//    {
//        $this->logIn()
//            ->assertDatabaseMissing('users', [
//                'email' => 'email@example.com',
//            ])
//            ->postJson(route('users.store'), [
//                'name' => 'Name',
//                'email' => 'email@example.com',
//                'webhook_url' => 'https://test.url.com/webhook',
//            ])
//            ->assertSuccessful()
//            ->assertJsonStructure([
//                'token', 'secret'
//            ]);
//
//        $user = User::where('email', 'email@example.com')->first();
//
//        $this->assertDatabaseHas('users', [
//            'email' => 'email@example.com'
//        ])->assertDatabaseHas('webhooks', [
//            'user_id' => $user->id,
//            'url' => 'https://test.url.com/webhook'
//        ]);
//
//        $this->assertDatabaseHas('personal_access_tokens', [
//            'tokenable_id' => $user->id,
//            'tokenable_type' => User::class,
//        ]);
//
//    }
//
//    /**
//     * @test
//     */
//    public function test_creating_a_user_without_a_webhook_does_not_generate_a_token_or_secret()
//    {
//        $this->logIn()
//            ->assertDatabaseMissing('users', [
//                'email' => 'email@example.com',
//            ])
//            ->postJson(route('users.store'), [
//                'name' => 'Name',
//                'email' => 'email@example.com',
//                'webhook_url' => '',
//            ])
//            ->assertSuccessful()
//            ->assertNoContent();
//
//        $createdUser = User::where('email', 'email@example.com')->first();
//        $this->assertDatabaseMissing('webhooks', ['user_id' => $createdUser->id]);
//        $this->assertDatabaseMissing('personal_access_tokens', [
//            'tokenable_id' => $createdUser->id,
//            'tokenable_type' => User::class,
//        ]);
//    }

    /**
     * @test
     * @dataProvider invalidStoreAttributes
     */
    public function test_store_validation_rules($key, $value, $error)
    {
        User::factory()->create([
            'email' => 'taken@email.com'
        ]);
        $this->logIn()
            ->postJson(route('users.store'), [
                $key => $value
            ])->assertJsonValidationErrors([
                $key => $error
            ]);
    }

    /**
     * @test
     * @dataProvider invalidStoreAttributes
     */
    public function test_update_validation_rules($key, $value, $error)
    {
        User::factory()->create([
            'email' => 'taken@email.com'
        ]);

        $user = User::factory()->create();
        $this->logIn()
            ->patchJson(route('users.update', ['user' => $user]), [
                $key => $value
            ])->assertJsonValidationErrors([
                $key => $error
            ]);
    }
    public function invalidStoreAttributes()
    {
        return [
            ['name', '', 'required'],
            ['email', '', 'required'],
            ['email', 'string', 'email'],
            ['email', '', 'required'],
            ['email', 'taken@email.com', 'taken'],
        ];
    }

    /**
     * @test
     */
    public function test_a_user_can_update_their_name_and_keep_the_email_address_the_same()
    {
        $user = User::factory()->create([
            'name' => 'First Name',
            'email' => 'same@example.com'
        ]);

        $this->logIn()
            ->patchJson(route('users.update', ['user' => $user]), [
                'name' => 'New Name',
                'email' => 'same@example.com'
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'same@example.com'
        ]);
    }
}
