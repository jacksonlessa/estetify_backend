<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
	

    /** @test */
	public function can_user_register()
	{	
		$user = User::factory()->make();
		
		$userArray = [
			"name" => $user->name,
			"email" => $user->email,
			"password" => $user->password,
			"password_confirmation" => $user->password,
			"device_name" => "test_api"
		];
		
		$response = $this->postJson(
            route('register'),
            $userArray
        );
		// We assert that we get back a status 201:
        // Resource Created for now.
		$response->assertCreated();
        // Assert that at least one column gets returned from the response
        // in the format we need .
        $response->assertJson([
			'user' => ['name' => $user->name]
		]);
        // Assert the table properties contains the factory we made.
        $this->assertDatabaseHas(
			'users', 
			[
				"email" => $userArray["email"],
				"name" => $userArray["name"],
			]
		);
	}

	/** @test */
	public function user_can_login(){
		$user = User::factory()->create();
		
		$userArray = [
			"email" => $user->email,
			"password" => "password",
			"device_name" => "test_api"
		];
		
		$response = $this->postJson(
            route('login'),
            $userArray
        );

		$response->assertJson([
			'user' => ['name' => $user->name]
		]);
	}
}
