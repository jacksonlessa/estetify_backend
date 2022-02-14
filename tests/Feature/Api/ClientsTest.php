<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Provider;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use stdClass;
use Tests\TestCase;

class ClientsTest extends TestCase
{
    use RefreshDatabase;

	public $routePrefix = "clients.";
	
	public function setUp () : void
	{
		parent::setUp();

		// Seed account with user and clients
		\App\Models\Account::factory()
            ->count(1)
            ->hasUsers(2)
            ->hasClients(16)
            ->create();

		// set User to make request
		Sanctum::actingAs(
			User::first(),
			['*']
		);
	}
	
    /** @test */
	public function can_get_all_clients()
	{
		$response = $this->getJson(route($this->routePrefix.'index'));
		
		// We will only assert that the response returns a 200 status for now.
		$response->assertOk(); 

		$responseArray = json_decode($response->getContent());

		$this->assertEquals(count($responseArray->data), "15");
	}

	/** @test */
	public function can_get_all_clients_correct_format_and_paginate()
	{
		$client = Client::where('account_id', Auth::user()->account_id)->orderBy("name", "ASC")->skip(15)->limit(15)->get();
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
					"id" => $client[0]->id,
					"account_id" => $client[0]->account_id,
					"name" => $client[0]->name,
					"birthdate" => $client[0]->birthdate,
					"document" => $client[0]->document,
					"phone" => $client[0]->phone,
					"email" => $client[0]->email,
					"deleted_at" => $client[0]->deleted_at,
					"created_at" => $client[0]->created_at->toJSON(),
					"updated_at" => $client[0]->updated_at->toJSON(),
				]
			],
			'from' => 16,
			'per_page' => 15,
			'to' => 16,
		]);
	}

	/** @test */
	public function can_get_one_client()
	{
		$client = Client::where('account_id', Auth::user()->account_id)->first();
		$response = $this->getJson(
			route($this->routePrefix.'show' , $client->id));

		// We will only assert that the response returns a 200 status for now.
		$response->assertOk(); 
		
		$response->assertJson([
			"id" => $client->id,
			"account_id" => $client->account_id,
			"name" => $client->name,
			"birthdate" => $client->birthdate,
			"document" => $client->document,
			"phone" => $client->phone,
			"email" => $client->email,
			"deleted_at" => $client->deleted_at,
			"created_at" => $client->created_at->toJSON(),
			"updated_at" => $client->updated_at->toJSON(),
		]);
	}

	/** @test */
	public function can_store_clients()
	{
		$client = Client::factory()->make([
			"account_id" => Auth::user()->account_id
		]);


		$response = $this->postJson(
            route($this->routePrefix.'store'),
			$client->toArray()
        );

		$response->assertCreated();

		$response->assertJson([
			'message' => 'resource created',
			'data' => $client->toArray()
		]);

		$this->assertDatabaseHas('clients', $client->toArray());
	}

	/** @test */
	public function can_update_clients()
	{
		$client = Client::factory()->create([
			"account_id" => Auth::user()->account_id
		]);
		$client2 = Client::factory()->make([
			"account_id" => Auth::user()->account_id
		]);


		$response = $this->putJson(
            route($this->routePrefix.'update', $client->id),
			$client2->toArray()
        );


		$response->assertJson([
			'message' => 'resource updated',
			"data" => $client2->toArray()
		]);

		$this->assertDatabaseHas('clients', $client2->toArray());
	}


	/** @test */
	public function can_delete_clients()
	{
		$client = Client::factory()->make([
			"account_id" => Auth::user()->account_id
		]);

		$response = $this->postJson(
            route($this->routePrefix.'store'),
			$client->toArray()
        );

		$this->assertDatabaseHas('clients', $client->toArray());


		$response = $this->deleteJson(
            route($this->routePrefix.'destroy', $response['data']['id'])
        );

		$response->assertJson([
			'message' => 'resource deleted'
		]);
		$client->deleted_at = null;

		$this->assertDatabaseMissing('clients', $client->toArray());
	}
}
