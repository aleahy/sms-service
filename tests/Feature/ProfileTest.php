<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * @test
     */
    public function test_user_can_update_password()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $this->actingAs($user);

        $this->patch('/profile/password', [
            'current_password' => 'password',
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ])->assertSessionDoesntHaveErrors()->assertRedirect();

        $user->refresh();

        $this->assertTrue(Hash::check('new_password', $user->password));
    }

    /**
     * @test
     * @dataProvider invalidPasswordData
     */
    public function test_password_form_is_validated($key, $value)
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $this->actingAs($user);

        $this->patch('/profile/password', [
            $key => $value
        ])->assertSessionHasErrors($key);
    }

    public function invalidPasswordData()
    {
        return [
            ['current_password', ''],
            ['current_password', 'something wrong'],
            ['password', ''],
        ];
    }
}
