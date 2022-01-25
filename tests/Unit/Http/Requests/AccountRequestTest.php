<?php

namespace Tests\Unit\Http\Requests;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccountRequestTest extends TestCase
{
    
    use RefreshDatabase;

    private $routePrefix = 'accounts.';

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function name_is_required()  
    {  
        $validatedField = 'name';  
        $brokenRule = null;  

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors($validatedField);
    }

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function document_is_required()  
    {  
        $validatedField = 'document';  
        $brokenRule = null;  

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors($validatedField);
    }

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function document_must_not_exceed_18_characters()  
    {  
        $validatedField = 'document';  
        $brokenRule = Str::random(19);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors($validatedField);
    }

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function activity_is_required()  
    {  
        $validatedField = 'activity';  
        $brokenRule = null;  

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors($validatedField);
    }

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function other_activity_is_required_if_activity_Outro()  
    {  
        $validatedField = 'activity';  
        $brokenRule = "Outro";  

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors("other_activity");
    }

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function phone_is_required()  
    {  
        $validatedField = 'phone';  
        $brokenRule = null;  

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors($validatedField);
    }

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function phone_must_not_exceed_15_characters()  
    {  
        $validatedField = 'phone';  
        $brokenRule = Str::random(16);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $account = Account::factory()->make([  
            $validatedField => $brokenRule  
        ]);


        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            [
                "name" => $account->name,
                "document" => $account->document,
                "activity" => $account->activity,
                "phone" => $account->phone,
            ]
        )->assertJsonValidationErrors($validatedField);
    }
}
