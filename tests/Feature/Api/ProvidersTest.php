<?php

namespace Tests\Feature\Api;

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProvidersTest extends TestCase
{
    use RefreshDatabase;
	

    /** @test */
	// public function can_get_all_providers()
	// {
	// 	// Create Property so that the response returns it.
	// 	$property = Provider::factory()->create();
		
	// 	$response = $this->getJson(route('api.provider.index'));
	// 	// We will only assert that the response returns a 200 status for now.
	// 	$response->assertOk(); 
	// }
}
