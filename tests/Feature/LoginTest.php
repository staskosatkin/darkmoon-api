<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
    	$this->json('POST', 'api/login')
    		->assertResponseStatus(422)
    		->seeJson([
    			'email' => ['The email field is required.'],
    			'password' => ['The password field is required.'],
    		]);
    }

    public function testUserLoginsSuccessfully()
    {
    	$user = factory(User::class)->create([
    		'email' => 'testlogin@user.com',
    		'password' => bcrypt('stan.lee123'),
    	]);

    	$payload = [
    		'email' => 'testlogin@user.com',
    		'password' => 'stan.lee123',
    	];

    	$response = $this->json('POST', 'api/login', $payload);
    	
    	$response->assertResponseStatus(200)
			->seeJsonStructure([
				'data' => [
					'id',
					'name',
					'email',
					'created_at',
					'updated_at',
					'api_token',
				],
		]);
    }
}
