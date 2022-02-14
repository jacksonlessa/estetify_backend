<?php

namespace Tests\Feature\Api;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProvidersTest extends TestCase
{
    use RefreshDatabase;
	
	public $routePrefix = "providers.";

	public function setUp () : void{
		parent::setUp();

		\App\Models\Account::factory()
            ->count(1)
            ->hasUsers(2)
            ->hasClients(10)
            ->hasProfessionals(1)
			->hasProviders(16)
            ->create();

		// set User to make request
		Sanctum::actingAs(
			User::first(),
			['*']
		);
	}
    /** @test */
	public function can_get_all_providers()
	{
		$response = $this->getJson(route($this->routePrefix.'index'));
		
		// We will only assert that the response returns a 200 status for now.
		$response->assertOk(); 

		$responseArray = json_decode($response->getContent());

		$this->assertEquals(count($responseArray->data), "15");
	}

	/** @test */
	public function can_get_all_providers_correct_format_and_paginate()
	{
		$providers = Provider::where('account_id', Auth::user()->account_id)->orderBy("name", "ASC")->skip(15)->limit(15)->get();
		$response = $this->getJson(
			route($this->routePrefix.'index' , [
				"page" => 2 
			]));

		// We will only assert that the response returns a 200 status for now.
		$response->assertOk(); 

		// We will assert if we have the correct page and content format for resource
		$response->assertJson([
			'current_page' => 2,
			'data' => [
				0 => [
					"id" => $providers[0]->id,
					"account_id" => $providers[0]->account_id,
					"name" => $providers[0]->name,
					"description" => $providers[0]->description,
					"document" => $providers[0]->document,
					"deleted_at" => $providers[0]->deleted_at,
					"created_at" => $providers[0]->created_at->toJSON(),
					"updated_at" => $providers[0]->updated_at->toJSON(),
				]
			],
			'from' => 16,
			'per_page' => 15,
			'to' => 16,
		]);
	}

	/** @test */
	public function can_get_one_provider()
	{
		$provider = Provider::where('account_id', Auth::user()->account_id)->first();
		$response = $this->getJson(
			route($this->routePrefix.'show' , $provider->id));

		// We will only assert that the response returns a 200 status for now.
		$response->assertOk(); 
		
		$response->assertJson([
			"id" => $provider->id,
			"account_id" => $provider->account_id,
			"name" => $provider->name,
			"description" => $provider->description,
			"document" => $provider->document,
			"deleted_at" => $provider->deleted_at,
			"created_at" => $provider->created_at->toJSON(),
			"updated_at" => $provider->updated_at->toJSON(),
		]);
	}

	/** @test */
	public function can_store_providers()
	{
		$provider = Provider::factory()->make([
			"account_id" => Auth::user()->account_id
		]);


		$response = $this->postJson(
            route($this->routePrefix.'store'),
			$provider->toArray()
        );

		$response->assertCreated();

		$response->assertJson([
			'message' => 'resource created',
			'data' => $provider->toArray()
		]);

		$this->assertDatabaseHas('providers', $provider->toArray());
	}

	/** @test */
	public function can_update_providers()
	{
		$provider = Provider::factory()->create([
			"account_id" => Auth::user()->account_id
		]);
		$provider2 = Provider::factory()->make([
			"account_id" => Auth::user()->account_id
		]);


		$response = $this->putJson(
            route($this->routePrefix.'update', $provider->id),
			$provider2->toArray()
        );


		$response->assertJson([
			'message' => 'resource updated',
			"data" => $provider2->toArray()
		]);

		$this->assertDatabaseHas('providers', $provider2->toArray());
	}

	/** @test */
	public function can_delete_providers()
	{
		$provider = Provider::factory()->make([
			"account_id" => Auth::user()->account_id
		]);

		$response = $this->postJson(
            route($this->routePrefix.'store'),
			$provider->toArray()
        );

		$this->assertDatabaseHas('providers', $provider->toArray());


		$response = $this->deleteJson(
            route($this->routePrefix.'destroy', $response['data']['id'])
        );

		$response->assertJson([
			'message' => 'resource deleted'
		]);
		$provider->deleted_at = null;

		$this->assertDatabaseMissing('providers', $provider->toArray());
	}
}
