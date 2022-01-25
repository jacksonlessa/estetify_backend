<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

	/** @test */
	public function user_can_create_account(){
		Sanctum::actingAs(
			User::factory()->create(),
			['*']
		);

		$account = Account::factory()->make();


		$response = $this->postJson(
            route('accounts.store'),
			[
				"name" => $account->name,
				"document" => $account->document,
				"activity" => $account->activity,
				"phone" => $account->phone,
			]
        );	

		$response->assertCreated();

		$response->assertJson([
			"name" => $account->name,
			"document" => $account->document,
			"activity" => $account->activity,
			"phone" => $account->phone,
		]);
		
		$this->assertDatabaseHas(
			'accounts', 
			[
				"name" => $account->name,
				"document" => $account->document,
				"activity" => $account->activity,
			]
		);
	}

	/** @test */
	public function user_can_select_plan(){
		Sanctum::actingAs(
			User::factory()->create(),
			['*']
		);

		$accountFactory = Account::factory()->make();


		$account = $this->postJson(
            route('accounts.store'),
            [
				"name" => $accountFactory->name,
				"document" => $accountFactory->document,
				"activity" => $accountFactory->activity,
				"phone" => $accountFactory->phone,
			]
        );

		$response = $this->postJson(
            route('accounts.plan'),
			[
				"id" => $accountFactory->plan_id,
				"features" => $accountFactory->features,
			]
        );

		$response->assertJson([
			"name" => $accountFactory->name,
			"document" => $accountFactory->document,
			"activity" => $accountFactory->activity,
			"phone" => $accountFactory->phone,
			"plan_id" => $accountFactory->plan_id,
			"features" => $accountFactory->features,
		]);
		
		$this->assertDatabaseHas(
			'accounts', 
			[
				"name" => $accountFactory->name,
				"document" => $accountFactory->document,
				"activity" => $accountFactory->activity,
				"phone" => $accountFactory->phone,
				"plan_id" => $accountFactory->plan_id,
				// "features" =>  $accountFactory->features,
			]
		);
		
	}
}
