<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testRegistersSuccessfully()
    {
    	$payload = [
    		'name' => 'Stan',
    		'email' => 'stan@lee.com',
    		'password' => 'stan.lee123',
    		'password_confirmation' => 'stan.lee123',
    	];

    	$this->json('POST', '/api/register', $payload)
    		->assertResponseStatus(201)
    		->seeJsonStructure([
    			'data' => [
    				'id',
    				'name',
    				'email',
    				'created_at',
    				'updated_at',
    				'api_token'
    			]
    		]);
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/register')
            ->assertResponseStatus(422)
            ->seeJson([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testRequirePasswordConfirmation()
    {
    	$payload = [
    		'name' => 'Stan',
    		'email' => 'stan@lee.com',
    		'password' => 'stan.lee123',
    	];

    	$this->json('POST', '/api/register', $payload)
    		->assertResponseStatus(422)
    		->seeJson([
    			'password' => ['The password confirmation does not match.'],
    		]);
    }


}
